@extends('layouts.public')

@section('title', 'Industrias y Proyectos - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Nuestros Proyectos</h1>
            <p class="text-gray-400 mt-3">Conoce los proyectos que hemos realizado en diferentes sectores</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($industries as $industry)
                <div class="mb-20 fade-up">
                    {{-- Industria header --}}
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-navy-800 flex items-center justify-center">
                            @php
                                $indIcons = ['home' => 'home', 'building' => 'building-2', 'factory' => 'factory', 'landmark' => 'landmark'];
                                $indIcon = $indIcons[$industry->icon] ?? 'building';
                            @endphp
                            <i data-lucide="{{ $indIcon }}" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <h2 class="font-display font-bold text-2xl sm:text-3xl text-navy-800">{{ $industry->name }}</h2>
                            @if($industry->description)
                                <p class="text-gray-400 text-sm mt-1">{{ $industry->description }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Subcategorías con proyectos --}}
                    @if($industry->subcategories->count())
                        @foreach($industry->subcategories as $subcategory)
                            @if($subcategory->is_active)
                                <div class="mb-10 ml-4 sm:ml-8">
                                    {{-- Subcategoría header --}}
                                    <div class="flex items-center gap-3 mb-5">
                                        <div class="w-1 h-8 bg-amber-500 rounded-full"></div>
                                        <h3 class="font-display font-semibold text-xl text-navy-700">{{ $subcategory->name }}</h3>
                                        @if($subcategory->projects->count())
                                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $subcategory->projects->count() }}</span>
                                        @endif
                                    </div>

                                    @if($subcategory->description)
                                        <p class="text-gray-500 text-sm mb-5 ml-4">{{ $subcategory->description }}</p>
                                    @endif

                                    {{-- Proyectos de la subcategoría --}}
                                    @if($subcategory->projects->where('is_active', true)->count())
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ml-4">
                                            @foreach($subcategory->projects->where('is_active', true) as $project)
                                                <a href="{{ route('industries.project.detail', [$industry->slug, $project->slug]) }}"
                                                   class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                                                    @if($project->image)
                                                        <div class="overflow-hidden">
                                                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                                        </div>
                                                    @else
                                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                            <i data-lucide="building" class="w-12 h-12 text-gray-300"></i>
                                                        </div>
                                                    @endif
                                                    <div class="p-5">
                                                        <h4 class="font-display font-semibold text-lg text-navy-800 group-hover:text-amber-600 transition-colors duration-300">
                                                            {{ $project->name }}
                                                        </h4>
                                                        @if($project->location)
                                                            <p class="text-gray-400 text-sm mt-1 flex items-center gap-1">
                                                                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $project->location }}
                                                            </p>
                                                        @endif
                                                        @if($project->short_description)
                                                            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $project->short_description }}</p>
                                                        @endif
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic text-sm ml-4">Próximamente proyectos.</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @endif

                    {{-- Proyectos sin subcategoría --}}
                    @php
                        $unclassified = $industry->projects->where('is_active', true)->whereNull('industry_subcategory_id');
                    @endphp
                    @if($unclassified->count())
                        <div class="mb-10 ml-4 sm:ml-8">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-1 h-8 bg-gray-300 rounded-full"></div>
                                <h3 class="font-display font-semibold text-xl text-gray-500">Otros proyectos</h3>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ml-4">
                                @foreach($unclassified as $project)
                                    <a href="{{ route('industries.project.detail', [$industry->slug, $project->slug]) }}"
                                       class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                                        @if($project->image)
                                            <div class="overflow-hidden">
                                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <i data-lucide="building" class="w-12 h-12 text-gray-300"></i>
                                            </div>
                                        @endif
                                        <div class="p-5">
                                            <h4 class="font-display font-semibold text-lg text-navy-800 group-hover:text-amber-600 transition-colors duration-300">{{ $project->name }}</h4>
                                            @if($project->location)
                                                <p class="text-gray-400 text-sm mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $project->location }}</p>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Si no hay nada --}}
                    @if($industry->subcategories->count() === 0 && $industry->projects->where('is_active', true)->count() === 0)
                        <p class="text-gray-400 italic ml-8">Próximamente proyectos en esta categoría.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

@endsection
