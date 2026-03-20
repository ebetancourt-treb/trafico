<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');

        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $allSettings = SiteSetting::all();

        foreach ($allSettings as $setting) {
            $key = $setting->key;

            if ($setting->type === 'image' || $setting->type === 'file') {
                if ($request->hasFile("settings.{$key}")) {
                    // Borrar archivo anterior
                    if ($setting->value) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    $path = $request->file("settings.{$key}")->store('settings', 'public');
                    $setting->update(['value' => $path]);
                }
            } else {
                if ($request->has("settings.{$key}")) {
                    $setting->update(['value' => $request->input("settings.{$key}")]);
                }
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Configuración actualizada correctamente.');
    }
}
