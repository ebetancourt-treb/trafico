<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CompanyValueController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\IndustrySubcategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/nosotros', [PageController::class, 'about'])->name('about');
Route::get('/productos', [PageController::class, 'products'])->name('products');
Route::get('/productos/{category:slug}', [PageController::class, 'productCategory'])->name('products.category');
Route::get('/productos/{category:slug}/{product:slug}', [PageController::class, 'productDetail'])->name('products.detail');
Route::get('/galeria', [PageController::class, 'gallery'])->name('gallery');
Route::get('/industrias', [PageController::class, 'industries'])->name('industries');
Route::get('/industrias/{industry:slug}', [PageController::class, 'industryProjects'])->name('industries.projects');
Route::get('/industrias/{industry:slug}/{project:slug}', [PageController::class, 'projectDetail'])->name('industries.project.detail');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (login simple)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Rutas Admin (protegidas por auth)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Slides
    Route::resource('slides', SlideController::class);

    // Secciones (Nosotros, Misión, Visión)
    Route::resource('sections', SectionController::class);

    // Valores
    Route::resource('values', CompanyValueController::class);

    // Categorías de productos
    Route::resource('product-categories', ProductCategoryController::class);

    // Productos
    Route::resource('products', ProductController::class);

    // Industrias
    Route::resource('industries', IndustryController::class);

    // Proyectos
    Route::resource('projects', ProjectController::class);

    // Subcategorías de industrias
    Route::resource('subcategories', IndustrySubcategoryController::class);

    // Galería
    Route::resource('gallery', GalleryController::class);

    // Mensajes de contacto
    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Configuración del sitio
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
});
