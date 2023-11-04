@props([
    'id' => null,
    'type' => 'text',
    'label' => null,
    'name' => null,
    'value' => old($name),
    'wrapperClass' => null,
    'helpText' => null,
    'labelDescription' => null,
    'rounded' => false,
    'errorKey' => $name,
    'inputGroup' => false,
])

@php
    $id = $attributes->get('id', $name) ?? Str::random(8);
    
    $classes = Arr::toCssClasses(['form-control', 'is-invalid' => $errors->has($errorKey), 'form-control-rounded' => $rounded]);
    
    $inputGroup = $inputGroup || isset($prepend) || isset($append);
@endphp

<div @class(['mb-3', $wrapperClass])>
    @if ($label)
        <x-core::form.label
            :label="$label"
            :for="$id"
            :$helpText
            :description="$labelDescription"
        />
    @endif

    @if ($inputGroup)
        <div class="input-group">
    @endif

    @isset($prepend)
        {!! $prepend !!}
    @endisset

    <input
        {{ $attributes->merge(['type' => $type, 'name' => $name, 'id' => $id, 'value' => $value])->class($classes) }}>

    @isset($append)
        {!! $append !!}
    @endisset

    @if ($inputGroup)
</div>
@endif
<x-core::form.error :key="$errorKey" />
</div>
