@props([
    'label' => null,
    'icon' => null,
    'href' => null,
    'active' => false,
    'iconPlacement' => 'left',
])

@php
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }} {{ $attributes->merge(['href' => $href])->class(['dropdown-item', 'active' => $active]) }}>
    @if ($icon && $iconPlacement === 'left')
        <x-core::icon
            class="dropdown-item-icon"
            :name="$icon"
        />
    @endif

    {{ $label ?? $slot }}

    @if ($icon && $iconPlacement === 'right')
        <x-core::icon
            class="dropdown-item-icon"
            :name="$icon"
        />
    @endif
    </{{ $tag }}>
