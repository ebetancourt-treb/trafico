@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'Slides', 'value' => $slidesCount, 'icon' => 'image', 'color' => 'bg-blue-500', 'route' => 'admin.slides.index'],
                ['label' => 'Productos', 'value' => $productsCount, 'icon' => 'package', 'color' => 'bg-amber-500', 'route' => 'admin.products.index'],
                ['label' => 'Galería', 'value' => $galleryCount, 'icon' => 'gallery-horizontal-end', 'color' => 'bg-green-500', 'route' => 'admin.gallery.index'],
                ['label' => 'Mensajes sin leer', 'value' => $messagesCount, 'icon' => 'mail', 'color' => 'bg-red-500', 'route' => 'admin.messages.index'],
            ];
        @endphp

        @foreach($stats as $stat)
            <a href="{{ route($stat['route']) }}" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition group">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 {{ $stat['color'] }} rounded-lg flex items-center justify-center">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5 text-white"></i>
                    </div>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition"></i>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $stat['value'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- Recent messages --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-800">Mensajes recientes</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recentMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                    <div class="w-10 h-10 rounded-full {{ $msg->is_read ? 'bg-gray-100' : 'bg-blue-100' }} flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-5 h-5 {{ $msg->is_read ? 'text-gray-400' : 'text-blue-500' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }} - {{ $msg->subject ?? 'Sin asunto' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $msg->message }}</p>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-gray-400">
                    <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-gray-300"></i>
                    <p class="text-sm">No hay mensajes aún</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection
