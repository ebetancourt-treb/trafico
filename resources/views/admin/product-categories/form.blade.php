@extends('layouts.admin')
@section('title', $category->exists ? 'Editar Categoría' : 'Nueva Categoría')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.product-categories.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 mb-6"><i data-lucide="arrow-left" class="w-4 h-4"></i> Volver</a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500"></i>
                    <span class="font-medium">Se encontraron errores:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $category->exists ? route('admin.product-categories.update', $category) : route('admin.product-categories.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($category->exists) @method('PUT') @endif

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-navy-500 outline-none">
            </div>

            {{-- ══════ ICONO ══════ --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Icono de la categoría</label>

                {{-- Preview actual --}}
                <div class="flex items-center gap-4 mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="w-14 h-14 rounded-xl bg-navy-800 flex items-center justify-center shrink-0" id="icon-preview">
                        @if($category->custom_icon)
                            <img src="{{ asset('storage/' . $category->custom_icon) }}" class="w-8 h-8 object-contain" alt="">
                        @else
                            <i data-lucide="{{ old('icon', $category->icon ?? 'box') }}" class="w-7 h-7 text-white"></i>
                        @endif
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-800" id="icon-name-display">
                            @if($category->custom_icon)
                                Icono personalizado
                            @else
                                {{ old('icon', $category->icon ?? 'box') }}
                            @endif
                        </span>
                        <p class="text-xs text-gray-400">Vista previa del icono seleccionado</p>
                    </div>
                </div>

                {{-- Tabs: Librería / Personalizado --}}
                <div class="flex gap-2 mb-4">
                    <button type="button" onclick="switchTab('library')" id="tab-library"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition bg-navy-800 text-white">
                        <i data-lucide="grid-3x3" class="w-4 h-4 inline -mt-0.5"></i> Elegir de librería
                    </button>
                    <button type="button" onclick="switchTab('upload')" id="tab-upload"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i data-lucide="upload" class="w-4 h-4 inline -mt-0.5"></i> Subir icono propio
                    </button>
                </div>

                {{-- Input hidden para el icono de Lucide --}}
                <input type="hidden" name="icon" id="icon-input" value="{{ old('icon', $category->icon ?? 'box') }}">

                {{-- TAB 1: Librería de iconos --}}
                <div id="panel-library">
                    <div class="grid grid-cols-8 sm:grid-cols-10 gap-2 max-h-72 overflow-y-auto p-3 bg-gray-50 rounded-xl border border-gray-200">
                        @php
                            $availableIcons = [
                                'signpost', 'paintbrush', 'construction', 'hard-hat', 'traffic-cone',
                                'shield', 'shield-check', 'alert-triangle', 'octagon', 'circle-dot',
                                'wrench', 'hammer', 'paint-bucket', 'pipette', 'spray-can',
                                'brush', 'ruler', 'scissors', 'bolt', 'cog',
                                'car', 'truck', 'road', 'map-pin', 'navigation',
                                'route', 'milestone', 'arrow-right-left', 'parking-meter', 'fence',
                                'building', 'building-2', 'factory', 'warehouse', 'home',
                                'landmark', 'store', 'hotel', 'church', 'school',
                                'eye', 'lock', 'scan', 'badge-check', 'check-circle',
                                'star', 'award', 'medal', 'trophy', 'crown',
                                'box', 'package', 'layers', 'grid-3x3', 'circle',
                                'square', 'triangle', 'hexagon', 'diamond', 'zap',
                                'flame', 'droplets', 'sun', 'mountain', 'trees',
                                'lightbulb', 'target', 'crosshair', 'compass', 'flag',
                            ];
                        @endphp

                        @foreach($availableIcons as $iconName)
                            <button type="button"
                                    onclick="selectIcon('{{ $iconName }}')"
                                    title="{{ $iconName }}"
                                    class="icon-option aspect-square rounded-lg border-2 flex items-center justify-center transition-all duration-200 hover:bg-navy-800 hover:text-white hover:border-navy-800 cursor-pointer
                                           {{ (old('icon', $category->icon) === $iconName && !$category->custom_icon) ? 'bg-navy-800 text-white border-navy-800' : 'bg-white text-gray-500 border-gray-200' }}"
                                    data-icon="{{ $iconName }}">
                                <i data-lucide="{{ $iconName }}" class="w-5 h-5"></i>
                            </button>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Haz clic en un icono para seleccionarlo. Se muestran 60+ iconos disponibles.</p>
                </div>

                {{-- TAB 2: Subir icono personalizado --}}
                <div id="panel-upload" class="hidden">
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-5 space-y-4">
                        {{-- Icono personalizado existente --}}
                        @if($category->custom_icon)
                            <div class="flex items-center gap-4 p-3 bg-white rounded-lg border border-gray-100">
                                <img src="{{ asset('storage/' . $category->custom_icon) }}" class="w-12 h-12 object-contain rounded-lg bg-gray-50 p-1" alt="">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Icono actual</p>
                                    <p class="text-xs text-gray-400">{{ basename($category->custom_icon) }}</p>
                                </div>
                                <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_custom_icon" value="1" class="w-4 h-4 rounded border-gray-300 text-red-600">
                                    Eliminar
                                </label>
                            </div>
                        @endif

                        {{-- Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subir icono personalizado</label>
                            <input type="file" name="custom_icon" accept=".png,.svg,.webp"
                                   onchange="previewCustomIcon(this)"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-800 file:text-white hover:file:bg-navy-700 file:cursor-pointer">
                        </div>

                        {{-- Especificaciones --}}
                        <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                            <div class="flex items-start gap-2">
                                <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
                                <div class="text-sm text-amber-800">
                                    <p class="font-semibold mb-1">Especificaciones del archivo:</p>
                                    <ul class="space-y-1 text-xs text-amber-700">
                                        <li>• <strong>Formatos:</strong> PNG, SVG o WebP</li>
                                        <li>• <strong>Tamaño máximo:</strong> 1 MB</li>
                                        <li>• <strong>Dimensiones recomendadas:</strong> 128×128 px o 256×256 px</li>
                                        <li>• <strong>Fondo:</strong> Transparente (PNG/SVG) para mejor resultado</li>
                                        <li>• <strong>Color:</strong> Preferiblemente blanco o de un solo color (se mostrará sobre fondo oscuro)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Preview del archivo subido --}}
                        <div id="custom-icon-preview-container" class="hidden">
                            <p class="text-xs text-gray-500 mb-2">Vista previa:</p>
                            <div class="flex gap-4">
                                <div class="w-14 h-14 rounded-xl bg-navy-800 flex items-center justify-center p-2">
                                    <img id="custom-icon-preview-img" src="" class="w-8 h-8 object-contain" alt="">
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-2">
                                    <img id="custom-icon-preview-img-light" src="" class="w-8 h-8 object-contain" alt="">
                                </div>
                                <div class="flex items-center">
                                    <span class="text-xs text-gray-400">Fondo oscuro / fondo claro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orden --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
                <input type="number" name="order" value="{{ old('order', $category->order ?? 0) }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none">
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none resize-none">{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- Activo --}}
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-navy-800">
                <span class="text-sm text-gray-700">Activo</span>
            </label>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="bg-navy-800 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-navy-700 transition">
                    {{ $category->exists ? 'Actualizar' : 'Crear' }}
                </button>
                <a href="{{ route('admin.product-categories.index') }}" class="text-sm text-gray-500">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ── Tabs ──
    function switchTab(tab) {
        const library = document.getElementById('panel-library');
        const upload = document.getElementById('panel-upload');
        const tabLib = document.getElementById('tab-library');
        const tabUp = document.getElementById('tab-upload');

        if (tab === 'library') {
            library.classList.remove('hidden');
            upload.classList.add('hidden');
            tabLib.classList.add('bg-navy-800', 'text-white');
            tabLib.classList.remove('bg-gray-100', 'text-gray-600');
            tabUp.classList.remove('bg-navy-800', 'text-white');
            tabUp.classList.add('bg-gray-100', 'text-gray-600');
        } else {
            library.classList.add('hidden');
            upload.classList.remove('hidden');
            tabUp.classList.add('bg-navy-800', 'text-white');
            tabUp.classList.remove('bg-gray-100', 'text-gray-600');
            tabLib.classList.remove('bg-navy-800', 'text-white');
            tabLib.classList.add('bg-gray-100', 'text-gray-600');
        }
    }

    // ── Seleccionar icono de librería ──
    function selectIcon(iconName) {
        document.getElementById('icon-input').value = iconName;
        document.getElementById('icon-name-display').textContent = iconName;

        // Actualizar preview
        const preview = document.getElementById('icon-preview');
        preview.innerHTML = `<i data-lucide="${iconName}" class="w-7 h-7 text-white"></i>`;
        lucide.createIcons();

        // Estilos de selección
        document.querySelectorAll('.icon-option').forEach(btn => {
            btn.classList.remove('bg-navy-800', 'text-white', 'border-navy-800');
            btn.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
        });

        const selected = document.querySelector(`.icon-option[data-icon="${iconName}"]`);
        if (selected) {
            selected.classList.remove('bg-white', 'text-gray-500', 'border-gray-200');
            selected.classList.add('bg-navy-800', 'text-white', 'border-navy-800');
        }
    }

    // ── Preview de icono personalizado ──
    function previewCustomIcon(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('custom-icon-preview-img').src = e.target.result;
                document.getElementById('custom-icon-preview-img-light').src = e.target.result;
                document.getElementById('custom-icon-preview-container').classList.remove('hidden');

                // Actualizar preview principal
                const preview = document.getElementById('icon-preview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-8 h-8 object-contain" alt="">`;
                document.getElementById('icon-name-display').textContent = 'Icono personalizado';

                // Limpiar selección de librería
                document.getElementById('icon-input').value = '';
                document.querySelectorAll('.icon-option').forEach(btn => {
                    btn.classList.remove('bg-navy-800', 'text-white', 'border-navy-800');
                    btn.classList.add('bg-white', 'text-gray-500', 'border-gray-200');
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Si ya tiene icono personalizado, mostrar tab de upload
    @if($category->custom_icon)
        switchTab('upload');
    @endif
</script>
@endpush

@endsection
