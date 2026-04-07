@extends('layouts.admin')
@section('title', 'Galería')
@section('header-actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.gallery.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nueva Imagen</a>
        <button onclick="document.getElementById('bulk-upload-modal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2"><i data-lucide="upload" class="w-4 h-4"></i> Subida masiva</button>
    </div>
@endsection
@section('content')

{{-- Filtros por categoría --}}
<div class="flex flex-wrap items-center gap-2 mb-6">
    <a href="{{ route('admin.gallery.index') }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ !$currentFilter ? 'bg-navy-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
        Todas ({{ $images->count() }})
    </a>
    @foreach($categories as $cat)
        <a href="{{ route('admin.gallery.index', ['category' => $cat->id]) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $currentFilter == $cat->id ? 'bg-navy-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ $cat->name }} ({{ $cat->images_count }})
        </a>
    @endforeach
    <a href="{{ route('admin.gallery.index', ['category' => 'uncategorized']) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $currentFilter === 'uncategorized' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
        Sin categoría ({{ $uncategorizedCount }})
    </a>
</div>

{{-- Grid de imágenes --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($images as $img)
        <div class="group relative bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->title }}" class="w-full aspect-square object-cover">
            {{-- Overlay con acciones --}}
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.gallery.edit', $img) }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-blue-50 transition">
                        <i data-lucide="pencil" class="w-4 h-4 text-blue-600"></i>
                    </a>
                    <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button class="w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-red-50 transition">
                            <i data-lucide="trash-2" class="w-4 h-4 text-red-600"></i>
                        </button>
                    </form>
                </div>
            </div>
            {{-- Info --}}
            <div class="p-3">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $img->title ?? 'Sin título' }}</p>
                <div class="flex items-center justify-between mt-1">
                    @if($img->galleryCategory)
                        <span class="text-xs bg-navy-50 text-navy-700 px-2 py-0.5 rounded-full">{{ $img->galleryCategory->name }}</span>
                    @else
                        <span class="text-xs bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full">Sin categoría</span>
                    @endif
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs {{ $img->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $img->is_active ? 'Activo' : 'Inactivo' }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-400">
            <i data-lucide="image" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
            <p>No hay imágenes{{ $currentFilter ? ' en este filtro' : '' }}.</p>
        </div>
    @endforelse
</div>

{{-- Modal subida masiva --}}
<div id="bulk-upload-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50" onclick="document.getElementById('bulk-upload-modal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-lg text-gray-800">Subida masiva de imágenes</h3>
            <button onclick="document.getElementById('bulk-upload-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <form action="{{ route('admin.gallery.bulk-store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select name="gallery_category_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                    <option value="">Sin categoría</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imágenes *</label>
                <input type="file" name="images[]" accept="image/*" multiple required class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer">
                <p class="text-xs text-gray-400 mt-1">Selecciona múltiples imágenes. Máximo 5MB cada una.</p>
            </div>
            <button type="submit" class="w-full bg-navy-800 text-white py-3 rounded-lg font-semibold text-sm hover:bg-navy-700 transition">Subir imágenes</button>
        </form>
    </div>
</div>

@endsection
