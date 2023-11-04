@props(['name', 'label' => null, 'helperText' => null, 'value' => null, 'checked' => false, 'helperText' => null])

<x-core-setting::form-group>
    <input
        name="{{ $name }}"
        type="hidden"
        value="{{ (int) !($value !== null ? $value : 1) }}"
    >
    <label>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value !== null ? $value : 1 }}"
            @checked($checked ?? $value)
            {{ $attributes }}
        >
        {{ $label }}
    </label>

    @if ($helperText)
        {{ Form::helper($helperText) }}
    @endif
</x-core-setting::form-group>
