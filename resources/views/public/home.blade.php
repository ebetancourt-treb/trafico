@extends('layouts.public')

@section('title', 'Tráfico Soluciones Viales - Inicio')

@section('content')

    {{-- ═══════════════ HERO SLIDER ═══════════════ --}}
    <section class="relative bg-gray-100 overflow-hidden" id="hero">
        <div class="relative" id="slider">
            @forelse($slides as $index => $slide)
                @php
                    $bgImage = $slide->side_image ?? $slide->image;
                @endphp
                <div class="slide {{ $index === 0 ? '' : 'hidden' }}" data-index="{{ $index }}">

                    {{-- ══ MOBILE: imagen de fondo + texto encima ══ --}}
                    <div class="lg:hidden relative min-h-[480px] sm:min-h-[520px] flex items-center"
                         @if($bgImage) style="background-image: url('{{ asset('storage/' . $bgImage) }}'); background-size: cover; background-position: center;" @endif>
                        {{-- Overlay oscuro para legibilidad --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/90 via-navy-800/60 to-navy-800/30"></div>

                        <div class="relative z-10 px-6 py-16 w-full">
                            <h1 class="font-display font-black text-4xl sm:text-5xl text-white leading-tight mb-4 drop-shadow-lg">
                                {{ $slide->title }}
                            </h1>
                            @if($slide->subtitle)
                                <p class="text-gray-200 text-base sm:text-lg mb-8 max-w-sm">{{ $slide->subtitle }}</p>
                            @endif
                            @if($slide->cta_text)
                                <a href="{{ $slide->cta_url ?? '#productos' }}"
                                   class="inline-flex items-center gap-2 bg-amber-500 text-navy-900 px-7 py-3.5 rounded-lg font-bold text-sm tracking-wide hover:bg-amber-400 transition-all duration-300 shadow-lg">
                                    {{ $slide->cta_text }}
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- ══ DESKTOP: layout lado a lado original ══ --}}
                    <div class="hidden lg:block">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="grid grid-cols-2 min-h-[600px] items-center gap-8">
                                {{-- Left: Text --}}
                                <div class="py-20">
                                    <h1 class="font-display font-black text-6xl xl:text-7xl text-navy-800 leading-none mb-6">
                                        {{ $slide->title }}
                                    </h1>
                                    @if($slide->subtitle)
                                        <p class="text-gray-600 text-lg mb-8 max-w-md">{{ $slide->subtitle }}</p>
                                    @endif
                                    @if($slide->cta_text)
                                        <a href="{{ $slide->cta_url ?? '#productos' }}"
                                           class="inline-flex items-center gap-2 bg-navy-800 text-white px-8 py-4 rounded-lg font-semibold text-sm tracking-wide hover:bg-navy-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                                            {{ $slide->cta_text }}
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                </div>

                                {{-- Right: Side image --}}
                                <div class="relative">
                                    @if($bgImage)
                                        <img src="{{ asset('storage/' . $bgImage) }}"
                                             alt="{{ $slide->title }}"
                                             class="w-full h-[500px] object-cover rounded-2xl shadow-2xl">
                                    @else
                                        <div class="w-full h-[500px] bg-gradient-to-br from-navy-200 to-navy-300 rounded-2xl flex items-center justify-center">
                                            <i data-lucide="image" class="w-20 h-20 text-navy-400"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="min-h-[400px] flex items-center justify-center bg-gradient-to-br from-navy-800 to-navy-700">
                    <div class="text-center px-6">
                        <h1 class="font-display font-black text-5xl sm:text-6xl lg:text-7xl text-white leading-none mb-6">
                            Pintura<br>Vial
                        </h1>
                        <a href="#productos"
                           class="inline-flex items-center gap-2 bg-amber-500 text-navy-900 px-8 py-4 rounded-lg font-bold text-sm tracking-wide hover:bg-amber-400 transition">
                            MÁS INFORMACIÓN
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Slider controls --}}
        @if($slides->count() > 1)
            <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-navy-800/80 text-white rounded-full flex items-center justify-center hover:bg-navy-800 transition z-10">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>
            <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-navy-800/80 text-white rounded-full flex items-center justify-center hover:bg-navy-800 transition z-10">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>

            {{-- Dots --}}
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
                @foreach($slides as $index => $slide)
                    <button onclick="goToSlide({{ $index }})"
                            class="slider-dot w-3 h-3 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-navy-800 w-8' : 'bg-navy-300' }}"
                            data-index="{{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ═══════════════ NOSOTROS ═══════════════ --}}
    @if($nosotros)
    <section class="py-20 bg-white" id="nosotros">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Imagen --}}
                <div class="fade-up">
                    @if($nosotros->image)
                        <img src="{{ asset('storage/' . $nosotros->image) }}"
                             alt="Nosotros"
                             class="w-full h-[450px] object-cover rounded-2xl shadow-xl">
                    @else
                        <div class="w-full h-[450px] bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl flex items-center justify-center">
                            <i data-lucide="hard-hat" class="w-24 h-24 text-amber-400"></i>
                        </div>
                    @endif
                </div>

                {{-- Contenido --}}
                <div class="fade-up">
                    <span class="text-amber-500 font-semibold text-sm tracking-widest uppercase">Nosotros</span>
                    <h2 class="font-display font-bold text-4xl lg:text-5xl text-navy-800 mt-2 mb-6">
                        {{ $nosotros->title }}
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-lg mb-8">
                        {{ $nosotros->content }}
                    </p>

                    {{-- Valores --}}
                    @if($values->count())
                        <div class="space-y-3">
                            @foreach($values as $value)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-navy-800 flex items-center justify-center shrink-0 mt-0.5">
                                        <i data-lucide="check" class="w-4 h-4 text-amber-400"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-navy-800">{{ $value->title }}:</span>
                                        <span class="text-gray-600"> {{ $value->description }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════ PRODUCTOS ═══════════════ --}}
    <section class="py-20 bg-gray-50" id="productos">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-amber-500 font-semibold text-sm tracking-widest uppercase">Catálogo</span>
                <h2 class="font-display font-bold text-4xl lg:text-5xl text-navy-800 mt-2">Nuestros Productos</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto">Ofrecemos soluciones completas en señalamiento y pintura vial para todo tipo de proyecto.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('products.category', $category->slug) }}"
                       class="fade-up group bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                        <div class="w-14 h-14 rounded-xl bg-navy-800 flex items-center justify-center mb-5 group-hover:bg-amber-500 transition-colors duration-300">
                            @include('components.category-icon', ['category' => $category, 'size' => 'lg'])
                        </div>
                        <h3 class="font-display font-semibold text-xl text-navy-800 mb-2">{{ $category->name }}</h3>
                        @if($category->products->count())
                            <p class="text-gray-400 text-sm">{{ $category->products->count() }} productos</p>
                        @endif
                        <div class="mt-4 flex items-center gap-1 text-navy-600 text-sm font-medium opacity-0 group-hover:opacity-100 transition">
                            Ver más <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════ INDUSTRIAS ═══════════════ --}}
    <section class="py-20 bg-navy-800" id="industrias">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-amber-400 font-semibold text-sm tracking-widest uppercase">Proyectos</span>
                <h2 class="font-display font-bold text-4xl lg:text-5xl text-white mt-2">Industrias que Atendemos</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($industries as $industry)
                    <a href="{{ route('industries.projects', $industry->slug) }}"
                       class="fade-up bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group block">
                        <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center mb-4 group-hover:bg-white transition-colors duration-300">
                            @php
                                $indIcons = ['home' => 'home', 'building' => 'building-2', 'factory' => 'factory', 'landmark' => 'landmark'];
                                $indIcon = $indIcons[$industry->icon] ?? 'building';
                            @endphp
                            <i data-lucide="{{ $indIcon }}" class="w-6 h-6 text-navy-800"></i>
                        </div>
                        <h3 class="font-display font-semibold text-xl text-white mb-2 group-hover:text-amber-400 transition-colors duration-300">{{ $industry->name }}</h3>
                        @if($industry->sub_items)
                            <ul class="space-y-1.5 mb-3">
                                @foreach($industry->sub_items as $item)
                                    <li class="text-gray-400 text-sm flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <span class="inline-flex items-center gap-1 text-amber-400 text-sm font-medium mt-auto opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Ver proyectos <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════ GALERÍA PREVIEW ═══════════════ --}}
    @if($galleryImages->count())
    <section class="py-20 bg-white" id="galeria">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 fade-up">
                <span class="text-amber-500 font-semibold text-sm tracking-widest uppercase">Proyectos</span>
                <h2 class="font-display font-bold text-4xl lg:text-5xl text-navy-800 mt-2">Galería</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($galleryImages as $img)
                    <div class="fade-up group relative overflow-hidden rounded-xl aspect-square">
                        <img src="{{ asset('storage/' . $img->image) }}"
                             alt="{{ $img->title ?? 'Proyecto' }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-navy-800/0 group-hover:bg-navy-800/60 transition-all duration-300 flex items-center justify-center">
                            @if($img->title)
                                <span class="text-white font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ $img->title }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('gallery') }}"
                   class="inline-flex items-center gap-2 border-2 border-navy-800 text-navy-800 px-8 py-3 rounded-lg font-semibold text-sm hover:bg-navy-800 hover:text-white transition-all duration-300">
                    Ver toda la galería
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════ CTA CONTACTO ═══════════════ --}}
    <section class="py-16 bg-gradient-to-r from-amber-400 to-amber-500">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display font-bold text-3xl lg:text-4xl text-navy-800 mb-4">¿Tienes un proyecto en mente?</h2>
            <p class="text-navy-700 text-lg mb-8">Contáctanos y te ayudamos a encontrar la mejor solución para tu vialidad.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center justify-center gap-2 bg-navy-800 text-white px-8 py-4 rounded-lg font-semibold text-sm hover:bg-navy-900 transition">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    Contáctanos
                </a>
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}"
                   class="inline-flex items-center justify-center gap-2 bg-green-600 text-white px-8 py-4 rounded-lg font-semibold text-sm hover:bg-green-700 transition">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    WhatsApp
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Simple slider logic
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const totalSlides = slides.length;

    function goToSlide(index) {
        slides.forEach(s => s.classList.add('hidden'));
        dots.forEach(d => { d.classList.remove('bg-navy-800', 'w-8'); d.classList.add('bg-navy-300'); });

        slides[index]?.classList.remove('hidden');
        if (dots[index]) {
            dots[index].classList.remove('bg-navy-300');
            dots[index].classList.add('bg-navy-800', 'w-8');
        }
        currentSlide = index;
        lucide.createIcons();
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % totalSlides);
    }

    function prevSlide() {
        goToSlide((currentSlide - 1 + totalSlides) % totalSlides);
    }

    // Auto-advance every 6 seconds
    if (totalSlides > 1) {
        setInterval(nextSlide, 6000);
    }
</script>
@endpush
