@extends('layouts.public')

@section('title', 'Productos - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Nuestros Productos</h1>
            <p class="text-gray-400 mt-3">Soluciones completas en señalamiento y pintura vial</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($categories as $category)
                <div class="mb-16 fade-up" id="{{ $category->slug }}">
                    {{-- Título de categoría clickeable --}}
                    <div class="flex items-center justify-between mb-8">
                        <a href="{{ route('products.category', $category->slug) }}"
                           class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-xl bg-navy-800 flex items-center justify-center group-hover:bg-amber-500 transition-colors duration-300">
                                @php
                                    $icons = ['road-sign' => 'signpost', 'paint-bucket' => 'paintbrush', 'cone' => 'construction', 'hard-hat' => 'hard-hat'];
                                    $icon = $icons[$category->icon] ?? 'box';
                                @endphp
                                <i data-lucide="{{ $icon }}" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h2 class="font-display font-bold text-2xl sm:text-3xl text-navy-800 group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $category->name }}
                                </h2>
                                <span class="text-sm text-gray-400">{{ $category->products_count }} {{ $category->products_count === 1 ? 'producto' : 'productos' }}</span>
                            </div>
                            <i data-lucide="chevron-right" class="w-6 h-6 text-gray-300 group-hover:text-amber-500 group-hover:translate-x-1 transition-all duration-300 ml-2"></i>
                        </a>

                        @if($category->products_count > 4)
                            <a href="{{ route('products.category', $category->slug) }}"
                               class="hidden sm:inline-flex items-center gap-2 border-2 border-navy-800 text-navy-800 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-navy-800 hover:text-white transition-all duration-300">
                                Ver todos
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>

                    @if($category->products->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($category->products as $product)
                                <a href="{{ route('products.detail', [$category->slug, $product->slug]) }}"
                                   class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                                    @if($product->image)
                                        <div class="overflow-hidden">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i data-lucide="package" class="w-12 h-12 text-gray-300"></i>
                                        </div>
                                    @endif
                                    <div class="p-5">
                                        <h3 class="font-display font-semibold text-lg text-navy-800 group-hover:text-amber-600 transition-colors duration-300">
                                            {{ $product->name }}
                                        </h3>
                                        @if($product->short_description)
                                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->short_description }}</p>
                                        @elseif($product->description)
                                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $product->description }}</p>
                                        @endif
                                        <div class="mt-3 flex items-center gap-1 text-navy-600 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            Ver detalle <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        @if($category->products_count > 4)
                            <div class="mt-6 text-center sm:hidden">
                                <a href="{{ route('products.category', $category->slug) }}"
                                   class="inline-flex items-center gap-2 border-2 border-navy-800 text-navy-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-navy-800 hover:text-white transition-all duration-300">
                                    Ver todos ({{ $category->products_count }})
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-400 italic">Próximamente más productos en esta categoría.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

@endsection
