@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="customer-page-title">{{ __('Account information') }}</h2>
        </div>
        <div class="panel-body">

            {!! Form::open(['route' => 'customer.edit-account']) !!}

            <div class="form-group mb-20">
                <label
                    class="input-group-prepend"
                    for="name"
                >{{ __('Full Name') }}: </label>
                <input
                    class="form-control"
                    id="name"
                    name="name"
                    type="text"
                    value="{{ auth('customer')->user()->name }}"
                >
            </div>
            {!! Form::error('name', $errors) !!}

            <div class="form-group mb-20 @if ($errors->has('dob')) has-error @endif">
                <label
                    class="input-group-prepend"
                    for="date_of_birth"
                >{{ __('Date of birth') }}: </label>
                <input
                    class="form-control"
                    id="date_of_birth"
                    name="dob"
                    type="text"
                    value="{{ auth('customer')->user()->dob }}"
                >
            </div>
            {!! Form::error('dob', $errors) !!}
            <div class="form-group mb-20 @if ($errors->has('email')) has-error @endif">
                <label
                    class="input-group-prepend"
                    for="email"
                >{{ __('Email') }}: </label>
                <input
                    class="form-control"
                    id="email"
                    name="email"
                    type="text"
                    value="{{ auth('customer')->user()->email }}"
                    disabled="disabled"
                >
            </div>
            {!! Form::error('email', $errors) !!}

            <div class="form-group mb-20 @if ($errors->has('phone')) has-error @endif">
                <label
                    class="input-group-prepend"
                    for="phone"
                >{{ __('Phone') }}: </label>
                <input
                    class="form-control"
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ auth('customer')->user()->phone }}"
                    placeholder="{{ __('Phone') }}"
                >

            </div>
            {!! Form::error('phone', $errors) !!}

            <div class="form-group col s12 text-center">
                <button
                    class="btn btn-primary customer-btn"
                    type="submit"
                >{{ __('Update') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
