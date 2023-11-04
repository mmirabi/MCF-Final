{!! Form::open(['url' => $url]) !!}
<input
    name="order_id"
    type="hidden"
    value="{{ $orderId }}"
>
<div class="next-form-section">
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.form_name') }}</label>
            <input
                class="next-input"
                name="name"
                type="text"
                value="{{ $address->name }}"
                placeholder="{{ trans('plugins/ecommerce::shipping.form_name') }}"
            >
        </div>
        <div class="next-form-grid-cell">
            <label class="text-title-field">{{ trans('plugins/ecommerce::shipping.phone') }}</label>
            <input
                class="next-input"
                name="phone"
                type="text"
                value="{{ $address->phone }}"
                placeholder="{{ trans('plugins/ecommerce::shipping.phone') }}"
            >
        </div>
    </div>
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field">{{ trans('plugins/ecommerce::shipping.email') }}</label>
            <input
                class="next-input"
                name="email"
                type="text"
                value="{{ $address->email }}"
                placeholder="{{ trans('plugins/ecommerce::shipping.email') }}"
            >
        </div>
    </div>

    @if (EcommerceHelper::isUsingInMultipleCountries())
        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.country') }}</label>
                <div class="ui-select-wrapper">
                    <select
                        class="ui-select form-control"
                        name="country"
                        data-type="country"
                    >
                        @foreach (EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                            <option
                                value="{{ $countryCode }}"
                                @if ($address->country == $countryCode) selected @endif
                            >{{ $countryName }}</option>
                        @endforeach
                    </select>
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                        </svg>
                    </svg>
                </div>
            </div>
        </div>
    @else
        <input
            name="country"
            type="hidden"
            value="{{ EcommerceHelper::getFirstCountryId() }}"
        >
    @endif

    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.state') }}</label>
            @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                <div class="ui-select-wrapper">
                    <select
                        class="ui-select form-control"
                        name="state"
                        data-type="state"
                        data-url="{{ route('ajax.states-by-country') }}"
                    >
                        <option value="">{{ __('Select state...') }}</option>
                        @if ($address->state || !EcommerceHelper::isUsingInMultipleCountries())
                            @foreach (EcommerceHelper::getAvailableStatesByCountry($address->country) as $stateId => $stateName)
                                <option
                                    value="{{ $stateId }}"
                                    @if ($address->state == $stateId) selected @endif
                                >{{ $stateName }}</option>
                            @endforeach
                        @endif
                    </select>
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                        </svg>
                    </svg>
                </div>
            @else
                <input
                    class="next-input"
                    name="state"
                    type="text"
                    value="{{ $address->state }}"
                    placeholder="{{ trans('plugins/ecommerce::shipping.state') }}"
                >
            @endif
        </div>
    </div>

    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.city') }}</label>
            @if (EcommerceHelper::useCityFieldAsTextField())
                <input
                    class="next-input"
                    name="city"
                    type="text"
                    value="{{ $address->city }}"
                    placeholder="{{ trans('plugins/ecommerce::shipping.city') }}"
                >
            @else
                <div class="ui-select-wrapper">
                    <select
                        class="ui-select form-control"
                        name="city"
                        data-type="city"
                        data-using-select2="false"
                        data-url="{{ route('ajax.cities-by-state') }}"
                    >
                        <option value="">{{ __('Select city...') }}</option>
                        @if ($address->city)
                            @foreach (EcommerceHelper::getAvailableCitiesByState($address->state) as $cityId => $cityName)
                                <option
                                    value="{{ $cityId }}"
                                    @if ($address->city == $cityId) selected @endif
                                >{{ $cityName }}</option>
                            @endforeach
                        @endif
                    </select>
                    <svg class="svg-next-icon svg-next-icon-size-16">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                        >
                            <path d="M10 16l-4-4h8l-4 4zm0-12L6 8h8l-4-4z"></path>
                        </svg>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.address') }}</label>
            <input
                class="next-input"
                name="address"
                type="text"
                value="{{ $address->address }}"
                placeholder="{{ trans('plugins/ecommerce::shipping.address') }}"
            >
        </div>
    </div>

    @if (EcommerceHelper::isZipCodeEnabled())
        <div class="next-form-grid">
            <div class="next-form-grid-cell">
                <label class="text-title-field required">{{ trans('plugins/ecommerce::shipping.zip_code') }}</label>
                <input
                    class="next-input"
                    name="zip_code"
                    type="text"
                    value="{{ $address->zip_code }}"
                    placeholder="{{ trans('plugins/ecommerce::shipping.zip_code') }}"
                >
            </div>
        </div>
    @endif

</div>
{!! Form::close() !!}
