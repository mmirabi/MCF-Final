@extends(EcommerceHelper::viewPath('customers.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="customer-page-title">{{ __('Change password') }}</h2>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'customer.post.change-password', 'method' => 'post']) !!}

            <div class="form-group mb-20">
                <label
                    class="input-group-prepend"
                    for="old_password"
                >{{ __('Current Password') }}: </label>
                <input
                    class="form-control"
                    id="old_password"
                    name="old_password"
                    type="password"
                    placeholder="{{ __('Current Password') }}"
                >
                {!! Form::error('old_password', $errors) !!}
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group mb-20">
                    <label
                        class="input-group-prepend"
                        for="password"
                    >{{ __('New password') }}: </label>
                    <input
                        class="form-control"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="{{ __('New Password') }}"
                    >
                    {!! Form::error('password', $errors) !!}
                </div>

                <div class="col-12 col-lg-6 form-group mb-20">
                    <label
                        class="input-group-prepend"
                        for="password_confirmation"
                    >{{ __('Password confirmation') }}: </label>
                    <input
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="{{ __('New Password') }}"
                    >
                    {!! Form::error('password_confirmation', $errors) !!}
                </div>
            </div>

            <div class="form-group text-center">
                <button
                    class="btn btn-primary btn-sm"
                    type="submit"
                >{{ __('Change password') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
