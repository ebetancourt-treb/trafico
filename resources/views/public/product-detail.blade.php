@extends('layouts.public')

@section('title', $product->name . ' - Tráfico Soluciones Viales')

@section('content')

    {{-- Breadcrumb --}}
    <section class="bg-navy-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('products') }}" class="hover:text-white transition">Productos</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <a href="{{ route('products.category', $category->slug) }}" class="hover:text-white transition">{{ $category->name }}</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-white">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <section class="py-12 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                {{-- ══ GALERÍA DE IMÁGENES ══ --}}
                <div class="fade-up">
                    {{-- Imagen principal (clickeable) --}}
                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 aspect-[4/3] cursor-pointer group"
                         id="main-image-container"
                         onclick="openLightbox(0)">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover"
                                 id="main-image">
                        @else
                            <div class="w-full h-full flex items-center justify-center" id="main-image">
                                <i data-lucide="package" class="w-24 h-24 text-gray-300"></i>
                            </div>
                        @endif
                        {{-- Hover overlay con icono de zoom --}}
                        <div class="absolute inset-0 bg-navy-800/0 group-hover:bg-navy-800/30 transition-all duration-300 flex items-center justify-center">
                            <div class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 shadow-lg">
                                <i data-lucide="zoom-in" class="w-6 h-6 text-navy-800"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Thumbnails --}}
                    @if($product->images->count() > 0 || $product->image)
                        <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                            @if($product->image)
                                <button onclick="changeImage('{{ asset('storage/' . $product->image) }}', 0)"
                                        class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-navy-800 opacity-100 hover:opacity-100 transition thumbnail-btn"
                                        data-index="0">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="">
                                </button>
                            @endif

                            @foreach($product->images as $imgIndex => $img)
                                <button onclick="changeImage('{{ asset('storage/' . $img->image) }}', {{ $imgIndex + 1 }})"
                                        class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent opacity-70 hover:opacity-100 transition thumbnail-btn"
                                        data-index="{{ $imgIndex + 1 }}">
                                    <img src="{{ asset('storage/' . $img->image) }}" class="w-full h-full object-cover" alt="{{ $img->caption }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ══ INFORMACIÓN DEL PRODUCTO ══ --}}
                <div class="fade-up">
                    <a href="{{ route('products.category', $category->slug) }}"
                       class="inline-flex items-center gap-1.5 bg-navy-50 text-navy-700 text-sm px-3 py-1.5 rounded-full font-medium hover:bg-navy-100 transition mb-4">
                        <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                        {{ $category->name }}
                    </a>

                    <h1 class="font-display font-bold text-3xl lg:text-4xl text-navy-800 mb-4">
                        {{ $product->name }}
                    </h1>

                    @if($product->short_description)
                        <p class="text-gray-500 text-lg leading-relaxed mb-6">{{ $product->short_description }}</p>
                    @endif

                    @if($product->description)
                        <div class="prose prose-gray max-w-none mb-8">
                            <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                        </div>
                    @endif

                    {{-- Características --}}
                    @if($product->features && count($product->features))
                        <div class="mb-8">
                            <h3 class="font-display font-semibold text-lg text-navy-800 mb-3">Características</h3>
                            <div class="space-y-2">
                                @foreach($product->features as $feature)
                                    <div class="flex items-start gap-2">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500 shrink-0 mt-0.5"></i>
                                        <span class="text-gray-600">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Acciones --}}
                    <div class="flex flex-col sm:flex-row gap-3 mb-8">
                        @if($product->datasheet_pdf)
                            <button onclick="document.getElementById('pdf-modal').classList.remove('hidden'); lucide.createIcons();"
                                    class="inline-flex items-center justify-center gap-2 bg-red-600 text-white px-6 py-3.5 rounded-lg font-semibold text-sm hover:bg-red-700 transition-all duration-300 shadow-sm">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                Ver ficha técnica
                            </button>
                        @endif

                        <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}?text={{ urlencode('Hola, me interesa el producto: ' . $product->name . ' de la categoría ' . $category->name) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center gap-2 bg-green-600 text-white px-6 py-3.5 rounded-lg font-semibold text-sm hover:bg-green-700 transition-all duration-300 shadow-sm">
                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                            Solicitar cotización
                        </a>

                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center justify-center gap-2 border-2 border-navy-800 text-navy-800 px-6 py-3.5 rounded-lg font-semibold text-sm hover:bg-navy-800 hover:text-white transition-all duration-300">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                            Contactar
                        </a>
                    </div>

                    {{-- Ficha técnica card --}}
                    
                </div>

            </div>
        </div>
    </section>

    {{-- ══ PRODUCTOS RELACIONADOS ══ --}}
    @if($related->count())
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-display font-bold text-2xl text-navy-800 mb-8">Productos relacionados</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $relProduct)
                        <a href="{{ route('products.detail', [$category->slug, $relProduct->slug]) }}"
                           class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group block">
                            @if($relProduct->image)
                                <div class="overflow-hidden">
                                    <img src="{{ asset('storage/' . $relProduct->image) }}" alt="{{ $relProduct->name }}"
                                         class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <i data-lucide="package" class="w-10 h-10 text-gray-300"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-display font-semibold text-navy-800 group-hover:text-amber-600 transition-colors duration-300">
                                    {{ $relProduct->name }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ══════════════════════════════════════════ --}}
    {{-- LIGHTBOX DE IMÁGENES                      --}}
    {{-- ══════════════════════════════════════════ --}}
    <div id="img-lightbox" class="fixed inset-0 z-[100] hidden">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/90" onclick="closeLightbox()"></div>

        {{-- Contenido --}}
        <div class="relative z-10 flex flex-col h-full">
            {{-- Header --}}
            <div class="flex items-center justify-between px-4 sm:px-6 py-4 shrink-0">
                <span class="text-white/70 text-sm" id="lightbox-counter"></span>
                <button onclick="closeLightbox()" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Imagen + flechas --}}
            <div class="flex-1 flex items-center justify-center px-4 sm:px-16 relative">
                {{-- Flecha izquierda --}}
                <button onclick="prevImage()" id="lightbox-prev"
                        class="absolute left-2 sm:left-4 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/25 transition z-10">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>

                {{-- Imagen --}}
                <img id="lightbox-img" src="" alt=""
                     class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl select-none">

                {{-- Flecha derecha --}}
                <button onclick="nextImage()" id="lightbox-next"
                        class="absolute right-2 sm:right-4 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/25 transition z-10">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>

            {{-- Caption --}}
            <div class="text-center py-4 shrink-0">
                <p id="lightbox-caption" class="text-white/70 text-sm"></p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- MODAL PDF VIEWER                          --}}
    {{-- ══════════════════════════════════════════ --}}
    @if($product->datasheet_pdf)
    <div id="pdf-modal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="document.getElementById('pdf-modal').classList.add('hidden')"></div>

        <div class="relative z-10 flex flex-col h-full p-4 sm:p-6 lg:p-10">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="file-text" class="w-4 h-4 text-white"></i>
                    </div>
                    <h3 class="text-white font-semibold">{{ $product->name }} — Ficha Técnica</h3>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ asset('storage/' . $product->datasheet_pdf) }}"
                       download
                       class="inline-flex items-center gap-2 bg-white/10 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/20 transition">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Descargar
                    </a>
                    <button onclick="document.getElementById('pdf-modal').classList.add('hidden')"
                            class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center text-white hover:bg-white/20 transition">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            {{-- PDF Viewer --}}
            <div class="flex-1 bg-white rounded-xl overflow-hidden shadow-2xl">
                <iframe src="{{ asset('storage/' . $product->datasheet_pdf) }}#toolbar=1&navpanes=0"
                        class="w-full h-full border-0"
                        title="Ficha técnica - {{ $product->name }}">
                </iframe>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('scripts')
