<div class="tools">
    @php
        $hiddenIcons = '';
        if (Arr::get($settings, 'show_state', true) && Arr::get($settings, 'state', 'expand') == 'collapse') {
            $hiddenIcons = 'd-none';
        }
    @endphp
    @if (Arr::get($settings, 'show_predefined_ranges', false) && count($predefinedRanges))
        <div class="predefined-ranges d-inline-block {{ $hiddenIcons }}">
            {!! Form::customSelect(
                'predefined_range',
                collect($predefinedRanges)->pluck('label', 'key')->all(),
                Arr::get($settings, 'predefined_range'),
                ['class' => 'py-0'],
            ) !!}
        </div>
    @endif

    @if (Arr::get($settings, 'show_state', true))
        <a
            class="{{ Arr::get($settings, 'state', 'expand') }} collapse-expand"
            data-bs-toggle="tooltip"
            data-state="{{ Arr::get($settings, 'state', 'expand') == 'collapse' ? 'expand' : 'collapse' }}"
            href="#"
            title="{{ trans('core/dashboard::dashboard.collapse_expand') }}"
        ></a>
    @endif

    @if (Arr::get($settings, 'show_reload', true))
        <a
            class="reload {{ $hiddenIcons }}"
            data-bs-toggle="tooltip"
            href="#"
            title="{{ trans('core/dashboard::dashboard.reload') }}"
        ></a>
    @endif

    @if (Arr::get($settings, 'show_fullscreen', true))
        <a
            class="fullscreen {{ $hiddenIcons }}"
            data-bs-toggle="tooltip"
            data-bs-original-title="{{ trans('core/dashboard::dashboard.fullscreen') }}"
            href="#"
            title="{{ trans('core/dashboard::dashboard.fullscreen') }}"
        > </a>
    @endif

    @if (Arr::get($settings, 'show_remove', true))
        <a
            class="remove"
            data-bs-toggle="tooltip"
            href="#"
            title="{{ trans('core/dashboard::dashboard.hide') }}"
        ></a>
    @endif
</div>
