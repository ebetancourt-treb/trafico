<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Compartir settings con todas las vistas
        View::composer('*', function ($view) {
            if (Schema::hasTable('site_settings')) {
                $siteSettings = SiteSetting::all()->pluck('value', 'key');
                $view->with('siteSettings', $siteSettings);
            }
        });
    }
}
