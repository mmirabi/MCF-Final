@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <div class="tabbable-custom tabbable-tabdrop">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a
                    class="nav-link active"
                    data-bs-toggle="tab"
                    href="#tab_detail"
                >{{ trans('core/base::tabs.detail') }}</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-bs-toggle="tab"
                    href="#tab_settings"
                >{{ trans('plugins/language::language.settings') }}</a>
            </li>
            {!! apply_filters(BASE_FILTER_REGISTER_CONTENT_TABS, null, new \Botble\Language\Models\Language()) !!}
        </ul>
        <div class="tab-content">
            <div
                class="tab-pane active"
                id="tab_detail"
            >
                <div class="row">
                    <div class="col-md-5">
                        @php do_action(BASE_ACTION_META_BOXES, 'top', new \Botble\Language\Models\Language) @endphp
                        <div class="main-form">
                            <div class="form-wrap">
                                <div class="form-group mb-3">
                                    <input
                                        id="language_flag_path"
                                        type="hidden"
                                        value="{{ BASE_LANGUAGE_FLAG_PATH }}"
                                    >
                                    <label
                                        class="control-label"
                                        for="language_id"
                                    >{{ trans('plugins/language::language.choose_language') }}</label>
                                    <select
                                        class="form-select select-search-full"
                                        id="language_id"
                                    >
                                        <option>{{ trans('plugins/language::language.select_language') }}</option>
                                        @foreach ($languages as $key => $language)
                                            <option
                                                data-language="{{ json_encode($language) }}"
                                                value="{{ $key }}"
                                            > {{ $language[2] }} - {{ $language[1] }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::helper(trans('plugins/language::language.choose_language_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label required"
                                        for="lang_name"
                                    >{{ trans('plugins/language::language.language_name') }}</label>
                                    <input
                                        class="form-control"
                                        id="lang_name"
                                        type="text"
                                    >
                                    {!! Form::helper(trans('plugins/language::language.language_name_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label required"
                                        for="lang_locale"
                                    >{{ trans('plugins/language::language.locale') }}</label>
                                    <input
                                        class="form-control"
                                        id="lang_locale"
                                        type="text"
                                    >
                                    {!! Form::helper(trans('plugins/language::language.locale_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label"
                                        for="lang_code"
                                    >{{ trans('plugins/language::language.language_code') }}</label>
                                    <input
                                        class="form-control"
                                        id="lang_code"
                                        type="text"
                                    >
                                    {!! Form::helper(trans('plugins/language::language.language_code_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label"
                                        for="lang_text_direction"
                                    >{{ trans('plugins/language::language.text_direction') }}</label>
                                    <p>
                                        <label class="me-2">
                                            <input
                                                class="lang_is_ltr"
                                                name="lang_rtl"
                                                type="radio"
                                                value="0"
                                                checked="checked"
                                            > {{ trans('plugins/language::language.left_to_right') }}
                                        </label>
                                        <label>
                                            <input
                                                class="lang_is_rtl"
                                                name="lang_rtl"
                                                type="radio"
                                                value="1"
                                            > {{ trans('plugins/language::language.right_to_left') }}
                                        </label>
                                    </p>
                                    {!! Form::helper(trans('plugins/language::language.text_direction_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label"
                                        for="flag_list"
                                    >{{ trans('plugins/language::language.flag') }}</label>
                                    <select
                                        class="form-control select-search-language"
                                        id="flag_list"
                                    >
                                        <option>{{ trans('plugins/language::language.select_flag') }}</option>
                                        @foreach ($flags as $key => $flag)
                                            <option value="{{ $key }}">{{ $flag }}</option>
                                        @endforeach
                                    </select>
                                    {!! Form::helper(trans('plugins/language::language.flag_helper')) !!}
                                </div>

                                <div class="form-group mb-3">
                                    <label
                                        class="control-label"
                                        for="lang_order"
                                    >{{ trans('plugins/language::language.order') }}</label>
                                    <input
                                        class="form-control"
                                        id="lang_order"
                                        type="number"
                                        value="0"
                                    >
                                    {!! Form::helper(trans('plugins/language::language.order_helper')) !!}
                                </div>
                                <input
                                    id="lang_id"
                                    type="hidden"
                                    value="0"
                                >
                                <p class="submit">
                                    <button
                                        class="btn btn-primary"
                                        id="btn-language-submit"
                                    >{{ trans('plugins/language::language.add_new_language') }}</button>
                                </p>
                            </div>
                        </div>
                        @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Botble\Language\Models\Language) @endphp
                    </div>
                    <div class="col-md-7">
                        <div class="table-responsive">
                            <table class="table table-hover table-language">
                                <thead>
                                    <tr>
                                        <th class="text-start">
                                            <span>{{ trans('plugins/language::language.language_name') }}</span>
                                        </th>
                                        <th class="text-center">
                                            <span>{{ trans('plugins/language::language.locale') }}</span>
                                        </th>
                                        <th class="text-center"><span>{{ trans('plugins/language::language.code') }}</span>
                                        </th>
                                        <th class="text-center">
                                            <span>{{ trans('plugins/language::language.default_language') }}</span>
                                        </th>
                                        <th class="text-center">
                                            <span>{{ trans('plugins/language::language.order') }}</span>
                                        </th>
                                        <th class="text-center"><span>{{ trans('plugins/language::language.flag') }}</span>
                                        </th>
                                        <th class="text-center">
                                            <span>{{ trans('plugins/language::language.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activeLanguages as $item)
                                        @include(
                                            'plugins/language::partials.language-item',
                                            compact('item'))
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane"
                id="tab_settings"
            >
                {!! Form::open(['route' => 'languages.settings']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <br>
                        <div class="form-group mb-3 @if ($errors->has('language_hide_default')) has-error @endif">
                            <label
                                class="text-title-field"
                                for="language_hide_default"
                            >{{ trans('plugins/language::language.language_hide_default') }}
                            </label>
                            <label class="me-2">
                                <input
                                    name="language_hide_default"
                                    type="radio"
                                    value="1"
                                    @if (setting('language_hide_default', true)) checked @endif
                                >{{ trans('core/setting::setting.general.yes') }}
                            </label>
                            <label>
                                <input
                                    name="language_hide_default"
                                    type="radio"
                                    value="0"
                                    @if (!setting('language_hide_default', true)) checked @endif
                                >{{ trans('core/setting::setting.general.no') }}
                            </label>
                        </div>
                        <div class="form-group mb-3 @if ($errors->has('language_display')) has-error @endif">
                            <label
                                for="language_display">{{ trans('plugins/language::language.language_display') }}</label>
                            {!! Form::customSelect(
                                'language_display',
                                [
                                    'all' => trans('plugins/language::language.language_display_all'),
                                    'flag' => trans('plugins/language::language.language_display_flag_only'),
                                    'name' => trans('plugins/language::language.language_display_name_only'),
                                ],
                                setting('language_display', 'all'),
                            ) !!}
                        </div>

                        <div class="form-group mb-3 @if ($errors->has('language_switcher_display')) has-error @endif">
                            <label
                                for="language_switcher_display">{{ trans('plugins/language::language.switcher_display') }}</label>
                            {!! Form::customSelect(
                                'language_switcher_display',
                                [
                                    'dropdown' => trans('plugins/language::language.language_switcher_display_dropdown'),
                                    'list' => trans('plugins/language::language.language_switcher_display_list'),
                                ],
                                setting('language_switcher_display', 'dropdown'),
                            ) !!}
                        </div>

                        <div class="form-group mb-3 @if ($errors->has('language_hide_languages')) has-error @endif">
                            <label
                                for="language_hide_languages">{{ trans('plugins/language::language.hide_languages') }}</label>
                            <p><span
                                    style="font-size: 90%;">{{ trans('plugins/language::language.hide_languages_description') }}</span>
                            </p>
                            <ul class="list-item-checkbox">
                                @foreach (Language::getActiveLanguage() as $language)
                                    @if (!$language->lang_is_default)
                                        <li style="padding-left: 10px;">
                                            <input
                                                id="language_hide_languages_item-{{ $language->lang_code }}"
                                                name="language_hide_languages[]"
                                                type="checkbox"
                                                value="{{ $language->lang_id }}"
                                                @if (in_array($language->lang_id, json_decode(setting('language_hide_languages', '[]'), true))) checked="checked" @endif
                                            >
                                            <label
                                                for="language_hide_languages_item-{{ $language->lang_code }}">{{ $language->lang_name }}</label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            {!! Form::helper(
                                trans_choice(
                                    'plugins/language::language.hide_languages_helper_display_hidden',
                                    count(json_decode(setting('language_hide_languages', '[]'), true)),
                                    ['language' => Language::getHiddenLanguageText()],
                                ),
                            ) !!}
                        </div>

                        <div class="form-group mb-3">
                            <label
                                class="text-title-field"
                                for="language_show_default_item_if_current_version_not_existed"
                            >{{ trans('plugins/language::language.language_show_default_item_if_current_version_not_existed') }}
                            </label>
                            <label class="me-2">
                                <input
                                    name="language_show_default_item_if_current_version_not_existed"
                                    type="radio"
                                    value="1"
                                    @if (setting('language_show_default_item_if_current_version_not_existed', true)) checked @endif
                                >{{ trans('core/setting::setting.general.yes') }}
                            </label>
                            <label>
                                <input
                                    name="language_show_default_item_if_current_version_not_existed"
                                    type="radio"
                                    value="0"
                                    @if (!setting('language_show_default_item_if_current_version_not_existed', true)) checked @endif
                                >{{ trans('core/setting::setting.general.no') }}
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <label
                                class="text-title-field"
                                for="language_auto_detect_user_language"
                            >{{ trans('plugins/language::language.language_auto_detect_user_language') }}
                            </label>
                            <label class="me-2">
                                <input
                                    name="language_auto_detect_user_language"
                                    type="radio"
                                    value="1"
                                    @if (setting('language_auto_detect_user_language', false)) checked @endif
                                >{{ trans('core/setting::setting.general.yes') }}
                            </label>
                            <label>
                                <input
                                    name="language_auto_detect_user_language"
                                    type="radio"
                                    value="0"
                                    @if (!setting('language_auto_detect_user_language', false)) checked @endif
                                >{{ trans('core/setting::setting.general.no') }}
                            </label>
                        </div>

                        <div class="text-start">
                            <button
                                class="btn btn-info button-save-language-settings"
                                name="submit"
                                type="submit"
                                value="save"
                            >
                                <i class="fa fa-save"></i> {{ trans('core/base::forms.save') }}
                            </button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('core/table::partials.modal-item', [
        'type' => 'danger',
        'name' => 'modal-confirm-delete',
        'title' => trans('core/base::tables.confirm_delete'),
        'content' => trans('plugins/language::language.delete_confirmation_message'),
        'action_name' => trans('core/base::tables.delete'),
        'action_button_attributes' => [
            'class' => 'delete-crud-entry',
        ],
    ])
@stop
