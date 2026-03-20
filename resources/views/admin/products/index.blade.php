@extends('layouts.admin')
@section('title', 'Productos')
@section('header-actions')
    <a href="{{ route('admin.products.create') }}" class="bg-navy-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i> Nuevo Producto</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Imagen</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Nombre</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Categoría</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Orden</th>
                <th class="text-left px-6 py-3 font-medium text-gray-500">Estado</th>
                <th class="text-right px-6 py-3 font-medium text-gray-500">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-3">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-16 h-12 bg-gray-100 rounded-lg flex items-center justify-center"><i data-lucide="package" class="w-5 h-5 text-gray-300"></i></div>
                    @endif
                </td>
                <td class="px-6 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $product->category->name ?? '—' }}</td>
                <td class="px-6 py-3 text-gray-500">{{ $product->order }}</td>
                <td class="px-6 py-3"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $product->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-gray-400 hover:text-blue-600"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">@csrf @method('DELETE')
                            <button class="p-2 text-gray-400 hover:text-red-600"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No hay productos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
