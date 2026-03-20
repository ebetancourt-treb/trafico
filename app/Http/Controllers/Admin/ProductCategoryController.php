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
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

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
            'description' => 'nullable|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
