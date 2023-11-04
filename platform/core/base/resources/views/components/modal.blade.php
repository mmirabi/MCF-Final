@props([
    'id' => null,
    'class' => null,
    'title' => null,
    'buttonLabel' => null,
    'type' => 'info',
    'size' => null,
    'buttonClass' => null,
    'buttonId' => null,
    'header' => null,
    'footer' => null,
    'headerIcon' => null,
    'options' => [],
])

<div
    data-backdrop="static"
    data-keyboard="false"
    role="dialog"
    aria-labelledby="{{ $id }}"
    aria-hidden="true"
    tabindex="-1"
    @if ($id) id="{{ $id }}" @endif
    @class(['modal fade', $class => $class])
    @if ($options) {!! Html::attributes(array_merge(['data-backdrop' => 'static', 'data-keyboard' => 'false'], $options)) !!} @else @endif>
    <div @class([
        'modal-dialog',
        'modal-xs' => !$size && strlen($slot) < 120,
        'modal-lg' => !$size && strlen($slot) > 1000,
        'modal-' . str_replace('modal-', '', (string) $size) => $size,
    ])>
        <div class="modal-content">
            @if ($header !== false)
                @if ($header)
                    {!! $header !!}
                @else
                    <div class="modal-header bg-{{ $type }}">
                        <h4 class="modal-title">
                            @if ($headerIcon !== false)
                                {!! $headerIcon !!}
                            @else
                                <i class="til_img"></i>
                            @endif
                            @if ($title !== false)
                                <strong>{!! $title !!}</strong>
                            @endif
                        </h4>
                        <button
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"
                            aria-hidden="true"
                        ></button>
                    </div>
                @endif
            @endif

            <div class="modal-body with-padding">
                {{ $slot }}
            </div>

            @if ($footer !== false)
                <div class="modal-footer">
                    @if ($footer)
                        {!! $footer !!}
                    @else
                        <button
                            class="float-start btn btn-{{ $type != 'warning' ? 'warning' : 'info' }}"
                            data-bs-dismiss="modal"
                            type="button"
                        >{{ trans('core/base::tables.cancel') }}</button>
                        <button
                            class="float-end btn btn-{{ $type }} @if ($buttonClass) {{ $buttonClass }} @endif"
                            type="submit"
                            @if ($buttonId) id="{{ $buttonId }}" @endif
                        >{!! $buttonLabel !!}</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
