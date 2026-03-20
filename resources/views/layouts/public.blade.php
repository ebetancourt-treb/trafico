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
                            800: '#151f52',
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

        [id] { scroll-margin-top: 80px; }

        .slide-enter { animation: slideIn 0.6s ease-out; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

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

    {{--  NAVBAR  --}}
    <nav class="fixed top-0 left-0 right-0 z-50 bg-navy-800 shadow-lg" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('storage/' . ($siteSettings['logo'] ?? '')) }}" alt="Tráfico" class="h-12 max-w-[180px] object-contain">
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
                        <a href="{{ $siteSettings['facebook'] ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <i data-lucide="facebook" class="w-4 h-4 text-white"></i>
                        </a>
                        <a href="{{ $siteSettings['instagram'] ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                            <i data-lucide="instagram" class="w-4 h-4 text-white"></i>
                        </a>
                        <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}" target="_blank"
                           class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center hover:bg-green-600 transition">
                            <i data-lucide="message-circle" class="w-4 h-4 text-white"></i>
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
                            <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Tráfico" class="h-10 max-w-[160px] object-contain">
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
                        <a href="{{ $siteSettings['facebook'] ?? '#' }}" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                            <i data-lucide="facebook" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ $siteSettings['instagram'] ?? '#' }}" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                            <i data-lucide="instagram" class="w-4 h-4"></i>
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
        <i data-lucide="message-circle" class="w-7 h-7 text-white"></i>
    </a>

    {{-- Scroll animations --}}
    <script>
        lucide.createIcons();

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