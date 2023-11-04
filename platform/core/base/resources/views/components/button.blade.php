@props([
    'type' => 'button',
    'tag' => 'button',
    'disabled' => false,
    'color' => null,
    'icon' => null,
    'square' => false,
    'pill' => false,
    'iconPosition' => 'left',
    'outlined' => false,
    'size' => null,
    'loading' => false,
    'loadingOverlay' => false,
    'tooltip' => null,
    'tooltipPlacement' => 'top',
])

@php
    $class = Arr::toCssClasses([
        'btn',
        'disabled' => $disabled,
        'btn-square' => $square,
        'btn-pill' => $pill,
        'btn-icon' => $slot->isEmpty(),
        'btn-loading' => $loading && $loadingOverlay,
        ...$outlined ? [$color ? "btn-outline-$color" : null] : [$color ? "btn-$color" : null],
        match ($size) {
            'sm' => 'btn-sm',
            'lg' => 'btn-lg',
            default => null,
        },
    ]);
    
    $spinnerClasses = Arr::toCssClasses(['spinner-border', 'spinner-border-sm', 'me-2' => $iconPosition === 'left', 'ms-2' => $iconPosition === 'right']);
@endphp

<{{ $tag }}
    {{ $attributes->merge([
            'type' => $type,
            'disabled' => $disabled,
        ])->class($class) }}
    @if ($tooltip) data-bs-toggle="tooltip"
        data-bs-placement="{{ $tooltipPlacement }}"
        title="{{ $tooltip }}" @endif
>
    @if ($icon && $iconPosition === 'left')
        @if ($loading)
            <span
                class="{{ $spinnerClasses }}"
                role="status"
            ></span>
        @else
            <x-core-base::icon
                class="icon-left"
                :name="$icon"
            />
        @endif
    @endif

    @if ($slot->isEmpty())
        <span class="sr-only">{{ $slot }}</span>
    @else
        {{ $slot }}
    @endif

    @if ($icon && $iconPosition === 'right')
        @if ($loading)
            <span
                class="{{ $spinnerClasses }}"
                role="status"
            ></span>
        @else
            <x-core-base::icon
                class="icon-right"
                :name="$icon"
            />
        @endif
    @endif
    </{{ $tag }}>
