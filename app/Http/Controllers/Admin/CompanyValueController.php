<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyValue;
use Illuminate\Http\Request;

class CompanyValueController extends Controller
{
    public function index()
    {
        return view('admin.values.index', [
            'values' => CompanyValue::orderBy('order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.values.form', ['value' => new CompanyValue()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        CompanyValue::create($data);

        return redirect()->route('admin.values.index')->with('success', 'Valor creado correctamente.');
    }

    public function edit(CompanyValue $value)
    {
        return view('admin.values.form', ['value' => $value]);
    }

    public function update(Request $request, CompanyValue $value)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $value->update($data);

        return redirect()->route('admin.values.index')->with('success', 'Valor actualizado correctamente.');
    }

    public function destroy(CompanyValue $value)
    {
        $value->delete();

        return redirect()->route('admin.values.index')->with('success', 'Valor eliminado correctamente.');
    }
}
