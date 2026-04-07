<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        return view('admin.gallery-categories.index', [
            'categories' => GalleryCategory::withCount('images')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.gallery-categories.form', ['category' => new GalleryCategory()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        GalleryCategory::create($data);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.form', ['category' => $galleryCategory]);
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $galleryCategory->update($data);

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(GalleryCategory $galleryCategory)
    {
        // Las imágenes quedan con gallery_category_id = null (sin categoría)
        $galleryCategory->delete();

        return redirect()->route('admin.gallery-categories.index')->with('success', 'Categoría eliminada. Las imágenes pasaron a "Sin categoría".');
    }
}
