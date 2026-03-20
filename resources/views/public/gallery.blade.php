@extends('layouts.public')

@section('title', 'Galería - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Galería</h1>
            <p class="text-gray-400 mt-3">Nuestros proyectos y trabajos realizados</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($images->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($images as $img)
                        <div class="fade-up group relative overflow-hidden rounded-2xl aspect-[4/3] cursor-pointer"
                             onclick="openLightbox('{{ asset('storage/' . $img->image) }}', '{{ $img->title }}')">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                 alt="{{ $img->title ?? 'Proyecto' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-800/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    @if($img->title)
                                        <h3 class="text-white font-display font-semibold text-lg">{{ $img->title }}</h3>
                                    @endif
                                    @if($img->description)
                                        <p class="text-gray-300 text-sm mt-1">{{ $img->description }}</p>
                                    @endif
                                </div>
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
    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/90 hidden items-center justify-center p-4" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 text-white hover:text-amber-400 transition" onclick="closeLightbox()">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-lg">
        <p id="lightbox-caption" class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white font-display text-lg"></p>
    </div>

@endsection

@push('scripts')
<script>
    function openLightbox(src, title) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-caption').textContent = title || '';
        const lb = document.getElementById('lightbox');
        lb.classList.remove('hidden');
        lb.classList.add('flex');
    }
    function closeLightbox() {
        const lb = document.getElementById('lightbox');
        lb.classList.add('hidden');
        lb.classList.remove('flex');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endpush
