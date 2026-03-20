@extends('layouts.admin')
@section('title', 'Mensajes de Contacto')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Estado</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Nombre</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Email</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Asunto</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Fecha</th>
                <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($messages as $msg)
            <tr class="hover:bg-gray-50 {{ !$msg->is_read ? 'bg-blue-50/50' : '' }}">
                <td class="px-6 py-3">
                    @if(!$msg->is_read)
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                    @else
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-300 inline-block"></span>
                    @endif
                </td>
                <td class="px-6 py-3 font-medium text-gray-800 {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $msg->email }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $msg->subject ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-400 text-xs">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.messages.show', $msg) }}" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="eye" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay mensajes.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($messages->hasPages())
    <div class="mt-6">{{ $messages->links() }}</div>
@endif
@endsection
