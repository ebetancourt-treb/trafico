@extends('layouts.admin')
@section('title', 'Subcategorías')
@section('header-actions')
    <a href="{{ route('admin.subcategories.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nueva Subcategoría</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Nombre</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Industria</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Proyectos</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Estado</th>
                <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($subcategories as $sub)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3 font-medium text-gray-800">{{ $sub->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $sub->industry->name ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $sub->projects_count }}</td>
                <td class="px-6 py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sub->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $sub->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.subcategories.edit', $sub) }}" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.subcategories.destroy', $sub) }}" method="POST" onsubmit="return confirm('¿Eliminar? Se eliminarán sus proyectos.')">@csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay subcategorías.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
