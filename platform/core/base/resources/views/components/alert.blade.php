@props([
    'type' => 'info',
    'title' => null,
    'subtitle' => null,
    'dismissible' => false,
    'icon' => null,
    'important' => false,
])

@php
    $color = match ($type) {
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger' => 'alert-danger',
        default => 'alert-info',
    };
@endphp

<div
    role="alert"
    @class([
        'bg-white alert',
        $color,
        'alert-dismissible' => $dismissible,
        'alert-important' => $important,
    ])
>
    @if ($icon)
        <div class="d-flex">
            <div>
                <i class="icon alert-icon {{ $icon }}"></i>
            </div>

            <div>
    @endif

    @if ($title)
        <h4 @class(['alert-title' => !$important])>{!! $title !!}</h4>
    @endif

    @if ($subtitle)
        <div @class(['text-muted' => !$important])>{!! $subtitle !!}</div>
    @endif

    {{ $slot }}

    @if ($icon)
</div>
</div>
@endif

@if ($dismissible)
    <a
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="close"
    ></a>
@endif
</div>
