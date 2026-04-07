<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryImage::with('galleryCategory')->orderBy('order');

        // Filtro por categoría
        if ($request->has('category')) {
            if ($request->category === 'uncategorized') {
                $query->whereNull('gallery_category_id');
            } elseif ($request->category) {
                $query->where('gallery_category_id', $request->category);
            }
        }

        return view('admin.gallery.index', [
            'images' => $query->get(),
            'categories' => GalleryCategory::withCount('images')->orderBy('order')->get(),
            'currentFilter' => $request->category,
            'uncategorizedCount' => GalleryImage::whereNull('gallery_category_id')->count(),
        ]);
    }

    public function create()
    {
        return view('admin.gallery.form', [
            'galleryImage' => new GalleryImage(),
            'categories' => GalleryCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'image' => 'required|image|max:5120',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');
        $data['is_active'] = $request->boolean('is_active');

        GalleryImage::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Imagen agregada correctamente.');
    }

    // Subida masiva de imágenes
    public function bulkStore(Request $request)
    {
        $request->validate([
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'images.*' => 'image|max:5120',
        ]);

        $count = 0;
        $maxOrder = GalleryImage::max('order') ?? 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                GalleryImage::create([
                    'gallery_category_id' => $request->gallery_category_id,
                    'image' => $file->store('gallery', 'public'),
                    'order' => $maxOrder + $count + 1,
                    'is_active' => true,
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', "{$count} imágenes subidas correctamente.");
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.form', [
            'galleryImage' => $gallery,
            'categories' => GalleryCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'gallery_category_id' => 'nullable|exists:gallery_categories,id',
            'image' => 'nullable|image|max:5120',
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
