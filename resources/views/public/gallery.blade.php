@extends('layouts.public')

@section('title', 'Galería - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Galería</h1>
            <p class="text-gray-400 mt-3">Nuestros proyectos y trabajos realizados</p>
        </div>
    </section>

    {{-- Filtros por categoría --}}
    @if($categories->count())
    <section class="bg-white border-b border-gray-100 sticky top-20 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 py-4 overflow-x-auto">
                <button onclick="filterGallery('all')"
                        class="gallery-filter px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 whitespace-nowrap bg-navy-800 text-white"
                        data-filter="all">
                    Todas
                </button>
                @foreach($categories as $cat)
                    <button onclick="filterGallery('cat-{{ $cat->id }}')"
                            class="gallery-filter px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 whitespace-nowrap bg-gray-100 text-gray-600 hover:bg-gray-200"
                            data-filter="cat-{{ $cat->id }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
                @if($uncategorized->count())
                    <button onclick="filterGallery('uncategorized')"
                            class="gallery-filter px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 whitespace-nowrap bg-gray-100 text-gray-600 hover:bg-gray-200"
                            data-filter="uncategorized">
                        Otros
                    </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($images->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="gallery-grid">
                    @foreach($images as $index => $img)
                        <div class="gallery-item fade-up group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer"
                             data-category="{{ $img->gallery_category_id ? 'cat-' . $img->gallery_category_id : 'uncategorized' }}"
                             onclick="openLightbox({{ $index }})">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                 alt="{{ $img->title ?? 'Proyecto' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-800/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    @if($img->title)
                                        <h3 class="text-white font-display font-semibold text-lg">{{ $img->title }}</h3>
                                    @endif
                                    @if($img->galleryCategory)
                                        <span class="text-amber-400 text-sm">{{ $img->galleryCategory->name }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- Zoom icon --}}
                            <div class="absolute top-4 right-4 w-10 h-10 bg-white/80 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <i data-lucide="zoom-in" class="w-5 h-5 text-navy-800"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <i data-lucide="image" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-400 text-lg">Próximamente más fotos de nuestros proyectos.</p>
                </div>
            @endif
        </div>
    </section>

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
    // Imágenes para lightbox
    const allImages = [
        @foreach($images as $img)
            { src: '{{ asset('storage/' . $img->image) }}', caption: '{{ $img->title ?? '' }}', category: '{{ $img->gallery_category_id ? 'cat-' . $img->gallery_category_id : 'uncategorized' }}' },
        @endforeach
    ];

    let visibleImages = [...allImages];
    let currentImageIndex = 0;

    // Filtro por categoría
    function filterGallery(filter) {
        const items = document.querySelectorAll('.gallery-item');
        const buttons = document.querySelectorAll('.gallery-filter');

        // Actualizar botones
        buttons.forEach(btn => {
            btn.classList.remove('bg-navy-800', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-600');
        });
        const activeBtn = document.querySelector(`.gallery-filter[data-filter="${filter}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-100', 'text-gray-600');
            activeBtn.classList.add('bg-navy-800', 'text-white');
        }

        // Filtrar imágenes
        visibleImages = [];
        let visibleIndex = 0;

        items.forEach((item, index) => {
            const cat = item.dataset.category;
            const show = (filter === 'all' || cat === filter);

            if (show) {
                item.style.display = '';
                item.onclick = () => openLightbox(visibleIndex);
                visibleImages.push(allImages[index]);
                visibleIndex++;
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Lightbox
    function openLightbox(index) {
        if (visibleImages.length === 0) return;
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
        const img = visibleImages[currentImageIndex];
        document.getElementById('lightbox-img').src = img.src;
        document.getElementById('lightbox-caption').textContent = img.caption || '';
        document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} / ${visibleImages.length}`;
        document.getElementById('lightbox-prev').style.display = visibleImages.length <= 1 ? 'none' : '';
        document.getElementById('lightbox-next').style.display = visibleImages.length <= 1 ? 'none' : '';
    }

    function nextImage() { currentImageIndex = (currentImageIndex + 1) % visibleImages.length; updateLightbox(); }
    function prevImage() { currentImageIndex = (currentImageIndex - 1 + visibleImages.length) % visibleImages.length; updateLightbox(); }

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
