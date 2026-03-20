@extends('layouts.admin')
@section('title', 'Configuración del Sitio')
@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="space-y-8 max-w-3xl">

        @foreach($settings as $group => $items)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-gray-800 capitalize">
                        @php
                            $groupLabels = ['general' => 'General', 'contact' => 'Contacto', 'social' => 'Redes Sociales'];
                        @endphp
                        {{ $groupLabels[$group] ?? ucfirst($group) }}
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    @foreach($items as $setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            </label>

                            @if($setting->type === 'image' || $setting->type === 'file')
                                @if($setting->value)
                                    <div class="mb-2">
                                        @if($setting->type === 'image')
                                            <img src="{{ asset('storage/' . $setting->value) }}" class="h-16 object-contain rounded-lg bg-gray-100 p-1">
                                        @else
                                            <a href="{{ asset('storage/' . $setting->value) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline">
                                                <i data-lucide="file" class="w-4 h-4"></i> {{ basename($setting->value) }}
                                            </a>
                                        @endif
                                    </div>
                                @endif
                                <input type="file" name="settings[{{ $setting->key }}]"
                                       accept="{{ $setting->type === 'image' ? 'image/*' : '.pdf,.doc,.docx' }}"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 file:cursor-pointer">
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="bg-navy-800 text-white px-8 py-3 rounded-lg text-sm font-medium hover:bg-navy-700 transition flex items-center gap-2">
            <i data-lucide="save" class="w-4 h-4"></i> Guardar cambios
        </button>
    </div>
</form>

@endsection
