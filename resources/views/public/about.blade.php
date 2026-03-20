@extends('layouts.public')

@section('title', 'Nosotros - Tráfico Soluciones Viales')

@section('content')

    {{-- Header --}}
    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">¿Quiénes Somos?</h1>
            <p class="text-gray-400 mt-3">Conoce nuestra historia, misión y valores</p>
        </div>
    </section>

    {{-- Nosotros --}}
    @if($nosotros)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="fade-up">
                    @if($nosotros->image)
                        <img src="{{ asset('storage/' . $nosotros->image) }}" alt="Nosotros" class="w-full h-[400px] object-cover rounded-2xl shadow-xl">
                    @else
                        <div class="w-full h-[400px] bg-gradient-to-br from-navy-100 to-navy-200 rounded-2xl flex items-center justify-center">
                            <i data-lucide="users" class="w-20 h-20 text-navy-300"></i>
                        </div>
                    @endif
                </div>
                <div class="fade-up">
                    <h2 class="font-display font-bold text-3xl text-navy-800 mb-4">Nosotros</h2>
                    <p class="text-gray-600 leading-relaxed text-lg">{{ $nosotros->content }}</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Misión y Visión --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if($mision)
                <div class="fade-up bg-white rounded-2xl p-10 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-navy-800 flex items-center justify-center mb-5">
                        <i data-lucide="target" class="w-6 h-6 text-amber-400"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-navy-800 mb-4">{{ $mision->title }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $mision->content }}</p>
                </div>
                @endif

                @if($vision)
                <div class="fade-up bg-white rounded-2xl p-10 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center mb-5">
                        <i data-lucide="eye" class="w-6 h-6 text-navy-800"></i>
                    </div>
                    <h3 class="font-display font-bold text-2xl text-navy-800 mb-4">{{ $vision->title }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $vision->content }}</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Valores --}}
    @if($values->count())
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy-800">Nuestros Valores</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach($values as $value)
                <div class="fade-up text-center p-6">
                    <div class="w-14 h-14 rounded-full bg-navy-800 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="check-circle" class="w-7 h-7 text-amber-400"></i>
                    </div>
                    <h4 class="font-display font-semibold text-lg text-navy-800 mb-2">{{ $value->title }}</h4>
                    <p class="text-gray-500 text-sm">{{ $value->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
