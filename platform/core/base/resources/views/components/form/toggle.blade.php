@props(['label', 'name' => null, 'checked' => null])

<x-core::form-group>
    <label class="form-check form-switch">
        <input
            name="{{ $name }}"
            type="hidden"
            value="0"
        >
        <input
            class="form-check-input"
            name="{{ $name }}"
            type="checkbox"
            value="1"
            @checked($checked)
        />
        <span class="form-check-label">{!! $label !!}</span>
    </label>
</x-core::form-group>
