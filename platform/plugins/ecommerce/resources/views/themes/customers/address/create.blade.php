@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <h2 class="customer-page-title">{{ __('Add a new address') }}</h2>
    <br>
    <div class="profile-content">

        {!! Form::open(['route' => 'customer.address.create']) !!}
        <div class="input-group">
            <span class="input-group-prepend">{{ __('Full Name') }}:</span>
            <input
                class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
            >
        </div>
        {!! Form::error('name', $errors) !!}

        <div class="input-group">
            <span class="input-group-prepend">{{ __('Email') }}:</span>
            <input
                class="form-control"
                id="email"
                name="email"
                type="text"
                value="{{ old('email') }}"
            >
        </div>
        {!! Form::error('email', $errors) !!}

        <div class="input-group">
            <span class="input-group-prepend">{{ __('Phone') }}:</span>
            {!! Form::text('phone', old('phone'), ['id' => 'phone']) !!}
        </div>
        {!! Form::error('phone', $errors) !!}

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
                            @if (old('country') == $countryCode) selected @endif
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
                    @if (old('country') || !EcommerceHelper::isUsingInMultipleCountries())
                        @foreach (EcommerceHelper::getAvailableStatesByCountry(old('country')) as $stateId => $stateName)
                            <option
                                value="{{ $stateId }}"
                                @if (old('state') == $stateId) selected @endif
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
                    value="{{ old('state') }}"
                >
            @endif
        </div>
        {!! Form::error('state', $errors) !!}

        <div class="input-group @if ($errors->has('city')) has-error @endif">
            <span class="input-group-prepend required ">{{ __('City') }}:</span>
            @if (EcommerceHelper::useCityFieldAsTextField())
                <input
                    class="form-control"
                    id="city"
                    name="city"
                    type="text"
                    value="{{ old('city') }}"
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
                    @if (old('state'))
                        @foreach (EcommerceHelper::getAvailableCitiesByState(old('state')) as $cityId => $cityName)
                            <option
                                value="{{ $cityId }}"
                                @if (old('city') == $cityId) selected @endif
                            >{{ $cityName }}</option>
                        @endforeach
                    @endif
                </select>
            @endif
        </div>
        {!! Form::error('city', $errors) !!}

        <div class="input-group">
            <span class="input-group-prepend required ">{{ __('Address') }}:</span>
            <input
                class="form-control"
                id="address"
                name="address"
                type="text"
                value="{{ old('address') }}"
            >

        </div>
        {!! Form::error('address', $errors) !!}

        @if (EcommerceHelper::isZipCodeEnabled())
            <div class="mb-3 form-group">
                <label>{{ __('Zip code') }}:</label>
                <input
                    class="form-control"
                    id="zip_code"
                    name="zip_code"
                    type="text"
                    value="{{ old('zip_code') }}"
                >
                {!! Form::error('zip_code', $errors) !!}
            </div>
        @endif

        <div class="input-group">
            <label for="is_default">
                <input
                    id="is_default"
                    name="is_default"
                    type="checkbox"
                    value="1"
                >
                {{ __('Use this address as default.') }}

            </label>
        </div>
        {!! Form::error('is_default', $errors) !!}

        <div class="text-center form-group">
            <button
                class="btn btn-primary"
                type="submit"
            >{{ __('Add a new address') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
