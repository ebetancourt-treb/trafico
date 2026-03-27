@extends('layouts.public')

@section('title', $industry->name . ' - Proyectos')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('industries') }}" class="inline-flex items-center gap-1 text-gray-400 hover:text-white transition mb-4 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver a industrias
            </a>
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">{{ $industry->name }}</h1>
            @if($industry->description)
                <p class="text-gray-400 mt-3 max-w-2xl">{{ $industry->description }}</p>
            @endif
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Subcategorías con proyectos --}}
            @if($industry->subcategories->count())
                @foreach($industry->subcategories as $subcategory)
                    <div class="mb-12 fade-up">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-amber-500 rounded-full"></div>
                            <h2 class="font-display font-semibold text-2xl text-navy-800">{{ $subcategory->name }}</h2>
                            @if($subcategory->projects->count())
                                <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">{{ $subcategory->projects->count() }} {{ $subcategory->projects->count() === 1 ? 'proyecto' : 'proyectos' }}</span>
                            @endif
                        </div>

                        @if($subcategory->description)
                            <p class="text-gray-500 mb-6 ml-4">{{ $subcategory->description }}</p>
                        @endif

                        @if($subcategory->projects->where('is_active', true)->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ml-4">
                                @foreach($subcategory->projects->where('is_active', true) as $project)
                                    <a href="{{ route('industries.project.detail', [$industry->slug, $project->slug]) }}"
                                       class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                                        @if($project->image)
                                            <div class="overflow-hidden">
                                                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                                     class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                                            </div>
                                        @else
                                            <div class="w-full h-52 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <i data-lucide="building" class="w-14 h-14 text-gray-300"></i>
                                            </div>
                                        @endif
                                        <div class="p-5">
                                            <h3 class="font-display font-semibold text-lg text-navy-800 group-hover:text-amber-600 transition-colors duration-300">{{ $project->name }}</h3>
                                            @if($project->location)
                                                <p class="text-gray-400 text-sm mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $project->location }}</p>
                                            @endif
                                            @if($project->short_description)
                                                <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $project->short_description }}</p>
                                            @endif
                                            <span class="inline-flex items-center gap-1 text-navy-600 text-sm font-medium mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                Ver proyecto <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 italic text-sm ml-4">Próximamente proyectos.</p>
                        @endif
                    </div>
                @endforeach
            @endif

            {{-- Proyectos sin subcategoría --}}
            @php
                $unclassified = $industry->projects->where('is_active', true)->whereNull('industry_subcategory_id');
            @endphp
            @if($unclassified->count())
                <div class="mb-12 fade-up">
                    @if($industry->subcategories->count())
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-1 h-8 bg-gray-300 rounded-full"></div>
                            <h2 class="font-display font-semibold text-2xl text-gray-500">Otros proyectos</h2>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 {{ $industry->subcategories->count() ? 'ml-4' : '' }}">
                        @foreach($unclassified as $project)
                            <a href="{{ route('industries.project.detail', [$industry->slug, $project->slug]) }}"
                               class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                                @if($project->image)
                                    <div class="overflow-hidden">
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                             class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="w-full h-52 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <i data-lucide="building" class="w-14 h-14 text-gray-300"></i>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h3 class="font-display font-semibold text-lg text-navy-800 group-hover:text-amber-600 transition-colors duration-300">{{ $project->name }}</h3>
                                    @if($project->location)
                                        <p class="text-gray-400 text-sm mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $project->location }}</p>
                                    @endif
                                    @if($project->short_description)
                                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $project->short_description }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Vacío --}}
            @if($industry->subcategories->count() === 0 && $industry->projects->where('is_active', true)->count() === 0)
                <div class="text-center py-16">
                    <i data-lucide="building" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-400 text-lg">Próximamente proyectos en esta categoría.</p>
                </div>
            @endif

        </div>
    </section>

@endsection
