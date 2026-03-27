@extends('layouts.admin')
@section('title', $project->exists ? 'Editar Proyecto' : 'Nuevo Proyecto')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-2 mb-2"><i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i><span class="font-medium">Errores:</span></div>
                <ul class="list-disc list-inside text-sm space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($project->exists) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría (Industria) *</label>
                <select name="industry_id" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                    <option value="">Seleccionar...</option>
                    @foreach($industries as $ind)
                        <option value="{{ $ind->id }}" {{ old('industry_id', $project->industry_id) == $ind->id ? 'selected' : '' }}>{{ $ind->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del proyecto *</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" required placeholder="Ej: Privada Santa Fe" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
                    <input type="text" name="location" value="{{ old('location', $project->location) }}" placeholder="Ej: Torreón, Coahuila" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <input type="text" name="client" value="{{ old('client', $project->client) }}" placeholder="Ej: Grupo Constructor XYZ" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción corta</label>
                <input type="text" name="short_description" value="{{ old('short_description', $project->short_description) }}" maxlength="500" placeholder="Resumen breve del proyecto" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción completa</label>
                <textarea name="description" rows="5" placeholder="Detalla los trabajos realizados, materiales, alcance, etc." class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none resize-none">{{ old('description', $project->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen principal</label>
                @if($project->image) <img src="{{ asset('storage/' . $project->image) }}" class="w-40 h-28 object-cover rounded-lg mb-2"> @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
            </div>

            {{-- Galería --}}
            <div class="bg-blue-50/50 rounded-lg p-5 border border-blue-100">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i data-lucide="images" class="w-4 h-4 inline text-blue-500"></i>
                    Galería de fotos del proyecto
                </label>

                @if($project->exists && $project->images->count())
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3 mb-4">
                        @foreach($project->images as $img)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $img->image) }}" class="w-full aspect-square object-cover rounded-lg">
                                <label class="absolute inset-0 bg-red-500/0 group-hover:bg-red-500/60 rounded-lg flex items-center justify-center cursor-pointer transition-all duration-200">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="sr-only peer">
                                    <div class="opacity-0 group-hover:opacity-100 peer-checked:opacity-100 transition">
                                        <i data-lucide="trash-2" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <div class="absolute top-1 right-1 w-5 h-5 bg-white rounded-full items-center justify-center hidden peer-checked:flex">
                                        <i data-lucide="x" class="w-3 h-3 text-red-500"></i>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mb-3">Haz clic en las imágenes que quieras eliminar.</p>
                @endif

                <input type="file" name="gallery[]" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer">
                <p class="text-xs text-gray-400 mt-1">Selecciona múltiples imágenes. Máximo 5MB cada una.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $project->order ?? 0) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-navy-800">
                        <span class="text-sm text-gray-700">Activo</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">{{ $project->exists ? 'Actualizar' : 'Crear' }} Proyecto</button>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
