@props([
    'id' => null,
    'label' => null,
    'name' => null,
    'options' => [],
    'value' => null,
    'wrapperClass' => null,
    'inputGroup' => false,
    'helpText' => null,
])

@php
    $id = $attributes->get('id', $name) ?? Str::random(8);
    
    $classes = Arr::toCssClasses(['form-select', 'is-invalid' => $errors->has($name)]);
@endphp

<div @class(['mb-3', $wrapperClass])>
    @if ($label)
        <x-core::form.label
            :label="$label"
            :for="$id"
            :$helpText
        />
    @endif

    @if ($inputGroup)
        <div class="input-group">
    @endif

    @isset($prepend)
        {!! $prepend !!}
    @endisset

    <select {{ $attributes->merge(['name' => $name, 'id' => $id])->class($classes) }}>
        @foreach ($options as $key => $item)
            <option
                value="{{ $key }}"
                @selected(old($name, $value) === $key)
            >{{ $item }}</option>
        @endforeach
    </select>

    @isset($append)
        {!! $append !!}
    @endisset

    @if ($inputGroup)
</div>
@endif
</div>
