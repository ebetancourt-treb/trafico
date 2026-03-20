@extends('layouts.public')

@section('title', 'Industrias - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Industrias</h1>
            <p class="text-gray-400 mt-3">Sectores a los que damos servicio</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($industries as $industry)
                    <div class="fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                        @if($industry->image)
                            <img src="{{ asset('storage/' . $industry->image) }}" alt="{{ $industry->name }}" class="w-full h-52 object-cover">
                        @endif
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-lg bg-navy-800 flex items-center justify-center">
                                    @php
                                        $indIcons = ['home' => 'home', 'building' => 'building-2', 'factory' => 'factory', 'landmark' => 'landmark'];
                                        $indIcon = $indIcons[$industry->icon] ?? 'building';
                                    @endphp
                                    <i data-lucide="{{ $indIcon }}" class="w-5 h-5 text-amber-400"></i>
                                </div>
                                <h2 class="font-display font-bold text-2xl text-navy-800">{{ $industry->name }}</h2>
                            </div>
                            @if($industry->description)
                                <p class="text-gray-600 mb-4">{{ $industry->description }}</p>
                            @endif
                            @if($industry->sub_items)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($industry->sub_items as $item)
                                        <span class="inline-block bg-navy-50 text-navy-700 text-sm px-3 py-1.5 rounded-lg font-medium">{{ $item }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
