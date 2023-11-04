@if (sizeof($values = (array) $values) > 1)
    <div class="mt-checkbox-list">
@endif
@foreach ($values as $value)
    <label class="mb-2">
        <input
            name="{{ $value[0] ?? '' }}"
            type="checkbox"
            value="{{ $value[1] ?? '' }}"
            @checked($value[3] ?? false)
            @disabled($value[4] ?? false)
        >
        {!! BaseHelper::clean($value[2] ?? '') !!}
    </label>
@endforeach
@if (sizeof($values) > 1)
    </div>
@endif
