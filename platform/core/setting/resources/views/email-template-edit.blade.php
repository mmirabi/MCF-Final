@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['route' => ['setting.email.template.store']]) !!}
        <input
            name="module"
            type="hidden"
            value="{{ $pluginData['name'] }}"
        >
        <input
            name="template_file"
            type="hidden"
            value="{{ $pluginData['template_file'] }}"
        >

        <x-core-setting::section
            :title="trans('core/setting::setting.email.title')"
            :description="trans('core/setting::setting.email.description')"
        >
            @if ($emailSubject)
                <input
                    name="email_subject_key"
                    type="hidden"
                    value="{{ get_setting_email_subject_key($pluginData['type'], $pluginData['name'], $pluginData['template_file']) }}"
                >

                <x-core-setting::text-input
                    name="email_subject"
                    data-counter="300"
                    :label="trans('core/setting::setting.email.subject')"
                    :value="$emailSubject"
                />
            @endif

            <x-core-setting::form-group>
                <label
                    class="text-title-field"
                    for="email_content"
                >{{ trans('core/setting::setting.email.content') }}</label>
                <div class="d-inline-flex mb-3">
                    <div class="dropdown me-2">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <i class="fa fa-code"></i> {{ __('Variables') }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach (EmailHandler::getVariables($pluginData['type'], $pluginData['name'], $pluginData['template_file']) as $key => $label)
                                <li>
                                    <a
                                        class="js-select-mail-variable"
                                        data-key="{{ $key }}"
                                        href="#"
                                    >
                                        <span class="text-danger">{{ $key }}</span>: {{ trans($label) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            type="button"
                        >
                            <i class="fa fa-code"></i> {{ __('Functions') }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach (EmailHandler::getFunctions() as $key => $function)
                                <li>
                                    <a
                                        class="js-select-mail-function"
                                        data-key="{{ $key }}"
                                        data-sample="{{ $function['sample'] }}"
                                        href="#"
                                    >
                                        <span class="text-danger">{{ $key }}</span>:
                                        {{ trans($function['label']) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <textarea
                    class="form-control"
                    id="mail-template-editor"
                    name="email_content"
                    style="overflow-y:scroll; height: 500px;"
                >{{ $emailContent }}</textarea>
                {{ Form::helper(__('Learn more about Twig template: :url', ['url' => Html::link('https://twig.symfony.com/doc/3.x/', null, ['target' => '_blank'])])) }}
            </x-core-setting::form-group>

            <x-slot:pre-footer>
                <div class="mt-3">
                    {!! apply_filters(
                        'setting_email_template_meta_boxes',
                        null,
                        request()->route()->parameters(),
                    ) !!}
                </div>
            </x-slot:pre-footer>
        </x-core-setting::section>

        <div
            class="flexbox-annotated-section"
            style="border: none"
        >
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <a
                    class="btn btn-secondary"
                    href="{{ route('settings.email') }}"
                >{{ trans('core/setting::setting.email.back') }}</a>
                <a
                    class="btn btn-success"
                    href="{{ route('setting.email.preview', ['type' => $pluginData['type'], 'module' => $pluginData['name'], 'template' => $pluginData['template_file']]) }}"
                    target="_blank"
                >
                    {{ trans('core/setting::setting.preview') }}
                    <i class="fa fa-external-link"></i>
                </a>
                <a
                    class="btn btn-warning btn-trigger-reset-to-default"
                    data-target="{{ route('setting.email.template.reset-to-default', ['ref_lang' => BaseHelper::stringify(request()->input('ref_lang'))]) }}"
                >{{ trans('core/setting::setting.email.reset_to_default') }}</a>
                <button
                    class="btn btn-info"
                    name="submit"
                    type="submit"
                >{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <x-core::modal
        id="reset-template-to-default-modal"
        type="info"
        :title="trans('core/setting::setting.email.confirm_reset')"
        button-id="reset-template-to-default-button"
        :button-label="trans('core/setting::setting.email.continue')"
    >
        {!! trans('core/setting::setting.email.confirm_message') !!}
    </x-core::modal>
@endsection
