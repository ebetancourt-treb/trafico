<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IndustryController extends Controller
{
    public function index()
    {
        return view('admin.industries.index', [
            'industries' => Industry::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.industries.form', ['industry' => new Industry()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string',
            'sub_items' => 'nullable|string', // comma separated
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sub_items'] = $this->parseSubItems($request->input('sub_items'));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('industries', 'public');
        }

        Industry::create($data);

        return redirect()->route('admin.industries.index')->with('success', 'Industria creada correctamente.');
    }

    public function edit(Industry $industry)
    {
        return view('admin.industries.form', ['industry' => $industry]);
    }

    public function update(Request $request, Industry $industry)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string',
            'sub_items' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['sub_items'] = $this->parseSubItems($request->input('sub_items'));

        if ($request->hasFile('image')) {
            if ($industry->image) Storage::disk('public')->delete($industry->image);
            $data['image'] = $request->file('image')->store('industries', 'public');
        } else {
            unset($data['image']);
        }

        $industry->update($data);

        return redirect()->route('admin.industries.index')->with('success', 'Industria actualizada correctamente.');
    }

    public function destroy(Industry $industry)
    {
        if ($industry->image) Storage::disk('public')->delete($industry->image);
        $industry->delete();

        return redirect()->route('admin.industries.index')->with('success', 'Industria eliminada correctamente.');
    }

    private function parseSubItems(?string $items): ?array
    {
        if (!$items) return null;
        return array_map('trim', explode(',', $items));
    }
}
