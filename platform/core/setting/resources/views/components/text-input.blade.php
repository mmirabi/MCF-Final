@props(['name', 'label' => null, 'value' => null, 'type' => 'text', 'helperText' => null])

<x-core-setting::form-group>
    @if ($label)
        <label
            class="text-title-field"
            for="{{ $name }}"
        >{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        value="{{ old($name) && !is_array(old($name)) ? old($name) : $value }}"
        {{ $attributes->merge([
            'class' => 'form-control next-input' . ($errors->has($name) ? ' is-invalid' : ''),
            'name' => $name,
            'id' => $name,
        ]) }}
    >

    @if ($helperText)
        {{ Form::helper($helperText) }}
    @endif

    {{ $slot }}
</x-core-setting::form-group>
