@props(['label', 'icon' => null, 'items' => null, 'hasArrow' => false, 'wrapperClass' => null, 'trigger' => null])

<div @class(['dropdown', $wrapperClass])>
    @if ($trigger)
        {!! $trigger !!}
    @else
        <x-core::button
            {{ $attributes->merge([
                'type' => 'button',
                'class' => 'dropdown-toggle',
                'data-bs-toggle' => 'dropdown',
            ]) }}
        >
            @if ($icon)
                <x-core::icon :name="$icon" />
            @endif

            {{ $label }}
        </x-core::button>
    @endif

    <div @class(['dropdown-menu', 'dropdown-menu-arrow' => $hasArrow])>
        {{ $items ?? $slot }}
    </div>
</div>
