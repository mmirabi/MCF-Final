@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200 email-settings">
        {!! Form::open(['route' => ['settings.email.edit']]) !!}
        @if (config('core.setting.general.enable_email_smtp_settings', true))
            <x-core-setting::section
                :title="trans('core/setting::setting.email_setting_title')"
                :description="trans('core/setting::setting.email.description')"
            >
                <x-core-setting::select
                    class="setting-select-options"
                    name="email_driver"
                    :label="trans('core/setting::setting.email.mailer')"
                    :options="[
                        'smtp' => 'SMTP',
                        'mailgun' => 'Mailgun',
                        'ses' => 'SES',
                        'postmark' => 'Postmark',
                        'log' => 'Log',
                        'array' => 'Array',
                    ] + (function_exists('proc_open') ? ['sendmail' => 'Sendmail'] : [])"
                    :value="setting('email_driver', config('mail.default'))"
                />

                <div
                    data-type="smtp"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'smtp',
                    ])
                >
                    <x-core-setting::text-input
                        name="email_port"
                        data-counter="10"
                        type="number"
                        :label="trans('core/setting::setting.email.port')"
                        :value="setting('email_port', config('mail.mailers.smtp.port'))"
                        :placeholder="trans('core/setting::setting.email.port_placeholder')"
                    />

                    <x-core-setting::text-input
                        name="email_host"
                        data-counter="60"
                        type="text"
                        :label="trans('core/setting::setting.email.host')"
                        :value="setting('email_host', config('mail.mailers.smtp.host'))"
                        :placeholder="trans('core/setting::setting.email.host_placeholder')"
                    />

                    <x-core-setting::text-input
                        name="email_username"
                        data-counter="120"
                        type="text"
                        :label="trans('core/setting::setting.email.username')"
                        :value="setting('email_username', config('mail.mailers.smtp.username'))"
                        :placeholder="trans('core/setting::setting.email.username_placeholder')"
                    />

                    <x-core-setting::text-input
                        name="email_password"
                        data-counter="120"
                        type="password"
                        :label="trans('core/setting::setting.email.password')"
                        :value="setting('email_password', config('mail.mailers.smtp.password'))"
                        :placeholder="trans('core/setting::setting.email.password_placeholder')"
                    />

                    <x-core-setting::text-input
                        name="email_encryption"
                        data-counter="20"
                        :label="trans('core/setting::setting.email.encryption')"
                        :value="setting('email_encryption', config('mail.mailers.smtp.encryption'))"
                        :placeholder="trans('core/setting::setting.email.encryption_placeholder')"
                    />
                </div>

                <div
                    data-type="mailgun"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'mailgun',
                    ])
                >
                    <x-core-setting::text-input
                        name="email_mail_gun_domain"
                        data-counter="120"
                        :label="trans('core/setting::setting.email.mail_gun_domain')"
                        :value="setting('email_mail_gun_domain', config('services.mailgun.domain'))"
                        :placeholder="trans('core/setting::setting.email.mail_gun_domain_placeholder')"
                    />

                    @if (!BaseHelper::hasDemoModeEnabled())
                        <x-core-setting::text-input
                            name="email_mail_gun_secret"
                            data-counter="120"
                            :label="trans('core/setting::setting.email.mail_gun_secret')"
                            :value="setting('email_mail_gun_secret', config('services.mailgun.secret'))"
                            :placeholder="trans('core/setting::setting.email.mail_gun_secret_placeholder')"
                        />
                    @endif

                    <x-core-setting::text-input
                        name="email_mail_gun_endpoint"
                        data-counter="120"
                        :label="trans('core/setting::setting.email.mail_gun_endpoint')"
                        :value="setting('email_mail_gun_endpoint', config('services.mailgun.endpoint'))"
                        :placeholder="trans('core/setting::setting.email.mail_gun_endpoint_placeholder')"
                    />
                </div>

                <div
                    data-type="ses"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'ses',
                    ])
                >
                    <x-core-setting::text-input
                        name="email_ses_key"
                        data-counter="120"
                        :label="trans('core/setting::setting.email.ses_key')"
                        :value="setting('email_ses_key', config('services.ses.key'))"
                        :placeholder="trans('core/setting::setting.email.ses_key_placeholder')"
                    />

                    @if (!BaseHelper::hasDemoModeEnabled())
                        <x-core-setting::text-input
                            name="email_ses_secret"
                            data-counter="120"
                            :label="trans('core/setting::setting.email.ses_secret')"
                            :value="setting('email_ses_secret', config('services.ses.secret'))"
                            :placeholder="trans('core/setting::setting.email.ses_secret_placeholder')"
                        />
                    @endif

                    <x-core-setting::text-input
                        name="email_ses_region"
                        data-counter="120"
                        :label="trans('core/setting::setting.email.ses_region')"
                        :value="setting('email_ses_region', config('services.ses.region'))"
                        :placeholder="trans('core/setting::setting.email.ses_region_placeholder')"
                    />
                </div>

                <div
                    data-type="postmark"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'postmark',
                    ])
                >
                    @if (!BaseHelper::hasDemoModeEnabled())
                        <x-core-setting::text-input
                            name="email_postmark_token"
                            data-counter="120"
                            :label="trans('core/setting::setting.email.postmark_token')"
                            :value="setting('email_postmark_token', config('services.postmark.token'))"
                            :placeholder="trans('core/setting::setting.email.postmark_token_placeholder')"
                        />
                    @endif
                </div>

                <div
                    data-type="sendmail"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'sendmail',
                    ])
                >
                    <x-core-setting::text-input
                        name="email_sendmail_path"
                        data-counter="120"
                        :label="trans('core/setting::setting.email.sendmail_path')"
                        :value="setting('email_sendmail_path', config('mail.mailers.sendmail.path'))"
                        :placeholder="trans('core/setting::setting.email.sendmail_path')"
                        :helper-text="trans('core/setting::setting.email.default') .
                            ': <code>' .
                            config('mail.mailers.sendmail.path') .
                            '</code>'"
                    />
                </div>

                <div
                    data-type="log"
                    @class([
                        'setting-wrapper',
                        'hidden' => setting('email_driver', config('mail.default')) !== 'log',
                    ])
                >
                    <x-core-setting::select
                        name="email_log_channel"
                        :label="trans('core/setting::setting.email.log_channel')"
                        :options="array_combine(
                            array_keys(config('logging.channels', [])),
                            array_keys(config('logging.channels', [])),
                        )"
                        :value="setting('email_log_channel', config('mail.mailers.log.channel'))"
                    />
                </div>

                <x-core-setting::text-input
                    name="email_from_name"
                    data-counter="60"
                    :label="trans('core/setting::setting.email.sender_name')"
                    :value="setting('email_from_name', config('mail.from.name'))"
                    :placeholder="trans('core/setting::setting.email.sender_name_placeholder')"
                />

                <x-core-setting::text-input
                    name="email_from_address"
                    data-counter="60"
                    :label="trans('core/setting::setting.email.sender_email')"
                    :value="setting('email_from_address', config('mail.from.address'))"
                    placeholder="admin@example.com"
                />

                <button
                    class="btn btn-info send-test-email-trigger-button"
                    data-saving="{{ trans('core/setting::setting.saving') }}"
                    type="button"
                >
                    {{ trans('core/setting::setting.test_send_mail') }}
                </button>
            </x-core-setting::section>
        @endif

        {!! apply_filters(BASE_FILTER_AFTER_SETTING_EMAIL_CONTENT, null) !!}

        <div
            class="flexbox-annotated-section"
            style="border: none"
        >
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <button
                    class="btn btn-info"
                    type="submit"
                >{{ trans('core/setting::setting.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <x-core::modal
        id="send-test-email-modal"
        type="info"
        :title="trans('core/setting::setting.test_email_modal_title')"
        button-id="send-test-email-btn"
        :button-label="trans('core/setting::setting.send')"
    >
        <p>{{ trans('core/setting::setting.test_email_description') }}</p>
        <div class="form-group mb-3">
            <input
                class="form-control"
                name="email"
                type="email"
                placeholder="{{ trans('core/setting::setting.test_email_input_placeholder') }}"
            >
        </div>
    </x-core::modal>

    {!! $jsValidation !!}
@endsection
