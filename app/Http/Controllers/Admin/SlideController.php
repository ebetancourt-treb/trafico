<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        return view('admin.slides.index', [
            'slides' => Slide::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.slides.form', ['slide' => new Slide()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120',
            'side_image' => 'nullable|image|max:5120',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        if ($request->hasFile('side_image')) {
            $data['side_image'] = $request->file('side_image')->store('slides', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        Slide::create($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide creado correctamente.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.form', ['slide' => $slide]);
    }

    public function update(Request $request, Slide $slide)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'side_image' => 'nullable|image|max:5120',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slide->image) Storage::disk('public')->delete($slide->image);
            $data['image'] = $request->file('image')->store('slides', 'public');
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('side_image')) {
            if ($slide->side_image) Storage::disk('public')->delete($slide->side_image);
            $data['side_image'] = $request->file('side_image')->store('slides', 'public');
        } else {
            unset($data['side_image']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $slide->update($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide actualizado correctamente.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image) Storage::disk('public')->delete($slide->image);
        if ($slide->side_image) Storage::disk('public')->delete($slide->side_image);

        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide eliminado correctamente.');
    }
}
