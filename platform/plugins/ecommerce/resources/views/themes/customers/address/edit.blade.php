@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <h2 class="customer-page-title">{{ __('Address books') }}</h2>
    <br>
    <div class="profile-content">

        {!! Form::open(['route' => ['customer.address.edit', $address->id]]) !!}
        <div class="input-group">
            <span class="input-group-prepend">{{ __('Full Name') }}:</span>
            <input
                class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $address->name) }}"
            >
            {!! Form::error('name', $errors) !!}
        </div>

        <div class="input-group">
            <span class="input-group-prepend">{{ __('Email') }}:</span>
            <input
                class="form-control"
                id="email"
                name="email"
                type="text"
                value="{{ old('email', $address->email) }}"
            >
            {!! Form::error('email', $errors) !!}
        </div>

        <div class="input-group">
            <span class="input-group-prepend">{{ __('Phone') }}:</span>
            {!! Form::text('phone', old('phone', $address->phone), ['id' => 'phone']) !!}
            {!! Form::error('phone', $errors) !!}
        </div>

        @if (EcommerceHelper::isUsingInMultipleCountries())
            <div class="form-group mb-3 @if ($errors->has('country')) has-error @endif">
                <label for="country">{{ __('Country') }}:</label>
                <select
                    class="form-control"
                    id="country"
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
            </div>
            {!! Form::error('country', $errors) !!}
        @else
            <input
                name="country"
                type="hidden"
                value="{{ EcommerceHelper::getFirstCountryId() }}"
            >
        @endif

        <div class="input-group @if ($errors->has('state')) has-error @endif">
            <span class="input-group-prepend required ">{{ __('State') }}:</span>
            @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                <select
                    class="form-control"
                    id="state"
                    name="state"
                    data-type="state"
                    data-url="{{ route('ajax.states-by-country') }}"
                >
                    <option value="">{{ __('Select state...') }}</option>
                    @if (old('country', $address->country) || !EcommerceHelper::isUsingInMultipleCountries())
                        @foreach (EcommerceHelper::getAvailableStatesByCountry(old('country', $address->country)) as $stateId => $stateName)
                            <option
                                value="{{ $stateId }}"
                                @if (old('state', $address->state) == $stateId) selected @endif
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
                    value="{{ $address->state }}"
                >
            @endif
            {!! Form::error('state', $errors) !!}
        </div>

        <div class="input-group @if ($errors->has('city')) has-error @endif">
            <span class="input-group-prepend required ">{{ __('City') }}:</span>
            @if (EcommerceHelper::useCityFieldAsTextField())
                <input
                    class="form-control"
                    id="city"
                    name="city"
                    type="text"
                    value="{{ $address->city }}"
                >
            @else
                <select
                    class="form-control"
                    id="city"
                    name="city"
                    data-type="city"
                    data-using-select2="false"
                    data-url="{{ route('ajax.cities-by-state') }}"
                >
                    <option value="">{{ __('Select city...') }}</option>
                    @if (old('state', $address->state))
                        @foreach (EcommerceHelper::getAvailableCitiesByState(old('state', $address->state)) as $cityId => $cityName)
                            <option
                                value="{{ $cityId }}"
                                @if (old('city', $address->city) == $cityId) selected @endif
                            >{{ $cityName }}</option>
                        @endforeach
                    @endif
                </select>
            @endif
            {!! Form::error('city', $errors) !!}
        </div>

        <div class="input-group">
            <span class="input-group-prepend required ">{{ __('Address') }}:</span>
            <input
                class="form-control"
                id="address"
                name="address"
                type="text"
                value="{{ $address->address }}"
            >
            {!! Form::error('address', $errors) !!}
        </div>

        @if (EcommerceHelper::isZipCodeEnabled())
            <div class="mb-3 form-group">
                <label>{{ __('Zip code') }}:</label>
                <input
                    class="form-control"
                    id="zip_code"
                    name="zip_code"
                    type="text"
                    value="{{ $address->zip_code }}"
                >
                {!! Form::error('zip_code', $errors) !!}
            </div>
        @endif

        <div class="mb-3 form-group">
            <label for="is_default">
                <input
                    class="customer-checkbox"
                    id="is_default"
                    name="is_default"
                    type="checkbox"
                    value="1"
                    @if ($address->is_default) checked @endif
                >
                {{ __('Use this address as default.') }}
                {!! Form::error('is_default', $errors) !!}
            </label>
        </div>

        <div class="mb-3 form-group">
            <button
                class="btn btn-primary"
                type="submit"
            >{{ __('Update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
