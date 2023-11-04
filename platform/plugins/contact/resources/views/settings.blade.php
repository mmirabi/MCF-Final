<x-core-setting::section
    :title="trans('plugins/contact::contact.settings.title')"
    :description="trans('plugins/contact::contact.settings.description')"
>
    <x-core-setting::form-group>
        <label
            class="text-title-field"
            for="blacklist_keywords"
        >{{ trans('plugins/contact::contact.settings.blacklist_keywords') }}</label>
        <textarea
            class="next-input tags"
            id="blacklist_keywords"
            name="blacklist_keywords"
            data-counter="250"
            rows="3"
            placeholder="{{ trans('plugins/contact::contact.settings.blacklist_keywords_placeholder') }}"
        >{{ setting('blacklist_keywords') }}</textarea>
        {{ Form::helper(trans('plugins/contact::contact.settings.blacklist_keywords_helper')) }}
    </x-core-setting::form-group>

    <x-core-setting::form-group>
        <label
            class="text-title-field"
            for="blacklist_email_domains"
        >{{ trans('plugins/contact::contact.settings.blacklist_email_domains') }}</label>
        <textarea
            class="next-input tags"
            id="blacklist_email_domains"
            name="blacklist_email_domains"
            data-counter="250"
            rows="3"
            placeholder="{{ trans('plugins/contact::contact.settings.blacklist_email_domains_placeholder') }}"
        >{{ setting('blacklist_email_domains') }}</textarea>
        {{ Form::helper(trans('plugins/contact::contact.settings.blacklist_email_domains_helper')) }}
    </x-core-setting::form-group>

    <x-core-setting::checkbox
        name="enable_math_captcha_for_contact_form"
        :label="trans('plugins/contact::contact.settings.enable_math_captcha')"
        :checked="setting('enable_math_captcha_for_contact_form', false)"
    />
</x-core-setting::section>
