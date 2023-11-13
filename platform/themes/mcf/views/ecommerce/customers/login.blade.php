@php
    Theme::layout('full-width');
@endphp

<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                <div class="row">
                    <div class="col-lg-6 pr-30 d-none d-lg-block">
                        @if ($image = theme_option('image_in_login_page', theme_option('logo')))
                            <img class="border-radius-15" src="{{ RvMedia::getImageUrl($image) }}" alt="{{ theme_option('site_name') }}" />
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h1 class="mb-5">{{ __('Login') }}</h1>
                                    <p class="mb-30">{{ __("Don't have an account?") }} <a href="{{ route('customer.register') }}">{{ __('Create one') }}</a></p>
                                </div>
                                <form method="POST" action="{{ route('customer.login.post') }}">
                                    @csrf
                                    @if (isset($errors) && $errors->has('confirmation'))
                                        <div class="alert alert-danger">
                                            <span>{!! $errors->first('confirmation') !!}</span>
                                        </div>
                                        <br>
                                    @endif
                                    <div class="form-group">
                                        <input name="email" required id="txt-email" type="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}*">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required name="password" id="txt-password" placeholder="{{ __('Your password') }}*">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <div class="login_footer form-group mb-50">
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember-checkbox" value="" />
                                                <label class="form-check-label" for="remember-checkbox"><span>{{ __('Remember me') }}</span></label>
                                            </div>
                                        </div>
                                        <a class="text-muted" href="{{ route('customer.password.reset') }}">{{ __('Forgot password?') }}</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-heading btn-block hover-up">{{ __('Login') }}</button>
                                    </div>
                                    <div class="text-left">
                                        {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
