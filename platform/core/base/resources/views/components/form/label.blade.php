@props(['label', 'description' => null, 'helpText' => null, 'checkbox' => false])

<label {{ $attributes->merge(['class' => $checkbox ? 'form-check' : 'form-label']) }}>
    {{ $label ?? $slot }}

    @if ($description)
        <span class="form-label-description">
            {!! $description !!}
        </span>
    @endif

    @if ($helpText)
        <span
            class="form-help"
            data-bs-toggle="popover"
            data-bs-placement="top"
            data-bs-html="true"
            data-bs-content="{{ $helpText }}"
        >?</span>
    @endif
</label>
