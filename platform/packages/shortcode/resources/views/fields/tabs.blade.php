<div class="mb-3">
    <label class="form-label">{{ __('Quantity') }}</label>
    {!! Form::customSelect('quantity', $choices, $current, [
        'id' => $selector,
        'data-max' => $max,
        'class' => 'shortcode-tabs-quantity-select',
    ]) !!}
</div>

<div
    class="accordion"
    id="accordion-tab-shortcode mt-2"
    style="--bs-accordion-btn-padding-y: .7rem;"
>
    @for ($i = 1; $i <= $max; $i++)
        <div
            class="accordion-item @if ($i > $current) d-none @endif"
            data-tab-id="{{ $i }}"
        >
            <h2
                class="accordion-header"
                id="heading-{{ $i }}"
            >
                <button
                    class="accordion-button collapsed"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse-{{ $i }}"
                    type="button"
                    aria-expanded="false"
                    aria-controls="collapse-{{ $i }}"
                >
                    {{ __('Tab #:number', ['number' => $i]) }}
                </button>
            </h2>
            <div
                class="accordion-collapse collapse"
                id="collapse-{{ $i }}"
                data-bs-parent="#accordion-tab-shortcode"
                aria-labelledby="heading-{{ $i }}"
            >
                <div class="accordion-body bg-light">
                    <div class="section">
                        @foreach ($fields as $k => $field)
                            @php
                                $key = $k . '_' . $i;
                                $name = $i <= $current ? $key : '';
                            @endphp
                            <div class="mb-3">
                                <label @class(['form-label', 'required' => Arr::get($field, 'required')])>{{ Arr::get($field, 'title') }}</label>
                                @switch(Arr::get($field, 'type'))
                                    @case('image')
                                        {!! Form::mediaImage($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                    @break

                                    @case('color')
                                        {!! Form::customColor($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                    @break

                                    @case('icon')
                                        {!! Form::themeIcon($name, Arr::get($attributes, $key), ['data-name' => $key]) !!}
                                    @break

                                    @case('number')
                                        {!! Form::number($name, Arr::get($attributes, $key), [
                                            'class' => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name' => $key,
                                        ]) !!}
                                    @break

                                    @case('textarea')
                                        {!! Form::textarea($name, Arr::get($attributes, $key), [
                                            'class' => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name' => $key,
                                            'rows' => 3,
                                        ]) !!}
                                    @break

                                    @case('checkbox')
                                        {!! Form::customSelect($name, ['no' => __('No'), 'yes' => __('Yes')], Arr::get($attributes, $key), [
                                            'data-name' => $key,
                                        ]) !!}
                                    @break

                                    @case('select')
                                        {!! Form::customSelect($name, Arr::get($field, 'options', []), Arr::get($attributes, $key), [
                                            'data-name' => $key,
                                        ]) !!}
                                    @break

                                    @default
                                        {!! Form::text($name, Arr::get($attributes, $key), [
                                            'class' => 'form-control',
                                            'placeholder' => Arr::get($field, 'placeholder', Arr::get($field, 'title')),
                                            'data-name' => $key,
                                        ]) !!}
                                @endswitch

                                @if ($helper = Arr::get($field, 'helper'))
                                    {{ Form::helper($helper) }}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endfor
</div>

<script src="{{ asset('vendor/core/packages/shortcode/js/shortcode-fields.js') }}?v={{ time() }}"></script>
