<?php

namespace App\Http\Controllers;

use App\Models\CompanyValue;
use App\Models\GalleryImage;
use App\Models\Industry;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProductCategory;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\Slide;

class PageController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'slides' => Slide::active()->get(),
            'nosotros' => Section::getBySlug('nosotros'),
            'values' => CompanyValue::active()->get(),
            'categories' => ProductCategory::active()->with('products')->get(),
            'industries' => Industry::active()->get(),
            'galleryImages' => GalleryImage::active()->take(8)->get(),
        ]);
    }

    public function about()
    {
        return view('public.about', [
            'nosotros' => Section::getBySlug('nosotros'),
            'mision' => Section::getBySlug('mision'),
            'vision' => Section::getBySlug('vision'),
            'values' => CompanyValue::active()->get(),
        ]);
    }

    public function products()
    {
        // Cargar categorías con solo los últimos 4 productos activos y el conteo total
        $categories = ProductCategory::active()
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->with(['products' => fn($q) => $q->active()->take(4)])
            ->get();

        return view('public.products', [
            'categories' => $categories,
        ]);
    }

    public function productCategory(ProductCategory $category)
    {
        $category->load(['products' => fn($q) => $q->active()]);

        return view('public.product-category', [
            'category' => $category,
        ]);
    }

    public function productDetail(ProductCategory $category, Product $product)
    {
        // Verificar que el producto pertenece a la categoría
        if ($product->product_category_id !== $category->id) {
            abort(404);
        }

        $product->load('images');

        // Productos relacionados (misma categoría, excluyendo el actual)
        $related = Product::active()
            ->where('product_category_id', $category->id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('public.product-detail', [
            'category' => $category,
            'product' => $product,
            'related' => $related,
        ]);
    }

    public function gallery()
    {
        return view('public.gallery', [
            'images' => GalleryImage::active()->get(),
        ]);
    }

    public function industries()
    {
        $industries = Industry::active()
            ->with([
                'subcategories' => fn($q) => $q->active()->with(['projects' => fn($p) => $p->active()]),
                'projects' => fn($q) => $q->active(),
            ])
            ->get();

        return view('public.industries', [
            'industries' => $industries,
        ]);
    }

    public function industryProjects(Industry $industry)
    {
        $industry->load([
            'subcategories' => fn($q) => $q->active()->with(['projects' => fn($p) => $p->active()]),
            'projects' => fn($q) => $q->active(),
        ]);

        return view('public.industry-projects', [
            'industry' => $industry,
        ]);
    }

    public function projectDetail(Industry $industry, Project $project)
    {
        if ($project->industry_id !== $industry->id) {
            abort(404);
        }

        $project->load('images', 'subcategory');

        $related = Project::active()
            ->where('industry_id', $industry->id)
            ->where('id', '!=', $project->id)
            ->take(4)
            ->get();

        return view('public.project-detail', [
            'industry' => $industry,
            'project' => $project,
            'related' => $related,
        ]);
    }

    public function contact()
    {
        return view('public.contact');
    }
}
