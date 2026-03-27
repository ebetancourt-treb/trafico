@extends('layouts.public')

@section('title', $project->name . ' - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('industries') }}" class="hover:text-white transition">Industrias</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('industries.projects', $industry->slug) }}" class="hover:text-white transition">{{ $industry->name }}</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-white">{{ $project->name }}</span>
            </nav>
        </div>
    </section>

    <section class="py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                {{-- Galería --}}
                <div class="fade-up">
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 aspect-[4/3] cursor-pointer group"
                         id="main-image-container" onclick="openLightbox(0)">
                        @if($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->name }}"
                                 class="w-full h-full object-cover" id="main-image">
                        @else
                            <div class="w-full h-full flex items-center justify-center" id="main-image">
                                <i data-lucide="building" class="w-24 h-24 text-gray-300"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-navy-800/0 group-hover:bg-navy-800/30 transition-all duration-300 flex items-center justify-center">
                            <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg">
                                <i data-lucide="zoom-in" class="w-6 h-6 text-navy-800"></i>
                            </div>
                        </div>
                    </div>

                    @if($project->images->count() > 0 || $project->image)
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                            @if($project->image)
                                <button onclick="changeImage('{{ asset('storage/' . $project->image) }}', 0)"
                                        class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-navy-800 opacity-100 transition thumbnail-btn" data-index="0">
                                    <img src="{{ asset('storage/' . $project->image) }}" class="w-full h-full object-cover" alt="">
                                </button>
                            @endif
                            @foreach($project->images as $imgIndex => $img)
                                <button onclick="changeImage('{{ asset('storage/' . $img->image) }}', {{ $imgIndex + 1 }})"
                                        class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent opacity-70 hover:opacity-100 transition thumbnail-btn" data-index="{{ $imgIndex + 1 }}">
                                    <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover" alt="{{ $img->caption }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="fade-up">
                    <a href="{{ route('industries.projects', $industry->slug) }}"
                       class="inline-flex items-center gap-1.5 bg-navy-50 text-navy-700 text-sm px-3 py-1.5 rounded-full font-medium hover:bg-navy-100 transition mb-4">
                        <i data-lucide="folder" class="w-3.5 h-3.5"></i>
                        {{ $industry->name }}
                    </a>

                    <h1 class="font-display font-bold text-3xl lg:text-4xl text-navy-800 mb-4">{{ $project->name }}</h1>

                    {{-- Datos del proyecto --}}
                    <div class="flex flex-wrap gap-4 mb-6">
                        @if($project->location)
                            <div class="flex items-center gap-2 text-gray-500">
                                <i data-lucide="map-pin" class="w-4 h-4 text-amber-500"></i>
                                <span class="text-sm">{{ $project->location }}</span>
                            </div>
                        @endif
                        @if($project->client)
                            <div class="flex items-center gap-2 text-gray-500">
                                <i data-lucide="user" class="w-4 h-4 text-amber-500"></i>
                                <span class="text-sm">{{ $project->client }}</span>
                            </div>
                        @endif
                    </div>

                    @if($project->short_description)
                        <p class="text-gray-500 text-lg leading-relaxed mb-6">{{ $project->short_description }}</p>
                    @endif

                    @if($project->description)
                        <div class="prose prose-gray max-w-none mb-8">
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $project->description }}</p>
                        </div>
                    @endif

                    
                </div>
            </div>
        </div>
    </section>

    {{-- Proyectos relacionados --}}
    @if($related->count())
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-display font-bold text-2xl text-navy-800 mb-8">Más proyectos en {{ $industry->name }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $rel)
                        <a href="{{ route('industries.project.detail', [$industry->slug, $rel->slug]) }}"
                           class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                            @if($rel->image)
                                <div class="overflow-hidden">
                                    <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}"
                                         class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i data-lucide="building" class="w-10 h-10 text-gray-300"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-display font-semibold text-navy-800 group-hover:text-amber-600 transition-colors">{{ $rel->name }}</h3>
                                @if($rel->location)
                                    <p class="text-gray-400 text-xs mt-1 flex items-center gap-1"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $rel->location }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Lightbox --}}
    <div id="img-lightbox" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/90" onclick="closeLightbox()"></div>
        <div class="relative z-10 flex flex-col h-full">
            <div class="flex items-center justify-between px-4 sm:px-6 py-4 shrink-0">
                <span class="text-white/70 text-sm" id="lightbox-counter"></span>
                <button onclick="closeLightbox()" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center px-4 sm:px-16 relative">
                <button onclick="prevImage()" id="lightbox-prev" class="absolute left-2 sm:left-4 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/25 transition z-10">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl select-none">
                <button onclick="nextImage()" id="lightbox-next" class="absolute right-2 sm:right-4 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/25 transition z-10">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="text-center py-4 shrink-0"><p id="lightbox-caption" class="text-white/70 text-sm"></p></div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const projectImages = [
        @if($project->image)
            { src: '{{ asset('storage/' . $project->image) }}', caption: '{{ $project->name }}' },
        @endif
        @foreach($project->images as $img)
            { src: '{{ asset('storage/' . $img->image) }}', caption: '{{ $img->caption ?? $project->name }}' },
        @endforeach
    ];
    let currentImageIndex = 0;

    function changeImage(src, index) {
        const mainImg = document.getElementById('main-image');
        if (mainImg.tagName === 'IMG') { mainImg.src = src; }
        else {
            const container = document.getElementById('main-image-container');
            const overlay = container.querySelector('div:last-child').outerHTML;
            container.innerHTML = `<img src="${src}" alt="" class="w-full h-full object-cover" id="main-image">${overlay}`;
        }
        currentImageIndex = index;
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-navy-800', 'opacity-100');
            btn.classList.add('border-transparent', 'opacity-70');
        });
        if (event && event.currentTarget) {
            event.currentTarget.classList.remove('border-transparent', 'opacity-70');
            event.currentTarget.classList.add('border-navy-800', 'opacity-100');
        }
    }

    function openLightbox(index) {
        if (projectImages.length === 0) return;
        currentImageIndex = index;
        updateLightbox();
        document.getElementById('img-lightbox').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lucide.createIcons();
    }
    function closeLightbox() {
        document.getElementById('img-lightbox').classList.add('hidden');
        document.body.style.overflow = '';
    }
    function updateLightbox() {
        const img = projectImages[currentImageIndex];
        document.getElementById('lightbox-img').src = img.src;
        document.getElementById('lightbox-caption').textContent = img.caption || '';
        document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} / ${projectImages.length}`;
        document.getElementById('lightbox-prev').style.display = projectImages.length <= 1 ? 'none' : '';
        document.getElementById('lightbox-next').style.display = projectImages.length <= 1 ? 'none' : '';
    }
    function nextImage() { currentImageIndex = (currentImageIndex + 1) % projectImages.length; updateLightbox(); }
    function prevImage() { currentImageIndex = (currentImageIndex - 1 + projectImages.length) % projectImages.length; updateLightbox(); }

    document.addEventListener('keydown', function(e) {
        const lb = document.getElementById('img-lightbox');
        if (e.key === 'Escape' && !lb.classList.contains('hidden')) closeLightbox();
        if (!lb.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        }
    });
</script>
@endpush
