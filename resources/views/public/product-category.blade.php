@extends('layouts.public')

@section('title', $category->name . ' - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('products') }}" class="inline-flex items-center gap-1 text-gray-400 hover:text-white transition mb-4 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver a productos
            </a>
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-400 mt-3 max-w-2xl">{{ $category->description }}</p>
            @endif
            <p class="text-gray-500 mt-2 text-sm">{{ $category->products->count() }} {{ $category->products->count() === 1 ? 'producto' : 'productos' }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($category->products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($category->products as $product)
                        <a href="{{ route('products.detail', [$category->slug, $product->slug]) }}"
                           class="fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group block">
                            @if($product->image)
                                <div class="overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                         class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i data-lucide="package" class="w-16 h-16 text-gray-300"></i>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="font-display font-semibold text-xl text-navy-800 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $product->name }}
                                </h3>
                                @if($product->short_description)
                                    <p class="text-gray-500 leading-relaxed line-clamp-3">{{ $product->short_description }}</p>
                                @elseif($product->description)
                                    <p class="text-gray-500 leading-relaxed line-clamp-3">{{ $product->description }}</p>
                                @endif

                                <div class="mt-4 flex items-center gap-2">
                                    @if($product->datasheet_pdf)
                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-xs px-2.5 py-1 rounded-full font-medium">
                                            <i data-lucide="file-text" class="w-3 h-3"></i> Ficha técnica
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center gap-1 text-navy-600 text-sm font-medium ml-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        Ver detalle <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i data-lucide="package-open" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-400 text-lg">Próximamente más productos en esta categoría.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
