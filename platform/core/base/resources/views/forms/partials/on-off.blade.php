@php
    $id = $attributes['id'] ?? 'onoffswitch_' . $name . '_' . md5($name);
@endphp
<div class="onoffswitch">
    <input
        name="{{ $name }}"
        type="hidden"
        value="0"
    >
    <input
        class="onoffswitch-checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        type="checkbox"
        value="1"
        @if ($value) checked @endif
        {!! Html::attributes($attributes) !!}
    >
    <label
        class="onoffswitch-label"
        for="{{ $id }}"
    >
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>
