@props([
    'key' => null,
])

@error($key)
    <div {{ $attributes->class('invalid-feedback')->merge() }}>
        {{ $message }}
    </div>
@enderror
