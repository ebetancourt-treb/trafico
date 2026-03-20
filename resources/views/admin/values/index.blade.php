@extends('layouts.admin')
@section('title', 'Valores')
@section('header-actions')
    <a href="{{ route('admin.values.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nuevo Valor</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Título</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Descripción</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Orden</th>
                <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($values as $value)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium text-gray-800">{{ $value->title }}</td>
                <td class="px-6 py-3 text-gray-500 truncate max-w-xs">{{ $value->description }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $value->order }}</td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.values.edit', $value) }}" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.values.destroy', $value) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No hay valores.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
