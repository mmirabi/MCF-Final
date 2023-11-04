<a
    class="add-faq-schema-items @if ($hasValue) hidden @endif"
    href="#"
>{{ trans('plugins/faq::faq.add_item') }}</a>

<div class="faq-schema-items @if (!$hasValue) hidden @endif">
    {!! Form::repeater('faq_schema_config', $value, [
        [
            'type' => 'textarea',
            'label' => trans('plugins/faq::faq.question'),
            'required' => true,
            'attributes' => [
                'name' => 'question',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 1000,
                    'rows' => 1,
                ],
            ],
        ],
        [
            'type' => 'textarea',
            'label' => trans('plugins/faq::faq.answer'),
            'required' => true,
            'attributes' => [
                'name' => 'answer',
                'value' => null,
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 1000,
                    'rows' => 1,
                ],
            ],
        ],
    ]) !!}
</div>
