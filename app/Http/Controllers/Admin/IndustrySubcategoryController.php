<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\IndustrySubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class IndustrySubcategoryController extends Controller
{
    public function index()
    {
        return view('admin.subcategories.index', [
            'subcategories' => IndustrySubcategory::with('industry')->withCount('projects')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.subcategories.form', [
            'subcategory' => new IndustrySubcategory(),
            'industries' => Industry::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subcategories', 'public');
        }

        IndustrySubcategory::create($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría creada correctamente.');
    }

    public function edit(IndustrySubcategory $subcategory)
    {
        return view('admin.subcategories.form', [
            'subcategory' => $subcategory,
            'industries' => Industry::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, IndustrySubcategory $subcategory)
    {
        $data = $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($subcategory->image) Storage::disk('public')->delete($subcategory->image);
            $data['image'] = $request->file('image')->store('subcategories', 'public');
        } else {
            unset($data['image']);
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría actualizada correctamente.');
    }

    public function destroy(IndustrySubcategory $subcategory)
    {
        if ($subcategory->image) Storage::disk('public')->delete($subcategory->image);
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategoría eliminada correctamente.');
    }
}