<script>
    // ── Arreglo de todas las imágenes del producto ──
    const productImages = [
        @if($product->image)
            { src: '{{ asset('storage/' . $product->image) }}', caption: '{{ $product->name }}' },
        @endif
        @foreach($product->images as $img)
            { src: '{{ asset('storage/' . $img->image) }}', caption: '{{ $img->caption ?? $product->name }}' },
        @endforeach
    ];

    let currentImageIndex = 0;

    // ── Cambiar imagen principal (thumbnails) ──
    function changeImage(src, index) {
        const mainImg = document.getElementById('main-image');
        if (mainImg.tagName === 'IMG') {
            mainImg.src = src;
        } else {
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

    // ── Lightbox ──
    function openLightbox(index) {
        if (productImages.length === 0) return;

        currentImageIndex = index;
        updateLightbox();

        const lb = document.getElementById('img-lightbox');
        lb.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lucide.createIcons();
    }

    function closeLightbox() {
        const lb = document.getElementById('img-lightbox');
        lb.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateLightbox() {
        const img = productImages[currentImageIndex];
        document.getElementById('lightbox-img').src = img.src;
        document.getElementById('lightbox-caption').textContent = img.caption || '';
        document.getElementById('lightbox-counter').textContent =
            `${currentImageIndex + 1} / ${productImages.length}`;

        // Ocultar flechas si solo hay 1 imagen
        document.getElementById('lightbox-prev').style.display = productImages.length <= 1 ? 'none' : '';
        document.getElementById('lightbox-next').style.display = productImages.length <= 1 ? 'none' : '';
    }

    function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % productImages.length;
        updateLightbox();
    }

    function prevImage() {
        currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
        updateLightbox();
    }

    // ── Teclado ──
    document.addEventListener('keydown', function(e) {
        const imgLb = document.getElementById('img-lightbox');
        const pdfModal = document.getElementById('pdf-modal');

        if (e.key === 'Escape') {
            if (imgLb && !imgLb.classList.contains('hidden')) closeLightbox();
            if (pdfModal && !pdfModal.classList.contains('hidden')) pdfModal.classList.add('hidden');
        }

        if (!imgLb.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        }
    });
</script>
@endpush