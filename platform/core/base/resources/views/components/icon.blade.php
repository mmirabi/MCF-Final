@props(['name'])

<i {{ $attributes->merge(['class' => "icon $name"]) }}></i>
