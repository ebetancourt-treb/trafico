<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.gallery.index', [
            'images' => GalleryImage::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.gallery.form', ['galleryImage' => new GalleryImage()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'category' => 'nullable|string|max:100',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');
        $data['is_active'] = $request->boolean('is_active');

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Imagen agregada correctamente.');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.form', ['galleryImage' => $gallery]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'category' => 'nullable|string|max:100',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('gallery', 'public');
        } else {
            unset($data['image']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroy(GalleryImage $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Imagen eliminada correctamente.');
    }
}
