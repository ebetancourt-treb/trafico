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
            <p class="text-gray-500 mt-2 text-sm">{{ $industry->projects->count() }} {{ $industry->projects->count() === 1 ? 'proyecto' : 'proyectos' }}</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($industry->projects->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($industry->projects as $project)
                        <a href="{{ route('industries.project.detail', [$industry->slug, $project->slug]) }}"
                           class="fade-up bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group block">
                            @if($project->image)
                                <div class="overflow-hidden">
                                    <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                         class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full h-56 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i data-lucide="building" class="w-16 h-16 text-gray-300"></i>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="font-display font-semibold text-xl text-navy-800 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $project->name }}
                                </h3>
                                @if($project->location)
                                    <p class="text-gray-400 text-sm flex items-center gap-1 mb-2">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i> {{ $project->location }}
                                    </p>
                                @endif
                                @if($project->client)
                                    <p class="text-gray-400 text-sm flex items-center gap-1 mb-2">
                                        <i data-lucide="user" class="w-3.5 h-3.5"></i> {{ $project->client }}
                                    </p>
                                @endif
                                @if($project->short_description)
                                    <p class="text-gray-500 leading-relaxed line-clamp-3">{{ $project->short_description }}</p>
                                @endif
                                <span class="inline-flex items-center gap-1 text-navy-600 text-sm font-medium mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Ver proyecto <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i data-lucide="building" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-400 text-lg">Próximamente proyectos en esta categoría.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
