@extends('layouts.admin')
@section('title', 'Galería')
@section('header-actions')
    <a href="{{ route('admin.gallery.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nueva Imagen</a>
@endsection
@section('content')
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($images as $img)
        <div class="group relative bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->title }}" class="w-full aspect-square object-cover">
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
            <div class="p-3">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $img->title ?? 'Sin título' }}</p>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-xs text-gray-400">Orden: {{ $img->order }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs {{ $img->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $img->is_active ? 'Activo' : 'Inactivo' }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-400">
            <i data-lucide="image" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
            <p>No hay imágenes en la galería.</p>
        </div>
    @endforelse
</div>
@endsection
