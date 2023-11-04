<div
    id="{{ $id . '-parent' }}"
    @class(['mb-3', 'widget-item', 'col-md-' . $columns => $columns])
>
    <div class="h-100 bg-white-opacity position-relative">
        {!! $content !!}
        @if ($hasChart)
            <div
                class="position-absolute fixed-bottom"
                id="{{ $id }}"
            ></div>
        @endif
    </div>

    @if ($hasChart)
        @include('core/base::widgets.partials.chart-script')
    @endif
</div>
