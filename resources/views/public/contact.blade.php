@extends('layouts.public')

@section('title', 'Contacto - Tráfico Soluciones Viales')

@section('content')

    <section class="bg-navy-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display font-bold text-4xl lg:text-5xl text-white">Contacto</h1>
            <p class="text-gray-400 mt-3">Estamos para ayudarte con tu proyecto</p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- Formulario --}}
                <div class="lg:col-span-3 fade-up">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6 flex items-center gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-500 shrink-0"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition">
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition">
                                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp / Número</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition">
                            </div>
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                                <input type="text" name="company" id="company" value="{{ old('company') }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                   class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje *</label>
                            <textarea name="message" id="message" rows="5" required
                                      class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:ring-2 focus:ring-navy-500 focus:border-navy-500 outline-none transition resize-none">{{ old('message') }}</textarea>
                            @error('message') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit"
                                class="w-full sm:w-auto bg-navy-800 text-white px-10 py-4 rounded-lg font-semibold text-sm hover:bg-navy-700 transition-all duration-300 flex items-center gap-2 justify-center">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            Enviar mensaje
                        </button>
                    </form>
                </div>

                {{-- Info de contacto --}}
                <div class="lg:col-span-2 fade-up">
                    <div class="bg-navy-800 rounded-2xl p-8 text-white sticky top-28">
                        <h3 class="font-display font-bold text-2xl mb-6">Información de contacto</h3>

                        <div class="space-y-5">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="mail" class="w-5 h-5 text-navy-800"></i>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Correo de ventas</p>
                                    <a href="mailto:{{ $siteSettings['email'] ?? 'ventas@trafico.com' }}" class="text-white font-medium hover:text-amber-400 transition">
                                        {{ $siteSettings['email'] ?? 'ventas@trafico.com' }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="phone" class="w-5 h-5 text-navy-800"></i>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Teléfono / WhatsApp</p>
                                    <a href="tel:{{ $siteSettings['phone'] ?? '8715118808' }}" class="text-white font-medium hover:text-amber-400 transition">
                                        {{ $siteSettings['phone'] ?? '871 511 8808' }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center shrink-0">
                                    <i data-lucide="message-circle" class="w-5 h-5 text-white"></i>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">WhatsApp directo</p>
                                    <a href="https://wa.me/{{ $siteSettings['whatsapp'] ?? '528715118808' }}" target="_blank" class="text-white font-medium hover:text-green-400 transition">
                                        Iniciar conversación
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- PDFs descargables --}}
                        <div class="mt-8 pt-6 border-t border-white/10">
                            <p class="text-gray-400 text-sm mb-3">Documentos</p>
                            <div class="flex flex-col gap-3">
                                @if(!empty($siteSettings['catalogo_pdf']))
                                    <a href="{{ asset('storage/' . $siteSettings['catalogo_pdf']) }}" target="_blank"
                                       class="flex items-center gap-3 bg-white/10 rounded-lg px-4 py-3 hover:bg-white/20 transition">
                                        <i data-lucide="file-text" class="w-5 h-5 text-red-400"></i>
                                        <span class="text-sm font-medium">Catálogo</span>
                                    </a>
                                @endif
                                @if(!empty($siteSettings['portafolio_pdf']))
                                    <a href="{{ asset('storage/' . $siteSettings['portafolio_pdf']) }}" target="_blank"
                                       class="flex items-center gap-3 bg-white/10 rounded-lg px-4 py-3 hover:bg-white/20 transition">
                                        <i data-lucide="file-text" class="w-5 h-5 text-red-400"></i>
                                        <span class="text-sm font-medium">Portafolio</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
