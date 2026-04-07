@extends('layouts.admin')
@section('title', $category->exists ? 'Editar Categoría' : 'Nueva Categoría de Galería')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.gallery-categories.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ $category->exists ? route('admin.gallery-categories.update', $category) : route('admin.gallery-categories.store') }}" method="POST" class="space-y-5">
            @csrf
            @if($category->exists) @method('PUT') @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required placeholder="Ej: Pintura Vial, Señalamiento, Protección en Obra" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none resize-none">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $category->order ?? 0) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-navy-800">
                        <span class="text-sm text-gray-700">Activo</span>
                    </label>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">{{ $category->exists ? 'Actualizar' : 'Crear' }}</button>
                <a href="{{ route('admin.gallery-categories.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
