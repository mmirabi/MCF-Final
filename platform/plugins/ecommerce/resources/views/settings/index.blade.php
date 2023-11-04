@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['url' => route('ecommerce.settings'), 'class' => 'main-setting-form']) !!}
        <x-core-setting::section
            :title="trans('plugins/ecommerce::ecommerce.setting.title')"
            :description="trans('plugins/ecommerce::store-locator.description')"
        >
            <x-core-setting::text-input
                name="store_name"
                :label="trans('plugins/ecommerce::store-locator.shop_name')"
                :value="get_ecommerce_setting('store_name')"
            />

            <x-core-setting::text-input
                name="store_company"
                :label="trans('plugins/ecommerce::store-locator.company')"
                :value="get_ecommerce_setting('store_company')"
            />

            <x-core-setting::text-input
                name="store_phone"
                :label="trans('plugins/ecommerce::store-locator.phone')"
                :value="get_ecommerce_setting('store_phone')"
            />

            <x-core-setting::text-input
                name="store_email"
                :label="trans('plugins/ecommerce::store-locator.email')"
                :value="get_ecommerce_setting('store_email')"
            />

            <x-core-setting::text-input
                name="store_address"
                :label="trans('plugins/ecommerce::store-locator.address')"
                :value="get_ecommerce_setting('store_address')"
            />

            <div class="form-group mb-3 row">
                <div class="col-md-4">
                    <x-core-setting::select
                        name="store_country"
                        data-type="country"
                        :label="trans('plugins/ecommerce::ecommerce.setting.country')"
                        :options="EcommerceHelper::getAvailableCountries()"
                        :value="get_ecommerce_setting('store_country')"
                    />
                </div>

                <div class="col-sm-4">
                    @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                        <x-core-setting::select
                            name="store_state"
                            data-type="state"
                            :label="trans('plugins/ecommerce::ecommerce.setting.state')"
                            :options="get_ecommerce_setting('store_country') ||
                            !EcommerceHelper::isUsingInMultipleCountries()
                                ? EcommerceHelper::getAvailableStatesByCountry(get_ecommerce_setting('store_country'))
                                : []"
                            :value="get_ecommerce_setting('store_state')"
                            :data-url="route('ajax.states-by-country')"
                        />
                    @else
                        <x-core-setting::text-input
                            name="store_state"
                            :label="trans('plugins/ecommerce::ecommerce.setting.state')"
                            :value="get_ecommerce_setting('store_state')"
                        />
                    @endif
                </div>

                <div class="col-sm-4">
                    @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                        <x-core-setting::select
                            name="store_city"
                            data-type="city"
                            data-using-select2="false"
                            :label="trans('plugins/ecommerce::ecommerce.setting.city')"
                            :options="get_ecommerce_setting('store_city')
                                ? EcommerceHelper::getAvailableCitiesByState(get_ecommerce_setting('store_state'))
                                : []"
                            :value="get_ecommerce_setting('store_city')"
                            :data-url="route('ajax.cities-by-state')"
                        />
                    @else
                        <x-core-setting::text-input
                            name="store_city"
                            :label="trans('plugins/ecommerce::ecommerce.setting.city')"
                            :value="get_ecommerce_setting('store_city')"
                        />
                    @endif
                </div>
            </div>
            @if (EcommerceHelper::isZipCodeEnabled())
                <x-core-setting::text-input
                    name="store_zip_code"
                    :label="trans('plugins/ecommerce::store-locator.zip_code')"
                    :value="get_ecommerce_setting('store_zip_code')"
                />
            @endif
            <x-core-setting::text-input
                name="store_vat_number"
                :label="trans('plugins/ecommerce::ecommerce.setting.tax_id')"
                :value="get_ecommerce_setting('store_vat_number')"
            />
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('plugins/ecommerce::ecommerce.standard_and_format')"
            :description="trans('plugins/ecommerce::ecommerce.standard_and_format_description')"
        >
            <label class="next-label">{{ trans('plugins/ecommerce::ecommerce.change_order_format') }}</label>
            <p class="type-subdued">
                {{ trans('plugins/ecommerce::ecommerce.change_order_format_description', ['number' => config('plugins.ecommerce.order.default_order_start_number')]) }}
            </p>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <x-core-setting::form-group>
                        <label
                            class="text-title-field"
                            for="store_order_prefix"
                        >{{ trans('plugins/ecommerce::ecommerce.start_with') }}</label>
                        <div class="next-input--stylized">
                            <span class="next-input-add-on next-input__add-on--before">#</span>
                            <input
                                class="next-input next-input--invisible"
                                id="store_order_prefix"
                                name="store_order_prefix"
                                type="text"
                                value="{{ get_ecommerce_setting('store_order_prefix') }}"
                            >
                        </div>
                    </x-core-setting::form-group>
                    <p class="setting-note mb0">{{ trans('plugins/ecommerce::ecommerce.order_will_be_shown') }} <span
                            class="sample-order-code"
                        >#<span
                                class="sample-order-code-prefix">{{ get_ecommerce_setting('store_order_prefix') ? get_ecommerce_setting('store_order_prefix') . '-' : '' }}</span>{{ config('plugins.ecommerce.order.default_order_start_number') }}<span
                                class="sample-order-code-suffix"
                            >{{ get_ecommerce_setting('store_order_suffix') ? '-' . get_ecommerce_setting('store_order_suffix') : '' }}</span></span>
                    </p>
                </div>
                <div class="col-sm-6 mb-3">
                    <x-core-setting::text-input
                        name="store_order_suffix"
                        :label="trans('plugins/ecommerce::ecommerce.end_with')"
                        :value="get_ecommerce_setting('store_order_suffix')"
                    />
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <x-core-setting::select
                        name="store_weight_unit"
                        :label="trans('plugins/ecommerce::ecommerce.weight_unit')"
                        :options="[
                            'g' => trans('plugins/ecommerce::ecommerce.setting.weight_unit_gram'),
                            'kg' => trans('plugins/ecommerce::ecommerce.setting.weight_unit_kilogram'),
                            'lb' => trans('plugins/ecommerce::ecommerce.setting.weight_unit_lb'),
                            'oz' => trans('plugins/ecommerce::ecommerce.setting.weight_unit_oz'),
                        ]"
                        :value="get_ecommerce_setting('store_weight_unit', 'g')"
                    />
                </div>
                <div class="col-sm-6">
                    <x-core-setting::select
                        name="store_width_height_unit"
                        :label="trans('plugins/ecommerce::ecommerce.height_unit')"
                        :options="[
                            'cm' => trans('plugins/ecommerce::ecommerce.setting.height_unit_cm'),
                            'm' => trans('plugins/ecommerce::ecommerce.setting.height_unit_m'),
                            'inch' => trans('plugins/ecommerce::ecommerce.setting.height_unit_inch'),
                        ]"
                        :value="get_ecommerce_setting('store_width_height_unit', 'cm')"
                    />
                </div>
            </div>
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('plugins/ecommerce::currency.currencies')"
            :description="trans('plugins/ecommerce::currency.setting_description')"
        >
            <x-core-setting::on-off
                name="enable_auto_detect_visitor_currency"
                :label="trans('plugins/ecommerce::currency.enable_auto_detect_visitor_currency')"
                :helper-text="trans('plugins/ecommerce::currency.auto_detect_visitor_currency_description')"
                :value="get_ecommerce_setting('enable_auto_detect_visitor_currency', false)"
            />

            <x-core-setting::on-off
                name="add_space_between_price_and_currency"
                :label="trans('plugins/ecommerce::currency.add_space_between_price_and_currency')"
                :value="get_ecommerce_setting('add_space_between_price_and_currency', false)"
            />
            <div class="row">
                <div class="col-sm-6">
                    <x-core-setting::select
                        name="thousands_separator"
                        :label="trans('plugins/ecommerce::ecommerce.setting.thousands_separator')"
                        :options="[
                            ',' => trans('plugins/ecommerce::ecommerce.setting.separator_comma'),
                            '.' => trans('plugins/ecommerce::ecommerce.setting.separator_period'),
                            'space' => trans('plugins/ecommerce::ecommerce.setting.separator_space'),
                        ]"
                        :value="get_ecommerce_setting('thousands_separator', ',')"
                    />
                </div>

                <div class="col-sm-6">
                    <x-core-setting::select
                        name="decimal_separator"
                        :label="trans('plugins/ecommerce::ecommerce.setting.decimal_separator')"
                        :options="[
                            ',' => trans('plugins/ecommerce::ecommerce.setting.separator_comma'),
                            '.' => trans('plugins/ecommerce::ecommerce.setting.separator_period'),
                            'space' => trans('plugins/ecommerce::ecommerce.setting.separator_space'),
                        ]"
                        :value="get_ecommerce_setting('decimal_separator', '.')"
                    />
                </div>
            </div>

            <div class="row">
                <x-core-setting::select
                    class="switch_api_provider"
                    name="exchange_rate_api_provider"
                    :label="trans('plugins/ecommerce::ecommerce.setting.exchange_rate.choose_api_provider')"
                    :options="[
                        '' => trans('plugins/ecommerce::ecommerce.setting.exchange_rate.select'),
                        'api_layer' => trans('plugins/ecommerce::ecommerce.setting.exchange_rate.provider.api_layer'),
                        'open_exchange_rate' => trans(
                            'plugins/ecommerce::ecommerce.setting.exchange_rate.provider.open_exchange_rate',
                        ),
                    ]"
                    :value="get_ecommerce_setting('exchange_rate_api_provider', '.')"
                />
            </div>

            <div class="row">
                <div
                    class="col-md-6 api-layer-api-key"
                    @if (get_ecommerce_setting('exchange_rate_api_provider') !== 'api_layer') style="display: none" @endif
                >
                    <x-core-setting::text-input
                        name="api_layer_api_key"
                        :label="trans('plugins/ecommerce::currency.api_key')"
                        :value="get_ecommerce_setting('api_layer_api_key')"
                        placeholder="********"
                        :helperText="trans('plugins/ecommerce::currency.api_key_helper', [
                            'link' => Html::link(
                                'https://apilayer.com/marketplace/exchangerates_data-api',
                                attributes: ['target' => '_blank'],
                            ),
                        ])"
                    />
                </div>

                <div
                    class="col-md-6 open-exchange-api-key"
                    @if (get_ecommerce_setting('exchange_rate_api_provider') !== 'open_exchange_rate') style="display: none" @endif
                >
                    <x-core-setting::text-input
                        name="open_exchange_app_id"
                        :label="trans('plugins/ecommerce::ecommerce.setting.exchange_rate.open_exchange_app_id')"
                        :value="get_ecommerce_setting('open_exchange_app_id')"
                        placeholder="********"
                        :helperText="trans('plugins/ecommerce::currency.api_key_helper', [
                            'link' => Html::link('https://openexchangerates.org/', attributes: ['target' => '_blank']),
                        ])"
                    />
                </div>

                @if (
                    (get_ecommerce_setting('exchange_rate_api_provider') === 'api_layer' &&
                        get_ecommerce_setting('api_layer_api_key')) ||
                        (get_ecommerce_setting('exchange_rate_api_provider') === 'open_exchange_rate' &&
                            get_ecommerce_setting('open_exchange_app_id')))
                    <div class="col-sm-6">
                        <button
                            class="btn btn-primary"
                            id="btn-update-currencies"
                            data-url="{{ route('ecommerce.setting.update-currencies-from-exchange-api') }}"
                        >
                            <i class="fa fa-download"></i>
                            {{ trans('plugins/ecommerce::currency.update_currency_rates') }}
                        </button>

                        <button
                            class="btn btn-warning ms-2"
                            id="btn-clear-cache-rates"
                            data-url="{{ route('ecommerce.setting.clear-cache-currency-rates') }}"
                        >
                            <i class="fa fa-refresh"></i>
                            {{ trans('plugins/ecommerce::currency.clear_cache_rates') }}
                        </button>
                    </div>
                @endif
            </div>

            <div class="row">
                <x-core-setting::on-off
                    name="use_exchange_rate_from_api"
                    :label="trans('plugins/ecommerce::currency.use_exchange_rate_from_api')"
                    :value="get_ecommerce_setting('use_exchange_rate_from_api', false)"
                />
            </div>

            <textarea
                class="hidden"
                id="currencies"
                name="currencies"
            >{!! json_encode($currencies) !!}</textarea>
            <textarea
                class="hidden"
                id="deleted_currencies"
                name="deleted_currencies"
            ></textarea>
            <div class="swatches-container">
                <div class="header clearfix">
                    <div class="swatch-item">
                        {{ trans('plugins/ecommerce::currency.code') }}
                    </div>
                    <div class="swatch-item">
                        {{ trans('plugins/ecommerce::currency.symbol') }}
                    </div>
                    <div class="swatch-item swatch-decimals">
                        {{ trans('plugins/ecommerce::currency.number_of_decimals') }}
                    </div>
                    <div class="swatch-item swatch-exchange-rate">
                        {{ trans('plugins/ecommerce::currency.exchange_rate') }}
                    </div>
                    <div class="swatch-item swatch-is-prefix-symbol">
                        {{ trans('plugins/ecommerce::currency.is_prefix_symbol') }}
                    </div>
                    <div class="swatch-is-default">
                        {{ trans('plugins/ecommerce::currency.is_default') }}
                    </div>
                    <div class="remove-item">{{ trans('plugins/ecommerce::currency.remove') }}</div>
                </div>
                <ul class="swatches-list">
                    <div
                        id="loading-update-currencies"
                        style="display: none;"
                    >
                        <div class="currency-loading-backdrop"></div>
                        <div class="currency-loading-loader"></div>
                    </div>
                </ul>
                <div class="clearfix"></div>
                {!! Form::helper(trans('plugins/ecommerce::currency.instruction')) !!}
                <a
                    class="js-add-new-attribute"
                    href="#"
                >
                    {{ trans('plugins/ecommerce::currency.new_currency') }}
                </a>
            </div>
        </x-core-setting::section>

        <x-core-setting::section
            :title="trans('plugins/ecommerce::ecommerce.setting.store_locator_title')"
            :description="trans('plugins/ecommerce::ecommerce.setting.store_locator_description')"
        >
            <table class="table table-striped table-bordered table-header-color store-locator-table">
                <thead>
                    <tr>
                        <th>{{ trans('core/base::tables.name') }}</th>
                        <th>{{ trans('core/base::tables.email') }}</th>
                        <th>{{ trans('plugins/ecommerce::ecommerce.setting.phone') }}</th>
                        <th>{{ trans('plugins/ecommerce::ecommerce.setting.address') }}</th>
                        <th>{{ trans('plugins/ecommerce::ecommerce.setting.is_primary') }}</th>
                        <th
                            class="text-end"
                            style="width: 120px;"
                        >&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($storeLocators as $storeLocator)
                        <tr>
                            <td>
                                {{ $storeLocator->name }}
                            </td>
                            <td>
                                <a href="mailto:{{ $storeLocator->email }}">{{ $storeLocator->email }}</a>
                            </td>
                            <td>
                                {{ $storeLocator->phone }}
                            </td>
                            <td>
                                <span>{{ $storeLocator->address }}</span>,
                                <span>{{ $storeLocator->city_name }}</span>,
                                <span>{{ $storeLocator->state_name }}</span>,
                                <span>{{ $storeLocator->country_name }}</span>
                            </td>
                            <td>
                                {{ $storeLocator->is_primary ? trans('core/base::base.yes') : trans('core/base::base.no') }}
                            </td>
                            <td class="text-end">
                                @if (!$storeLocator->is_primary && $storeLocators->count() > 1)
                                    <button
                                        class="btn btn-danger btn-small btn-trigger-delete-store-locator"
                                        data-target="{{ route('ecommerce.store-locators.destroy', $storeLocator->id) }}"
                                        type="button"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                @endif
                                <button
                                    class="btn btn-primary btn-small btn-trigger-show-store-locator"
                                    data-type="update"
                                    data-load-form="{{ route('ecommerce.store-locators.form', $storeLocator->id) }}"
                                    type="button"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a
                class="btn btn-primary btn-trigger-show-store-locator"
                data-type="create"
                data-load-form="{{ route('ecommerce.store-locators.form') }}"
                href="#"
            >
                {{ trans('plugins/ecommerce::ecommerce.setting.add_new') }}
            </a>
            @if (count($storeLocators) > 0)
                <p style="margin-top: 10px">{{ trans('plugins/ecommerce::ecommerce.setting.or') }} <a
                        data-bs-toggle="modal"
                        data-bs-target="#change-primary-store-locator-modal"
                        href="#"
                    >{{ trans('plugins/ecommerce::ecommerce.setting.change_primary_store') }}</a></p>
            @endif
        </x-core-setting::section>

        <div
            class="flexbox-annotated-section"
            style="border: none"
        >
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <button
                    class="btn btn-info"
                    type="submit"
                >{{ trans('plugins/ecommerce::currency.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('footer')
    <x-core-base::modal
        id="add-store-locator-modal"
        :title="trans('plugins/ecommerce::ecommerce.setting.add_location')"
        button-id="add-store-locator-button"
        :button-label="trans('plugins/ecommerce::ecommerce.setting.save_location')"
        size="md"
    >
        @include('plugins/ecommerce::settings.store-locator-item', ['locator' => null])
    </x-core-base::modal>

    <x-core-base::modal
        id="update-store-locator-modal"
        :title="trans('plugins/ecommerce::ecommerce.setting.edit_location')"
        button-id="update-store-locator-button"
        :button-label="trans('plugins/ecommerce::ecommerce.setting.save_location')"
        size="md"
    >
        @include('plugins/ecommerce::settings.store-locator-item', ['locator' => null])
    </x-core-base::modal>

    <x-core-base::modal
        id="delete-store-locator-modal"
        :title="trans('plugins/ecommerce::ecommerce.setting.delete_location')"
        button-id="delete-store-locator-button"
        :button-label="trans('plugins/ecommerce::ecommerce.setting.accept')"
        size="md"
    >
        {!! trans('plugins/ecommerce::ecommerce.setting.delete_location_confirmation') !!}
    </x-core-base::modal>

    <x-core-base::modal
        id="change-primary-store-locator-modal"
        :title="trans('plugins/ecommerce::ecommerce.setting.change_primary_location')"
        button-id="change-primary-store-locator-button"
        :button-label="trans('plugins/ecommerce::ecommerce.setting.accept')"
        size="sm"
    >
        @include('plugins/ecommerce::settings.store-locator-change-primary', compact('storeLocators'))
    </x-core-base::modal>

    <script id="currency_template" type="text/x-custom-template">
        <div id="loading-update-currencies" style="display: none;">
            <div class="currency-loading-backdrop"></div>
            <div class="currency-loading-loader"></div>
        </div>
        <li data-id="__id__" class="clearfix">
            <div class="swatch-item" data-type="title">
                <input type="text" class="form-control" value="__title__">
            </div>
            <div class="swatch-item" data-type="symbol">
                <input type="text" class="form-control" value="__symbol__">
            </div>
            <div class="swatch-item swatch-decimals" data-type="decimals">
                <input type="number" class="form-control" value="__decimals__">
            </div>
            <div class="swatch-item swatch-exchange-rate" data-type="exchange_rate">
                <input type="number" @disabled(get_ecommerce_setting('use_exchange_rate_from_api')) class="form-control input-exchange-rate" value="__exchangeRate__" step="0.00000001">
            </div>
            <div class="swatch-item swatch-is-prefix-symbol" data-type="is_prefix_symbol">
                <div class="ui-select-wrapper">
                    <select class="ui-select">
                        <option value="1" __isPrefixSymbolChecked__>{{ trans('plugins/ecommerce::currency.before_number') }}</option>
                        <option value="0" __notIsPrefixSymbolChecked__>{{ trans('plugins/ecommerce::currency.after_number') }}</option>
                    </select>
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path></svg>
                    </svg>
                </div>
            </div>
            <div class="swatch-is-default" data-type="is_default">
                <input type="radio" name="currencies_is_default" value="__position__" __isDefaultChecked__>
            </div>
            <div class="remove-item"><a href="#" class="font-red"><i class="fa fa-trash"></i></a></div>
        </li>
    </script>

    {!! $jsValidation !!}
@endpush
