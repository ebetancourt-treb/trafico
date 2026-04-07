@extends('layouts.admin')
@section('title', $galleryImage->exists ? 'Editar Imagen' : 'Nueva Imagen')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.gallery.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                <ul class="list-disc list-inside text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <form action="{{ $galleryImage->exists ? route('admin.gallery.update', $galleryImage) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @if($galleryImage->exists) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select name="gallery_category_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                    <option value="">Sin categoría</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('gallery_category_id', $galleryImage->gallery_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="title" value="{{ old('title', $galleryImage->title) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none resize-none">{{ old('description', $galleryImage->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen {{ $galleryImage->exists ? '' : '*' }}</label>
                @if($galleryImage->exists && $galleryImage->image)
                    <img src="{{ asset('storage/' . $galleryImage->image) }}" class="w-40 h-40 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*" {{ $galleryImage->exists ? '' : 'required' }} class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $galleryImage->order ?? 0) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $galleryImage->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-navy-800">
                        <span class="text-sm text-gray-700">Activo</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">{{ $galleryImage->exists ? 'Actualizar' : 'Subir' }}</button>
                <a href="{{ route('admin.gallery.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
