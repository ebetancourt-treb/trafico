@extends('layouts.admin')
@section('title', 'Proyectos')
@section('header-actions')
    <a href="{{ route('admin.projects.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nuevo Proyecto</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Imagen</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Nombre</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Categoría</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Ubicación</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Estado</th>
                <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($projects as $project)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="w-16 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center"><i data-lucide="image" class="w-5 h-5 text-gray-300"></i></div>
                    @endif
                </td>
                <td class="px-6 py-3 font-medium text-gray-800">{{ $project->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $project->industry->name ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $project->location ?? '—' }}</td>
                <td class="px-6 py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $project->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Eliminar este proyecto?')">@csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay proyectos creados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
