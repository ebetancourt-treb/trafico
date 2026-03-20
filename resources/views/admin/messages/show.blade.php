@extends('layouts.admin')
@section('title', 'Mensaje de ' . $message->name)
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $message->name }}</h2>
                <p class="text-sm text-gray-400">{{ $message->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                @csrf @method('DELETE')
                <button class="p-2 text-gray-400 hover:text-red-600 transition"><i data-lucide="trash-2" class="w-5 h-5"></i></button>
            </form>
        </div>

        <div class="space-y-4 text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-400 block mb-1">Email</span>
                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:underline">{{ $message->email }}</a>
                </div>
                <div>
                    <span class="text-gray-400 block mb-1">Teléfono / WhatsApp</span>
                    @if($message->phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone) }}" target="_blank" class="text-green-600 hover:underline">{{ $message->phone }}</a>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-400 block mb-1">Empresa</span>
                    <span class="text-gray-800">{{ $message->company ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-400 block mb-1">Asunto</span>
                    <span class="text-gray-800">{{ $message->subject ?? '—' }}</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <span class="text-gray-400 block mb-2">Mensaje</span>
                <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="mailto:{{ $message->email }}" class="bg-navy-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2">
                <i data-lucide="mail" class="w-4 h-4"></i> Responder por email
            </a>
            @if($message->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $message->phone) }}" target="_blank" class="bg-green-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 transition flex items-center gap-2">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> WhatsApp
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
