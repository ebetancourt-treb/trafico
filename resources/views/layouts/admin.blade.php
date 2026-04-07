<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 700: '#1e2d6f', 800: '#151f52', 900: '#0d1433' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style> body { font-family: 'DM Sans', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-navy-800 text-white flex flex-col shrink-0 fixed h-full z-30" id="sidebar">
            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center">
                        <i data-lucide="triangle-alert" class="w-5 h-5 text-navy-800"></i>
                    </div>
                    <span class="font-bold text-lg">TRÁFICO</span>
                    <span class="text-xs bg-white/20 px-2 py-0.5 rounded ml-1">Admin</span>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                @php
                    $nav = [
                        ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                        ['route' => 'admin.slides.index', 'icon' => 'image', 'label' => 'Slides'],
                        ['route' => 'admin.sections.index', 'icon' => 'file-text', 'label' => 'Secciones'],
                        ['route' => 'admin.values.index', 'icon' => 'heart', 'label' => 'Valores'],
                        ['route' => 'admin.product-categories.index', 'icon' => 'layers', 'label' => 'Categorías'],
                        ['route' => 'admin.products.index', 'icon' => 'package', 'label' => 'Productos'],
                        ['route' => 'admin.industries.index', 'icon' => 'building-2', 'label' => 'Industrias'],
                        ['route' => 'admin.projects.index', 'icon' => 'folder-open', 'label' => 'Proyectos'],
                        ['route' => 'admin.subcategories.index', 'icon' => 'git-branch', 'label' => 'Subcategorías'],
                        ['route' => 'admin.gallery.index', 'icon' => 'gallery-horizontal-end', 'label' => 'Galería'],
                        ['route' => 'admin.gallery-categories.index', 'icon' => 'tags', 'label' => 'Cat. Galería'],
                        ['route' => 'admin.messages.index', 'icon' => 'mail', 'label' => 'Mensajes'],
                        ['route' => 'admin.settings.index', 'icon' => 'settings', 'label' => 'Configuración'],
                    ];
                @endphp

                @foreach($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs(str_replace('.index', '*', $item['route'])) ? 'bg-white/15 text-white' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
                        {{ $item['label'] }}
                        @if($item['route'] === 'admin.messages.index' && isset($unreadCount) && $unreadCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Footer --}}
            <div class="px-4 py-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-navy-800 font-bold text-sm">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-400 hover:text-white hover:bg-white/10 transition">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Cerrar sesión
                    </button>
                </form>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-400 hover:text-amber-400 hover:bg-white/10 transition mt-1">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Ver sitio
                </a>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="flex-1 ml-64">
            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-200 px-8 py-4 sticky top-0 z-20">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Panel de Administración')</h1>
                    @yield('header-actions')
                </div>
            </header>

            <div class="p-8">
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 mb-6 flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-500 shrink-0"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6 flex items-center gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>
