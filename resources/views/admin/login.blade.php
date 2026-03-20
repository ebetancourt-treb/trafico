<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Tráfico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style> body { font-family: 'DM Sans', sans-serif; } </style>
</head>
<body class="bg-[#151f52] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="triangle-alert" class="w-9 h-9 text-[#151f52]"></i>
            </div>
            <h1 class="text-white text-2xl font-bold">TRÁFICO</h1>
            <p class="text-gray-400 text-sm mt-1">Panel de Administración</p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-3 mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-[#151f52] focus:border-[#151f52] outline-none">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" name="password" id="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-[#151f52] focus:border-[#151f52] outline-none">
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#151f52] focus:ring-[#151f52]">
                    <span class="text-sm text-gray-600">Recordarme</span>
                </label>

                <button type="submit"
                        class="w-full bg-[#151f52] text-white py-3 rounded-lg font-semibold text-sm hover:bg-[#1e2d6f] transition flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Iniciar sesión
                </button>
            </form>
        </div>

        <p class="text-center text-gray-500 text-xs mt-6">
            <a href="{{ route('home') }}" class="hover:text-amber-400 transition">&larr; Volver al sitio</a>
        </p>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
