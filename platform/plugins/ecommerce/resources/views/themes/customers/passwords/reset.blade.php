<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('Reset Password') }}</div>

                <div class="panel-body">
                    <form
                        class="form-horizontal"
                        role="form"
                        method="POST"
                        action="{{ route('customer.password.reset.post') }}"
                    >
                        @csrf

                        <input
                            name="token"
                            type="hidden"
                            value="{{ $token }}"
                        >

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label
                                class="col-md-4 control-label"
                                for="email"
                            >{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ $email ?? old('email') }}"
                                    autofocus
                                >
                                {!! Form::error('email', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label
                                class="col-md-4 control-label"
                                for="password"
                            >{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    type="password"
                                >
                                {!! Form::error('password', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label
                                class="col-md-4 control-label"
                                for="password-confirm"
                            >{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input
                                    class="form-control"
                                    id="password-confirm"
                                    name="password_confirmation"
                                    type="password"
                                >
                                {!! Form::error('password_confirmation', $errors) !!}
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="col-md-6 col-md-offset-4">
                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                >
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
