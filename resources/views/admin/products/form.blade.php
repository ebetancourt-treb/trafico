@extends('layouts.admin')
@section('title', $product->exists ? 'Editar Producto' : 'Nuevo Producto')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($product->exists) @method('PUT') @endif

            {{-- Categoría --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                <select name="product_category_id" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                    <option value="">Seleccionar...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('product_category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Descripción corta --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción corta</label>
                <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" maxlength="500" placeholder="Resumen breve del producto (se muestra en las tarjetas)"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                <p class="text-xs text-gray-400 mt-1">Máximo 500 caracteres. Se muestra en los listados.</p>
            </div>

            {{-- Descripción completa --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción completa</label>
                <textarea name="description" rows="5" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Imagen principal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Imagen principal</label>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-40 h-28 object-cover rounded-lg mb-2">
                @endif
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
            </div>

            {{-- PDF Ficha Técnica --}}
            <div class="bg-red-50/50 rounded-lg p-5 border border-red-100">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    <i data-lucide="file-text" class="w-4 h-4 inline text-red-500"></i>
                    Ficha Técnica (PDF)
                </label>
                @if($product->datasheet_pdf)
                    <div class="flex items-center gap-3 mb-3 bg-white rounded-lg p-3">
                        <i data-lucide="file-text" class="w-8 h-8 text-red-500"></i>
                        <div class="flex-1">
                            <a href="{{ asset('storage/' . $product->datasheet_pdf) }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">
                                Ver PDF actual
                            </a>
                            <p class="text-xs text-gray-400">{{ basename($product->datasheet_pdf) }}</p>
                        </div>
                        <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                            <input type="checkbox" name="remove_pdf" value="1" class="w-4 h-4 rounded border-gray-300 text-red-600">
                            Eliminar
                        </label>
                    </div>
                @endif
                <input type="file" name="datasheet_pdf" accept=".pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-600 file:text-white hover:file:bg-red-700 file:cursor-pointer">
                <p class="text-xs text-gray-400 mt-1">Sube un PDF con las especificaciones técnicas. Máximo 10MB. Los visitantes podrán descargarlo.</p>
            </div>

            {{-- Galería de imágenes --}}
            <div class="bg-blue-50/50 rounded-lg p-5 border border-blue-100">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i data-lucide="images" class="w-4 h-4 inline text-blue-500"></i>
                    Galería de fotos del producto
                </label>

                {{-- Imágenes existentes --}}
                @if($product->exists && $product->images->count())
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-3 mb-4">
                        @foreach($product->images as $img)
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

                {{-- Subir nuevas --}}
                <input type="file" name="gallery[]" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer">
                <p class="text-xs text-gray-400 mt-1">Puedes seleccionar múltiples imágenes. Máximo 5MB cada una.</p>
            </div>

            {{-- Orden y estado --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                    <input type="number" name="order" value="{{ old('order', $product->order ?? 0) }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-navy-800">
                        <span class="text-sm text-gray-700">Activo</span>
                    </label>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">{{ $product->exists ? 'Actualizar' : 'Crear' }} Producto</button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
