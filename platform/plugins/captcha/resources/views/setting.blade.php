<x-core-setting::section
    :title="trans('plugins/captcha::captcha.settings.title')"
    :description="trans('plugins/captcha::captcha.settings.description')"
>
    <x-core-setting::on-off
        class="setting-selection-option"
        name="enable_captcha"
        data-target="#captcha-settings"
        :label="trans('plugins/captcha::captcha.settings.enable_captcha')"
        :value="Captcha::isEnabled()"
    />

    <div
        id="captcha-settings"
        @class([
            'mb-4 border rounded-top rounded-bottom p-3 bg-light',
            'd-none' => !Captcha::isEnabled(),
        ])
    >
        <x-core-setting::radio
            name="captcha_type"
            :label="trans('plugins/captcha::captcha.settings.type')"
            :options="[
                'v2' => trans('plugins/captcha::captcha.settings.v2_description'),
                'v3' => trans('plugins/captcha::captcha.settings.v3_description'),
            ]"
            :value="Captcha::captchaType()"
        />

        <x-core-setting::on-off
            name="captcha_hide_badge"
            :label="trans('plugins/captcha::captcha.settings.hide_badge')"
            :value="setting('captcha_hide_badge')"
        />

        <x-core-setting::text-input
            name="captcha_site_key"
            data-counter="120"
            :label="trans('plugins/captcha::captcha.settings.captcha_site_key')"
            :value="setting('captcha_site_key')"
            :placeholder="trans('plugins/captcha::captcha.settings.captcha_site_key')"
        />

        <x-core-setting::text-input
            name="captcha_secret"
            data-counter="120"
            :label="trans('plugins/captcha::captcha.settings.captcha_secret')"
            :value="setting('captcha_secret')"
            :placeholder="trans('plugins/captcha::captcha.settings.captcha_secret')"
        />

        <x-core-setting::form-group>
            {{ Form::helper(trans('plugins/captcha::captcha.settings.helper')) }}
        </x-core-setting::form-group>
    </div>
</x-core-setting::section>
