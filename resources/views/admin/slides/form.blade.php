@extends('layouts.admin')

@section('title', $slide->exists ? 'Editar Slide' : 'Nuevo Slide')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.slides.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver a slides
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <form action="{{ $slide->exists ? route('admin.slides.update', $slide) : route('admin.slides.store') }}"
                  method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @if($slide->exists) @method('PUT') @endif

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $slide->title) }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $slide->subtitle) }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="cta_text" class="block text-sm font-medium text-gray-700 mb-1">Texto del botón</label>
                        <input type="text" name="cta_text" id="cta_text" value="{{ old('cta_text', $slide->cta_text) }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none">
                    </div>
                    <div>
                        <label for="cta_url" class="block text-sm font-medium text-gray-700 mb-1">URL del botón</label>
                        <input type="text" name="cta_url" id="cta_url" value="{{ old('cta_url', $slide->cta_url) }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none">
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagen principal {{ $slide->exists ? '' : '*' }}</label>
                    @if($slide->image)
                        <img src="{{ asset('storage/' . $slide->image) }}" class="w-40 h-24 object-cover rounded-lg mb-2" alt="">
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="side_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen lateral (derecha)</label>
                    @if($slide->side_image)
                        <img src="{{ asset('storage/' . $slide->side_image) }}" class="w-40 h-24 object-cover rounded-lg mb-2" alt="">
                    @endif
                    <input type="file" name="side_image" id="side_image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 file:cursor-pointer">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $slide->order ?? 0) }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none">
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-navy-800 focus:ring-navy-500">
                            <span class="text-sm text-gray-700">Activo</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">
                        {{ $slide->exists ? 'Actualizar' : 'Crear' }} Slide
                    </button>
                    <a href="{{ route('admin.slides.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

@endsection
