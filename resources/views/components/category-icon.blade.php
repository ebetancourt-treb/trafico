{{-- 
    Uso: @include('components.category-icon', ['category' => $category, 'size' => 'lg'])
    Sizes: sm (w-5 h-5), md (w-6 h-6), lg (w-7 h-7)
--}}
@php
    $sizes = [
        'sm' => ['icon' => 'w-5 h-5', 'img' => 'w-5 h-5'],
        'md' => ['icon' => 'w-6 h-6', 'img' => 'w-6 h-6'],
        'lg' => ['icon' => 'w-7 h-7', 'img' => 'w-7 h-7'],
    ];
    $s = $sizes[$size ?? 'md'];
@endphp

@if($category->custom_icon)
    <img src="{{ asset('storage/' . $category->custom_icon) }}" alt="{{ $category->name }}" class="{{ $s['img'] }} object-contain">
@else
    <i data-lucide="{{ $category->icon ?? 'box' }}" class="{{ $s['icon'] }} text-white"></i>
@endif
