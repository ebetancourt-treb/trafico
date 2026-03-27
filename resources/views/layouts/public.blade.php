@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tráfico Soluciones Viales - Señalamiento y pintura vial profesional">
    <title>@yield('title', 'Tráfico Soluciones Viales')</title>

    {{-- Tailwind via CDN (reemplazar con Vite en producción) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50: '#f0f3ff',
                            100: '#dde3f7',
                            200: '#b8c4ed',
                            300: '#8da0df',
                            400: '#6179cd',
                            500: '#3d55b5',
                            600: '#2d4093',
                            700: '#1e2d6f',
                            800: '#151f52',  /* color principal del navbar del PDF */
                            900: '#0d1433',
                        },
                        amber: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    },
                    fontFamily: {
                        display: ['Outfit', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }

        /* Smooth scroll offset for fixed navbar */
        [id] { scroll-margin-top: 80px; }

        /* Slide animation */
        .slide-enter { animation: slideIn 0.6s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Fade in on scroll */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-gray-800 antialiased">

    {{-- ═══════════════ NAVBAR ═══════════════ --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-navy-800 shadow-lg" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    @if(!empty($siteSettings['logo']) && Storage::disk('public')->exists($siteSettings['logo']))
                        <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Tráfico" class="h-12 max-w-[180px] object-contain">
                    @else
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="triangle-alert" class="w-6 h-6 text-navy-800"></i>
                            </div>
                            <div>
                                <span class="text-white font-display font-bold text-xl tracking-tight">TRÁFICO</span>
                                <span class="block text-amber-400 text-[10px] font-medium tracking-widest uppercase -mt-1">Soluciones Viales</span>
                            </div>
                        </div>
                    @endif
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('home') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        INICIO
                    </a>
                    <a href="{{ route('products') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('products*') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        PRODUCTOS
                    </a>
                    <a href="{{ route('gallery') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('gallery') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        GALERÍA
                    </a>
                    <a href="{{ route('industries') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('industries') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        INDUSTRIAS
                    </a>
                    <a href="{{ route('contact') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                              {{ request()->routeIs('contact') ? 'bg-white/15 text-white' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                        CONTACTO
                    </a>
                </div>

                {{-- Phone + Social --}}
                <div class="hidden lg:flex items-center gap-4">
                    <a href="tel:{{ $siteSettings['phone'] ?? '8715118808' }}" class="flex items-center gap-2 text-white font-medium">
                        <i data-lucide="phone" class="w-4 h-4 text-amber-400"></i>
                        <span class="text-sm">{{ $siteSettings['phone'] ?? '871 511 8808' }}</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <a href="{{ $siteSettings['facebook'] ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#1877F2] transition">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ $siteSettings['instagram'] ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#E4405F] transition">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center hover:bg-green-600 transition">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Mobile hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden text-white p-2" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-navy-900 border-t border-white/10">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-white hover:bg-white/10">Inicio</a>
                <a href="{{ route('products') }}" class="block px-4 py-3 rounded-lg text-white hover:bg-white/10">Productos</a>
                <a href="{{ route('gallery') }}" class="block px-4 py-3 rounded-lg text-white hover:bg-white/10">Galería</a>
                <a href="{{ route('industries') }}" class="block px-4 py-3 rounded-lg text-white hover:bg-white/10">Industrias</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-lg text-white hover:bg-white/10">Contacto</a>
                <div class="pt-2 border-t border-white/10">
                    <a href="tel:{{ $siteSettings['phone'] ?? '8715118808' }}" class="flex items-center gap-2 px-4 py-3 text-amber-400">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        {{ $siteSettings['phone'] ?? '871 511 8808' }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Spacer para el fixed navbar --}}
    <div class="h-20"></div>

    {{-- ═══════════════ CONTENT ═══════════════ --}}
    <main>
        @yield('content')
    </main>

    {{-- ═══════════════ FOOTER ═══════════════ --}}
    <footer class="bg-navy-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Logo + descripción --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        @if(!empty($siteSettings['logo']) && Storage::disk('public')->exists($siteSettings['logo']))
                            <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Tráfico" class="h-10 max-w-[160px] object-contain invert">
                        @else
                            <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                                <i data-lucide="triangle-alert" class="w-5 h-5 text-navy-800"></i>
                            </div>
                            <span class="font-display font-bold text-lg">TRÁFICO</span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Soluciones profesionales de señalamiento y pintura vial para hacer más seguras las vialidades de nuestras ciudades.
                    </p>
                </div>

                {{-- Links rápidos --}}
                <div>
                    <h4 class="font-display font-semibold text-lg mb-4">Enlaces</h4>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Inicio</a>
                        <a href="{{ route('products') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Productos</a>
                        <a href="{{ route('gallery') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Galería</a>
                        <a href="{{ route('industries') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Industrias</a>
                        <a href="{{ route('contact') }}" class="block text-gray-400 hover:text-amber-400 transition text-sm">Contacto</a>
                    </div>
                </div>

                {{-- Contacto --}}
                <div>
                    <h4 class="font-display font-semibold text-lg mb-4">Contacto</h4>
                    <div class="space-y-3">
                        <a href="tel:{{ $siteSettings['phone'] ?? '8715118808' }}" class="flex items-center gap-2 text-gray-400 hover:text-amber-400 transition text-sm">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                            {{ $siteSettings['phone'] ?? '871 511 8808' }}
                        </a>
                        <a href="mailto:{{ $siteSettings['email'] ?? 'ventas@trafico.com' }}" class="flex items-center gap-2 text-gray-400 hover:text-amber-400 transition text-sm">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            {{ $siteSettings['email'] ?? 'ventas@trafico.com' }}
                        </a>
                        <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}" class="flex items-center gap-2 text-gray-400 hover:text-green-400 transition text-sm">
                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                            WhatsApp
                        </a>
                    </div>
                    <div class="flex items-center gap-3 mt-4">
                        <a href="{{ $siteSettings['facebook'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#1877F2] transition">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ $siteSettings['instagram'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#E4405F] transition">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 mt-10 pt-6 text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Tráfico Soluciones Viales. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    {{-- WhatsApp flotante --}}
    <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}" target="_blank"
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 hover:scale-110 transition-all duration-300">
        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    {{-- Scroll animations --}}
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Fade-up on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>

    @stack('scripts')
</body>
</html>