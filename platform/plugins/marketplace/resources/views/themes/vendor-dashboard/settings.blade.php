@extends(MarketplaceHelper::viewPath('vendor-dashboard.layouts.master'))

@section('content')
    <div class="ps-card__content">
        {!! Form::open([
            'route' => 'marketplace.vendor.settings',
            'class' => 'ps-form--account-setting',
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}
        <div class="ps-form__content">
            <ul class="nav nav-tabs ">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        data-bs-toggle="tab"
                        href="#tab_information"
                    >{{ __('General Information') }}</a>
                </li>
                @include('plugins/marketplace::customers.tax-info-tab')
                @include('plugins/marketplace::customers.payout-info-tab')
                {!! apply_filters('marketplace_vendor_settings_register_content_tabs', null, $store) !!}
            </ul>
            <div class="tab-content">
                <div
                    class="tab-pane active"
                    id="tab_information"
                >
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    class="required"
                                    for="shop-name"
                                >{{ __('Shop Name') }}</label>
                                <input
                                    class="form-control"
                                    id="shop-name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $store->name) }}"
                                    placeholder="{{ __('Shop Name') }}"
                                >
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    class="required"
                                    for="shop-company"
                                >{{ __('Company Name') }}</label>
                                <input
                                    class="form-control"
                                    id="shop-company"
                                    name="company"
                                    type="text"
                                    value="{{ old('company', $store->company) }}"
                                    placeholder="{{ __('Company Name') }}"
                                >
                                @if ($errors->has('company'))
                                    <span class="text-danger">{{ $errors->first('company') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    class="required"
                                    for="shop-phone"
                                >{{ __('Phone Number') }}</label>
                                <input
                                    class="form-control"
                                    id="shop-phone"
                                    name="phone"
                                    type="text"
                                    value="{{ old('phone', $store->phone) }}"
                                    placeholder="{{ __('Shop phone') }}"
                                >
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    class="required"
                                    for="shop-email"
                                >{{ __('Shop Email') }}</label>
                                <input
                                    class="form-control"
                                    id="shop-email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $store->email ?: $store->customer->email) }}"
                                    placeholder="{{ __('Shop Email') }}"
                                >
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input
                                name="reference_id"
                                type="hidden"
                                value="{{ $store->id }}"
                            >
                            <div class="form-group shop-url-wrapper">
                                <label
                                    class="required float-start"
                                    for="shop-url"
                                >{{ __('Shop URL') }}</label>
                                <span class="d-inline-block float-end shop-url-status"></span>
                                <input
                                    class="form-control"
                                    id="shop-url"
                                    name="slug"
                                    data-url="{{ route('public.ajax.check-store-url') }}"
                                    type="text"
                                    value="{{ old('slug', $store->slug) }}"
                                    placeholder="{{ __('Shop URL') }}"
                                >
                                @if ($errors->has('slug'))
                                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                                @endif
                                <span class="d-inline-block"><small
                                        data-base-url="{{ route('public.store', old('slug', '')) }}"
                                    >{{ route('public.store', old('slug', $store->slug)) }}</small></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if (EcommerceHelper::isUsingInMultipleCountries())
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('country')) has-error @endif">
                                    <label for="country">{{ __('Country') }}</label>
                                    <select
                                        class="form-control"
                                        id="country"
                                        name="country"
                                        data-type="country"
                                    >
                                        @foreach (EcommerceHelper::getAvailableCountries() as $countryCode => $countryName)
                                            <option
                                                value="{{ $countryCode }}"
                                                @if (old('country', $store->country) == $countryCode) selected @endif
                                            >{{ $countryName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {!! Form::error('country', $errors) !!}
                            </div>
                        @endif
                        <div class="col-sm-6">
                            <div class="form-group @if ($errors->has('state')) has-error @endif">
                                <label for="state">{{ __('State') }}</label>
                                @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                                    <select
                                        class="form-control"
                                        id="state"
                                        name="state"
                                        data-type="state"
                                        data-url="{{ route('ajax.states-by-country') }}"
                                    >
                                        <option value="">{{ __('Select state...') }}</option>
                                        @if (old('country', $store->country) || !EcommerceHelper::isUsingInMultipleCountries())
                                            @foreach (EcommerceHelper::getAvailableStatesByCountry(old('country', $store->country)) as $stateId => $stateName)
                                                <option
                                                    value="{{ $stateId }}"
                                                    @if (old('state', $store->state) == $stateId) selected @endif
                                                >{{ $stateName }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                @else
                                    <input
                                        class="form-control"
                                        id="state"
                                        name="state"
                                        type="text"
                                        value="{{ old('state', $store->state) }}"
                                    >
                                @endif
                                {!! Form::error('state', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group @if ($errors->has('city')) has-error @endif">
                                <label for="city">{{ __('City') }}</label>
                                @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                                    <select
                                        class="form-control"
                                        id="city"
                                        name="city"
                                        data-type="city"
                                        data-url="{{ route('ajax.cities-by-state') }}"
                                    >
                                        <option value="">{{ __('Select city...') }}</option>
                                        @if (old('state', $store->state))
                                            @foreach (EcommerceHelper::getAvailableCitiesByState(old('state', $store->state)) as $cityId => $cityName)
                                                <option
                                                    value="{{ $cityId }}"
                                                    @if (old('city', $store->city) == $cityId) selected @endif
                                                >{{ $cityName }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                @else
                                    <input
                                        class="form-control"
                                        id="city"
                                        name="city"
                                        type="text"
                                        value="{{ old('city', $store->city) }}"
                                    >
                                @endif
                                {!! Form::error('city', $errors) !!}
                            </div>
                        </div>
                        @if (EcommerceHelper::isZipCodeEnabled())
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="zip_code">{{ __('Zip code') }}</label>
                                    <input
                                        class="form-control"
                                        id="zip_code"
                                        name="zip_code"
                                        type="text"
                                        value="{{ old('zip_code', $store->zip_code) }}"
                                    >
                                    {!! Form::error('zip_code', $errors) !!}
                                </div>
                            </div>
                        @endif
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    type="text"
                                    value="{{ old('address', $store->address) }}"
                                >
                                {!! Form::error('address', $errors) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="logo">{{ __('Logo') }}</label>
                                {!! Form::customImage('logo', old('logo', $store->logo)) !!}
                                {!! Form::error('logo', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="logo">{{ __('Cover Image') }}</label>
                                {!! Form::customImage('cover_image', old('cover_image', $store->getMetaData('cover_image', true))) !!}
                                {!! Form::error('cover_image', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea
                            class="form-control"
                            id="description"
                            name="description"
                            rows="3"
                        >{{ old('description', $store->description) }}</textarea>
                        {!! Form::error('description', $errors) !!}
                    </div>

                    <div class="form-group">
                        <label for="content">{{ __('Content') }}</label>
                        {!! Form::customEditor('content', old('content', $store->content)) !!}
                        {!! Form::error('content', $errors) !!}
                    </div>
                </div>
                @include('plugins/marketplace::customers.tax-form', ['model' => $store->customer])
                @include('plugins/marketplace::customers.payout-form', ['model' => $store->customer])
                {!! apply_filters('marketplace_vendor_settings_register_content_tab_inside', null, $store) !!}
            </div>

            <div class="form-group text-center">
                <div class="form-group submit">
                    <div class="ps-form__submit text-center">
                        <button class="ps-btn success">{{ __('Save settings') }}</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
