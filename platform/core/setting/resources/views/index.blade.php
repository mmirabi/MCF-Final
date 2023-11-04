@php
    $defaultLocale = setting('locale', App::getLocale());
    if (BaseHelper::hasDemoModeEnabled() && session('site-locale') && array_key_exists(session('site-locale'), \Botble\Base\Supports\Language::getAvailableLocales())) {
        $defaultLocale = session('site-locale');
    }
    
    $locales = collect(\Botble\Base\Supports\Language::getAvailableLocales())
        ->pluck('name', 'locale')
        ->map(fn($item, $key) => $item . ' - ' . $key)
        ->all();
    
    $maxEmailCount = 4;
@endphp

@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div id="main-settings">
        <license-component
            verify-url="{{ route('settings.license.verify') }}"
            activate-license-url="{{ route('settings.license.activate') }}"
            deactivate-license-url="{{ route('settings.license.deactivate') }}"
            reset-license-url="{{ route('settings.license.reset') }}"
            manage-license="{{ auth()->user()->hasPermission('core.manage.license')? 'yes': 'no' }}"
        ></license-component>
    </div>

    <div class="max-width-1200">
        {!! Form::open(['route' => ['settings.edit']]) !!}
        <x-core-setting::section
            :title="trans('core/setting::setting.general.general_block')"
            :description="trans('core/setting::setting.general.description')"
        >
            <x-core-setting::form-group
                id="admin_email_wrapper"
                data-emails="{{ json_encode(get_admin_email()) }}"
                data-max="{{ $maxEmailCount }}"
            >
                <label
                    class="text-title-field"
                    for="admin_email"
                >{{ trans('core/setting::setting.general.admin_email') }}</label>
                <a
                    class="link"
                    id="add"
                    data-placeholder="email{{ '@' . request()->getHost() }}"
                ><small>+ {{ trans('core/setting::setting.email_add_more') }}</small></a>
                {{ Form::helper(trans('core/setting::setting.emails_warning', ['count' => $maxEmailCount])) }}
            </x-core-setting::form-group>

            <x-core-setting::select
                class="select-search-full"
                name="time_zone"
                :label="trans('core/setting::setting.general.time_zone')"
                :options="array_combine(DateTimeZone::listIdentifiers(), DateTimeZone::listIdentifiers())"
                :value="setting('time_zone', 'UTC')"
            />

            <x-core-setting::select
                class="select-search-full"
                name="locale"
                :label="trans('core/setting::setting.general.locale')"
                :options="$locales"
                :value="$defaultLocale"
            />

            <x-core-setting::radio
                name="locale_direction"
                :label="trans('core/setting::setting.general.locale_direction')"
                :value="setting('locale_direction', 'ltr')"
                :options="[
                    'ltr' => trans('core/setting::setting.locale_direction_ltr'),
                    'rtl' => trans('core/setting::setting.locale_direction_rtl'),
                ]"
            />

            <x-core-setting::form-group>
                <input
                    name="enable_send_error_reporting_via_email"
                    type="hidden"
                    value="0"
                >
                <label>
                    <input
                        name="enable_send_error_reporting_via_email"
                        type="checkbox"
                        value="1"
                        @checked(setting('enable_send_error_reporting_via_email'))
                    >
                    {{ trans('core/setting::setting.general.enable_send_error_reporting_via_email') }}
                </label>
            </x-core-setting::form-group>
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('core/setting::setting.general.admin_appearance_title')"
            :description="trans('core/setting::setting.general.admin_appearance_description')"
        >
            <x-core-setting::form-group>
                <label
                    class="text-title-field"
                    for="admin-logo"
                >{{ trans('core/setting::setting.general.admin_logo') }}</label>
                {!! Form::mediaImage('admin_logo', setting('admin_logo'), [
                    'allow_thumb' => false,
                    'default_image' => url(config('core.base.general.logo')),
                ]) !!}
            </x-core-setting::form-group>

            <x-core-setting::form-group>
                <label
                    class="text-title-field"
                    for="admin-favicon"
                >{{ trans('core/setting::setting.general.admin_favicon') }}</label>
                {!! Form::mediaImage('admin_favicon', setting('admin_favicon'), [
                    'allow_thumb' => false,
                    'default_image' => url(config('core.base.general.favicon')),
                ]) !!}
            </x-core-setting::form-group>

            <x-core-setting::form-group>
                <label
                    class="text-title-field"
                    for="admin-login-screen-backgrounds"
                >{{ trans('core/setting::setting.general.admin_login_screen_backgrounds') }}</label>
                {!! Form::mediaImages(
                    'login_screen_backgrounds[]',
                    is_array(setting('login_screen_backgrounds', ''))
                        ? setting('login_screen_backgrounds', '')
                        : json_decode(setting('login_screen_backgrounds', ''), true),
                ) !!}
            </x-core-setting::form-group>

            <x-core-setting::text-input
                name="admin_title"
                data-counter="120"
                :label="trans('core/setting::setting.general.admin_title')"
                :value="setting('admin_title', config('app.name'))"
            />

            <x-core-setting::radio
                name="admin_locale_direction"
                :label="trans('core/setting::setting.general.admin_locale_direction')"
                :value="setting('admin_locale_direction', 'ltr')"
                :options="[
                    'ltr' => trans('core/setting::setting.locale_direction_ltr'),
                    'rtl' => trans('core/setting::setting.locale_direction_rtl'),
                ]"
            />

            <x-core-setting::radio
                name="rich_editor"
                :label="trans('core/setting::setting.general.rich_editor')"
                :value="BaseHelper::getRichEditor()"
                :options="BaseHelper::availableRichEditors()"
            />

            <x-core-setting::select
                name="default_admin_theme"
                :label="trans('core/setting::setting.general.default_admin_theme')"
                :options="array_map(
                    fn($item) => Str::studly($item),
                    array_combine(array_keys(Assets::getThemes()), array_keys(Assets::getThemes())),
                )"
                :value="setting('default_admin_theme', config('core.base.general.default-theme'))"
            />

            @if (count(Assets::getThemes()) > 1)
                <x-core-setting::checkbox
                    name="enable_change_admin_theme"
                    :label="trans('core/setting::setting.general.enable_change_admin_theme')"
                    :checked="setting('enable_change_admin_theme')"
                />
            @endif
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('core/setting::setting.general.cache_block')"
            :description="trans('core/setting::setting.general.cache_description')"
        >
            <x-core-setting::on-off
                class="setting-selection-option"
                name="enable_cache"
                data-target="#cache-settings"
                :label="trans('core/setting::setting.general.enable_cache')"
                :value="setting('enable_cache', false)"
            />

            <div
                id="cache-settings"
                @class([
                    'mb-4 border rounded-top rounded-bottom p-3 bg-light',
                    'd-none' => !setting('enable_cache', false),
                ])
            >
                <x-core-setting::text-input
                    name="cache_time"
                    data-counter="120"
                    type="number"
                    :label="trans('core/setting::setting.general.cache_time')"
                    :value="setting('cache_time', 10)"
                />

                <x-core-setting::on-off
                    name="disable_cache_in_the_admin_panel"
                    :label="trans('core/setting::setting.general.disable_cache_in_the_admin_panel')"
                    :value="setting('disable_cache_in_the_admin_panel', true)"
                />
            </div>

            <x-core-setting::on-off
                name="cache_admin_menu_enable"
                :label="trans('core/setting::setting.general.cache_admin_menu')"
                :value="setting('cache_admin_menu_enable', false)"
            />
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('core/setting::setting.general.datatables.title')"
            :description="trans('core/setting::setting.general.datatables.description')"
        >
            <x-core-setting::on-off
                class="setting-selection-option"
                name="datatables_default_show_column_visibility"
                :label="trans('core/setting::setting.general.datatables.show_column_visibility')"
                :value="setting('datatables_default_show_column_visibility', false)"
            />

            <x-core-setting::on-off
                class="setting-selection-option"
                name="datatables_default_show_export_button"
                :label="trans('core/setting::setting.general.datatables.show_export_button')"
                :value="setting('datatables_default_show_export_button', false)"
            />
        </x-core-setting::section>

        {!! apply_filters(BASE_FILTER_AFTER_SETTING_CONTENT, null) !!}

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

    {!! $jsValidation !!}
@endsection
