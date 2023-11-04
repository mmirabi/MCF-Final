<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="form-border-box">
                <form
                    class="form-horizontal"
                    role="form"
                    method="POST"
                    action="{{ route('customer.register.post') }}"
                >
                    <h2 class="normal"><span>{{ __('Register') }}</span></h2>
                    @csrf

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label
                            class="col-md-4 control-label"
                            for="name"
                        >{{ __('Name') }}</label>

                        <div class="col-md-12">
                            <input
                                class="form-control"
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                autofocus
                            >

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {!! apply_filters('ecommerce_customer_register_form_before', null) !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label
                            class="col-md-4 control-label"
                            for="email"
                        >{{ __('E-Mail Address') }}</label>

                        <div class="col-md-12">
                            <input
                                class="form-control"
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                            >

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label
                            class="col-md-4 control-label"
                            for="password"
                        >{{ __('Password') }}</label>

                        <div class="col-md-12">
                            <input
                                class="form-control"
                                id="password"
                                name="password"
                                type="password"
                            >

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label
                            class="col-md-4 control-label"
                            for="password-confirm"
                        >{{ __('Password confirmation') }}</label>

                        <div class="col-md-12">
                            <input
                                class="form-control"
                                id="password-confirm"
                                name="password_confirmation"
                                type="password"
                            >

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <input
                            name="agree_terms_and_policy"
                            type="hidden"
                            value="0"
                        >
                        <input
                            class="form-control"
                            id="agree-terms-and-policy"
                            name="agree_terms_and_policy"
                            type="checkbox"
                            value="1"
                        >
                        <label for="agree-terms-and-policy">{!! BaseHelper::clean(__('I agree to terms & Policy.')) !!}</label>

                        @if ($errors->has('agree_terms_and_policy'))
                            <span class="text-danger">{{ $errors->first('agree_terms_and_policy') }}</span>
                        @endif
                    </div>

                    @if (is_plugin_active('captcha'))
                        @if (Captcha::isEnabled() && get_ecommerce_setting('enable_recaptcha_in_register_page', 0))
                            <div class="form-group mb-3">
                                {!! Captcha::display() !!}
                            </div>
                        @endif

                        @if (get_ecommerce_setting('enable_math_captcha_in_register_page', 0))
                            <div class="form-group mb-3">
                                {!! app('math-captcha')->input([
                                    'class' => 'form-control',
                                    'id' => 'math-group',
                                    'placeholder' => app('math-captcha')->getMathLabelOnly(),
                                ]) !!}
                            </div>
                        @endif
                    @endif

                    <div class="form-group mb-3">
                        <div class="col-md-12 col-md-offset-4">
                            <button
                                class="submit btn btn-md btn-black"
                                type="submit"
                            >
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
