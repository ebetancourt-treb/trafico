@extends('layouts.admin')
@section('title', $industry->exists ? 'Editar Industria' : 'Nueva Industria')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.industries.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ $industry->exists ? route('admin.industries.update', $industry) : route('admin.industries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($industry->exists) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $industry->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icono (Lucide)</label>
                    <input type="text" name="icon" value="{{ old('icon', $industry->icon) }}" placeholder="ej: home, building, factory" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $industry->order ?? 0) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none resize-none">{{ old('description', $industry->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sub-items (separados por coma)</label>
                <input type="text" name="sub_items" value="{{ old('sub_items', $industry->sub_items ? implode(', ', $industry->sub_items) : '') }}"
                       placeholder="Constructoras, Desarrolladores, Parques Industriales"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                <p class="text-xs text-gray-400 mt-1">Ej: Constructoras, Desarrolladores Inmobiliarios, Parques Industriales</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                @if($industry->image) <img src="{{ asset('storage/' . $industry->image) }}" class="w-40 h-24 object-cover rounded-lg mb-2"> @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $industry->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-navy-800">
                <span class="text-sm text-gray-700">Activo</span>
            </label>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">{{ $industry->exists ? 'Actualizar' : 'Crear' }}</button>
                <a href="{{ route('admin.industries.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
