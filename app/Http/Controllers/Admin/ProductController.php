<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'datasheet_pdf' => 'nullable|mimes:pdf|max:10240',
            'order' => 'integer',
            'is_active' => 'boolean',
            'gallery.*' => 'image|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('datasheet_pdf')) {
            $data['datasheet_pdf'] = $request->file('datasheet_pdf')->store('datasheets', 'public');
        }

        unset($data['gallery']);
        $product = Product::create($data);

        // Guardar imágenes de galería
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('products/gallery', 'public'),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.form', [
            'product' => $product,
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'datasheet_pdf' => 'nullable|mimes:pdf|max:10240',
            'order' => 'integer',
            'is_active' => 'boolean',
            'gallery.*' => 'image|max:5120',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('datasheet_pdf')) {
            if ($product->datasheet_pdf) Storage::disk('public')->delete($product->datasheet_pdf);
            $data['datasheet_pdf'] = $request->file('datasheet_pdf')->store('datasheets', 'public');
        } else {
            unset($data['datasheet_pdf']);
        }

        // Opción para eliminar PDF
        if ($request->boolean('remove_pdf') && $product->datasheet_pdf) {
            Storage::disk('public')->delete($product->datasheet_pdf);
            $data['datasheet_pdf'] = null;
        }

        unset($data['gallery']);
        $product->update($data);

        // Agregar nuevas imágenes de galería
        if ($request->hasFile('gallery')) {
            $maxOrder = $product->images()->max('order') ?? 0;
            foreach ($request->file('gallery') as $index => $file) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $file->store('products/gallery', 'public'),
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        // Eliminar imágenes marcadas
        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->input('delete_images'))->where('product_id', $product->id)->get();
            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->datasheet_pdf) Storage::disk('public')->delete($product->datasheet_pdf);

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
