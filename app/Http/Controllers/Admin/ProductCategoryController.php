<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.product-categories.index', [
            'categories' => ProductCategory::withCount('products')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.product-categories.form', ['category' => new ProductCategory()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'custom_icon' => 'nullable|image|mimes:png,svg,webp|max:1024',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('custom_icon')) {
            $data['custom_icon'] = $request->file('custom_icon')->store('categories', 'public');
            $data['icon'] = null; // Si sube icono personalizado, limpiar el icono de Lucide
        }

        unset($data['custom_icon_file']);
        ProductCategory::create($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-categories.form', ['category' => $productCategory]);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'custom_icon' => 'nullable|image|mimes:png,svg,webp|max:1024',
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('custom_icon')) {
            if ($productCategory->custom_icon) {
                Storage::disk('public')->delete($productCategory->custom_icon);
            }
            $data['custom_icon'] = $request->file('custom_icon')->store('categories', 'public');
            $data['icon'] = null;
        } else {
            unset($data['custom_icon']);
        }

        // Si seleccionó un icono de Lucide, eliminar el icono personalizado
        if (!empty($data['icon']) && $productCategory->custom_icon) {
            Storage::disk('public')->delete($productCategory->custom_icon);
            $data['custom_icon'] = null;
        }

        // Si marcó eliminar icono personalizado
        if ($request->boolean('remove_custom_icon') && $productCategory->custom_icon) {
            Storage::disk('public')->delete($productCategory->custom_icon);
            $data['custom_icon'] = null;
        }

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->custom_icon) {
            Storage::disk('public')->delete($productCategory->custom_icon);
        }
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
