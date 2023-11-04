<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('name')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.name') }}</label>
            <input
                class="form-control"
                id="address_name"
                name="name"
                type="text"
                value="{{ old('name', $address) }}"
                placeholder="{{ trans('plugins/ecommerce::addresses.name_placeholder') }}"
            >
            {!! Form::error('name', $errors) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('phone')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.phone') }}</label>
            <input
                class="form-control"
                id="address_phone"
                name="phone"
                type="text"
                value="{{ old('phone', $address) }}"
                placeholder="{{ trans('plugins/ecommerce::addresses.phone_placeholder') }}"
            >
            {!! Form::error('phone', $errors) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('zip_code')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.zip') }}</label>
            <input
                class="form-control"
                id="address_zip_code"
                name="zip_code"
                type="text"
                value="{{ old('zip_code', $address) }}"
                placeholder="{{ trans('plugins/ecommerce::addresses.zip_placeholder') }}"
            >
            {!! Form::error('zip_code', $errors) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('email')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.email') }}</label>
            <input
                class="form-control"
                id="address_email"
                name="email"
                type="text"
                value="{{ old('email', $address) }}"
                placeholder="{{ trans('plugins/ecommerce::addresses.email_placeholder') }}"
            >
            {!! Form::error('email', $errors) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group mb-3 @if ($errors->has('address')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.address') }}</label>
            <input
                class="form-control"
                id="address_address"
                name="address"
                type="text"
                value="{{ old('address', $address) }}"
                placeholder="{{ trans('plugins/ecommerce::addresses.address_placeholder') }}"
            >
            {!! Form::error('address', $errors) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        @if (EcommerceHelper::isUsingInMultipleCountries())
            <div class="form-group mb-3 @if ($errors->has('country')) has-error @endif">
                <label for="country">{{ __('Country') }}:</label>
                {!! Form::customSelect('country', EcommerceHelper::getAvailableCountries(), old('country', $address->country), [
                    'id' => 'country',
                    'data-type' => 'country',
                ]) !!}
            </div>
            {!! Form::error('country', $errors) !!}
        @else
            <input
                name="country"
                type="hidden"
                value="{{ EcommerceHelper::getFirstCountryId() }}"
            >
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('state')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.state') }}</label>
            @if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation())
                {!! Form::customSelect(
                    'country',
                    EcommerceHelper::getAvailableStatesByCountry(old('country', $address->country)),
                    old('state', $address->state),
                    ['id' => 'state', 'data-type' => 'state', 'data-url' => route('ajax.states-by-country')],
                ) !!}
            @else
                <input
                    class="form-control"
                    id="state"
                    name="state"
                    type="text"
                    value="{{ old('state', $address) }}"
                >
            @endif
            {!! Form::error('state', $errors) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-3 @if ($errors->has('city')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::addresses.city') }}</label>
            @if (EcommerceHelper::useCityFieldAsTextField())
                <input
                    class="form-control"
                    id="city"
                    name="city"
                    type="text"
                    value="{{ old('city', $address) }}"
                >
            @else
                {!! Form::customSelect(
                    'city',
                    EcommerceHelper::getAvailableStatesByCountry(old('state', $address->state)),
                    old('city', $address->city),
                    ['id' => 'city', 'data-type' => 'city', 'data-url' => route('ajax.cities-by-state')],
                ) !!}
            @endif
            {!! Form::error('city', $errors) !!}
        </div>
    </div>
</div>
