@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'wrapperClass' => null,
])

@php
    $id = $attributes->get('id', $name) ?? Str::random(8);
@endphp

<div @class(['mb-3', $wrapperClass])>
    <x-core::form.label
        checkbox="true"
        :for="$id"
    >
        <input
            {{ $attributes->merge(['type' => 'checkbox', 'id' => $id, 'name' => $name, 'class' => 'form-check-input']) }}
            @checked(old($name))
        />
        <span class="form-check-label">{{ $label }}</span>
    </x-core::form.label>
</div>
