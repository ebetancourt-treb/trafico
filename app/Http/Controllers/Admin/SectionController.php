<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index', [
            'sections' => Section::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.sections.form', ['section' => new Section()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|string|unique:sections,slug|max:100',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sections', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        Section::create($data);

        return redirect()->route('admin.sections.index')->with('success', 'Sección creada correctamente.');
    }

    public function edit(Section $section)
    {
        return view('admin.sections.form', ['section' => $section]);
    }

    public function update(Request $request, Section $section)
    {
        $data = $request->validate([
            'slug' => 'required|string|max:100|unique:sections,slug,' . $section->id,
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($section->image) Storage::disk('public')->delete($section->image);
            $data['image'] = $request->file('image')->store('sections', 'public');
        } else {
            unset($data['image']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $section->update($data);

        return redirect()->route('admin.sections.index')->with('success', 'Sección actualizada correctamente.');
    }

    public function destroy(Section $section)
    {
        if ($section->image) Storage::disk('public')->delete($section->image);
        $section->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Sección eliminada correctamente.');
    }
}
