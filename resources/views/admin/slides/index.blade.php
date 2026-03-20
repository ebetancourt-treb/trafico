@extends('layouts.admin')

@section('title', 'Slides')

@section('header-actions')
    <a href="{{ route('admin.slides.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2">
        <i data-lucide="plus" class="w-4 h-4"></i> Nuevo Slide
    </a>
@endsection

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-gray-500">Imagen</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500">Título</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500">Orden</th>
                    <th class="text-left px-6 py-3 font-medium text-gray-500">Estado</th>
                    <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($slides as $slide)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3">
                            @if($slide->image)
                                <img src="{{ asset('storage/' . $slide->image) }}" class="w-20 h-12 object-cover rounded-lg" alt="">
                            @else
                                <div class="w-20 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="image" class="w-5 h-5 text-gray-300"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $slide->title }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $slide->order }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $slide->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $slide->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.slides.edit', $slide) }}" class="p-2 text-gray-400 hover:text-blue-600 transition" title="Editar">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('¿Eliminar este slide?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">No hay slides creados aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
