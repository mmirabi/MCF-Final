@props([
    'action' => null,
    'method' => 'GET',
    'enctype' => null,
    'csrf' => true,
])

@php
    $method = strtoupper($method);
@endphp

<form {{ $attributes->merge(['action' => $action, 'method' => $method, 'enctype' => $enctype]) }}>
    @if ($csrf)
        @csrf
    @endif

    @if ($method && !in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    {{ $slot }}
</form>
