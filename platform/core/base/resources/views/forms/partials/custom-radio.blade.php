@php
    $values = (array) $values;
@endphp
@if (count($values) > 1)
    <div class="mt-radio-list">
@endif
@foreach ($values as $line)
    @php
        $value = $line[0] ?? '';
        $label = $line[1] ?? '';
        $disabled = $line[2] ?? '';
    @endphp
    <label class="me-2">
        {!! Form::radio($name, $value, (string) $selected === (string) $value, ['disabled' => (bool) $disabled]) !!}
        {{ $label }}
    </label>
@endforeach
@if (count($values) > 1)
    </div>
@endif
