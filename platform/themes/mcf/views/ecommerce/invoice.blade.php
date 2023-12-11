<html>
<head>
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/invoice.css') }}">
</head>
@if (Cart::instance('cart')->count() > 0)
    @php
        $products = get_products([
            'condition' => [
                ['ec_products.id', 'IN', Cart::instance('cart')->content()->pluck('id')->all()],
            ],
            'with' => ['slugable'],
        ]);
    @endphp
    @if (count($products))
        <body>
        <div class="sepetmain">
            <div class="container">
                <div class=" margin-bottom-40">
                    <div class="sepettitleicon">
                        <div>
                            <img src="{{ Theme::asset()->url('imgs/theme/cart/delivery_active.png') }}">
                            <br>
                            <span>{{ __('Delivery') }}</span>
                        </div>
                        <div>
                            <img src="{{ Theme::asset()->url('imgs/theme/cart/additional_gifts_active.png') }}">
                            <br>
                            <span>{{ __('Additional Gifts') }}</span>
                        </div>
                        <div>
                            <img src="{{ Theme::asset()->url('imgs/theme/cart/message_card_active.png') }}">
                            <br>
                            <span>{{ __('Message Card') }}</span>
                        </div>
                        <div>
                            <img src="{{ Theme::asset()->url('imgs/theme/cart/invoice_active.png') }}">
                            <br>
                            <span>{{ __('Invoice') }}</span>
                        </div>
                        <div>
                            <img src="{{ Theme::asset()->url('imgs/theme/cart/payment.png') }}">
                            <br>
                            <span>{{ __('Payment') }}</span>
                        </div>
                    </div>
                    <div class="invoice-form {{ EcommerceHelper::isEnabledGuestCheckout() && !auth('customer')->check() ? 'd-none' : ''}}">
                        <div class="clearfix">
                            <div class="table-wrapper-responsive">
                                <div class="SEPETSOL">
                                    <div>
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th class="delivery-address" scope="col">
                                                    <span class="sepettitle" style="text-align:center;">{{ __('Invoice information') }}</span>
                                                </th>
                                            </tr>
                                            @php
                                                $sessionCheckoutData = \Botble\Ecommerce\Facades\OrderHelper::getOrderSessionData(session('tracked_start_checkout'))
                                            @endphp
                                            @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                                @php
                                                    $product = $products->find($cartItem->id);
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div style="width:100%;">
                                                            <div
                                                                style="padding-top:20px;max-width: 400px;margin: auto;">
                                                                <div>
                                                                    <label>{{ __('Name and Surname') }}<span
                                                                            id="MainContent_RequiredFieldValidator2"
                                                                            class="require" style="visibility:hidden;">{{ __('Required') }}</span>
                                                                        <span
                                                                            id="MainContent_RegularExpressionValidator1"
                                                                            class="require" style="visibility:hidden;">{{ __('Wrong') }}</span>
                                                                    </label>
                                                                    <input name="address[name]"
                                                                           value="{{ old('address.name', Arr::get($sessionCheckoutData, 'name')) ?:(auth('customer')->check() ? auth('customer')->user()->name : '') }}"
                                                                           type="text" maxlength="50"
                                                                           id="address_name"
                                                                           placeholder="{{ __('Name and Surname') }}">
                                                                </div>
                                                                <div>
                                                                    <label>{{ __('Mail Address') }}<span
                                                                            id="MainContent_RequiredFieldValidator1"
                                                                            class="require" style="visibility:hidden;">{{ __('Required') }}</span>
                                                                        <span
                                                                            id="MainContent_RegularExpressionValidator2"
                                                                            title="{{ __('Incorrect Email Entered.') }}"
                                                                            class="require" style="visibility:hidden;">{{ __('Wrong') }}</span>
                                                                    </label>
                                                                    <input name="address[email]"
                                                                           value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) ?:(auth('customer')->check() ? auth('customer')->user()->email : '') }}"
                                                                           maxlength="50" id="address_email"
                                                                           type="email" placeholder="{{ __('Email') }}">
                                                                </div>
                                                                <div>
                                                                    <label>{{ __('Phone') }}<span
                                                                            id="MainContent_RequiredFieldValidator3"
                                                                            class="require" style="visibility:hidden;">{{ __('Required') }}</span>
                                                                    </label>
                                                                    <input name="address[phone]"
                                                                           value="{{ old('address.phone', Arr::get($sessionCheckoutData, 'phone')) ?:(auth('customer')->check() ? auth('customer')->user()->phone : '') }}"
                                                                           maxlength="20" id="address_phone"
                                                                           type="tel" placeholder="{{ __('Phone') }}">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label>{{ __('City') }}<span
                                                                            id="MainContent_RequiredFieldValidator3"
                                                                            class="require" style="visibility:hidden;">{{ __('Required') }}</span>
                                                                    </label>
                                                                    @php
                                                                        $cityc = old('address.city', Arr::get($sessionCheckoutData, 'city')) ?:(auth('customer')->check() ? auth('customer')->user()->city : '');
                                                                    @endphp
                                                                    <select name="address[city]" id="address_city" data-type="location" data-placeholder="{{ __('Select city...') }}" required >
                                                                        <option value="">{{ __('Select city...') }}</option>
                                                                        @foreach(\Botble\Location\Models\City::all() as $city)
                                                                            <option value="{{ $city->id }}" {{ $cityc ==  $city->id ? "selected" : ''}}>{{ $city->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div id="MainContent_UpdatePanel1">
                                                                    <div>
                                                                        <div id="MainContent_faturagoster">
                                                                            <div id="MainContent_yeniadrestable">
                                                                                <div>
                                                                                    <div style="position: relative;">
                                                                                        <label>{{ __('Adddress') }}<span
                                                                                            id="MainContent_RequiredFieldValidator12"
                                                                                            class="require"
                                                                                            style="visibility:hidden;">{{ __('Required') }}</span>
                                                                                        </label>
                                                                                        <textarea name="address[address]"
                                                                                            rows="3"
                                                                                            cols="20"
                                                                                            maxlength="256"
                                                                                            id="address_address"
                                                                                            onkeyup="TextBoxMaxLength('lblMaxLength', this, '', 256)"
                                                                                            onchange="TextBoxMaxLength('lblMaxLength', this, '', 256)"
                                                                                            placeholder="{{ __('Adddress') }}">{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) ?:(auth('customer')->check() ? auth('customer')->user()->address : '') }}</textarea>
                                                                                        <br>
                                                                                    </div>
                                                                                    <script>
                                                                                        function kurumsalformcheck() {
                                                                                            $('#adreskaydetCheckBox1div').data('visible', $('#adreskaydetCheckBox1div').data('visible') == 0 ? 1 : 0)
                                                                                            $('#kurumsalform').toggle();
                                                                                            $('.slider1').toggleClass('checked1');
                                                                                        }
                                                                                    </script>
                                                                                    <div id="adreskaydetCheckBox1div"
                                                                                         data-visible="{{ Arr::get($sessionCheckoutData, 'is_company')?:0 }}"
                                                                                         onclick="kurumsalformcheck()">
                                                                                         {{ __('On behalf of the company') }}
                                                                                         <span
                                                                                            class="switch1">
                                                                                    <span class="slider1 round {{ Arr::get($sessionCheckoutData, 'is_company')? "checked1": "" }}"></span>
                                                                            </span>
                                                                                    </div>
                                                                                    <div id="kurumsalform"
                                                                                         style="display:{{ Arr::get($sessionCheckoutData, 'is_company')? "block": "none" }};">
                                                                                        <div id="MainContent_unvantr">
                                                                                            <div>
                                                                                                <input
                                                                                                    name="address[company_name]"
                                                                                                    type="text"
                                                                                                    maxlength="255"
                                                                                                    id="address_company_name"
                                                                                                    placeholder="{{ __('Company Name') }}"
                                                                                                    value="{{ old('address.company_name', Arr::get($sessionCheckoutData, 'company_name')) ?:(auth('customer')->check() ? auth('customer')->user()->company_name : '') }}"
                                                                                                    style="margin-bottom:0">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            id="MainContent_vergidairetr">
                                                                                            <div>
                                                                                                <input
                                                                                                    name="address[company_tax]"
                                                                                                    id="address_company_tax"
                                                                                                    type="text"
                                                                                                    maxlength="50"
                                                                                                    placeholder="{{ __('Tax Administration') }}"
                                                                                                    value="{{ old('address.company_tax', Arr::get($sessionCheckoutData, 'company_tax')) ?:(auth('customer')->check() ? auth('customer')->user()->company_tax : '') }}"
                                                                                                    style="margin-bottom:0">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div id="MainContent_verginotr">
                                                                                            <div>
                                                                                                <input
                                                                                                    name="address[company_tax_id]"
                                                                                                    maxlength="11"
                                                                                                    id="address_company_tax_id"
                                                                                                    type="number"
                                                                                                    placeholder="{{ __('Tax identification number') }}"
                                                                                                    value="{{ old('address.company_tax_id', Arr::get($sessionCheckoutData, 'company_tax_id')) ?:(auth('customer')->check() ? auth('customer')->user()->company_tax_id : '') }}"
                                                                                                    style="margin-bottom:0">
                                                                                                <span
                                                                                                    id="MainContent_RegExp1"
                                                                                                    style="color:Red;visibility:hidden;">{{ __('The tax number must be 10 characters, if you are a sole proprietorship, the TR ID number must be 11 characters and only numbers.') }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <center>
                                        <a href="/messagecard">
                                            <u>{{ __('Back to Additional Gifts') }}</u>
                                        </a>
                                    </center>
                                </div>
                            </div>
                            <div class="SEPETSAG">
                                <div class="sepetozetrow">
                                    <div class="ozetic" style="position: relative;">
                                        <div class="position-relative" id="cart-item">
                                            <div class="payment-info-loading" style="display: none;">
                                                <div class="payment-info-loading-content">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                            <span class="sepettitle"
                                                  style="text-align:center;">{{ __('Order Summary') }}</span>
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>{{ __('Subtotal') }}:</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="price-text sub-total-text text-end">
                                                        {{ format_price(Cart::instance('cart')->rawSubTotal()) }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if (EcommerceHelper::isTaxEnabled())
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>{{ __('Tax') }}:</p>
                                                    </div>
                                                    <div class="col-6 float-end">
                                                        <p class="price-text tax-price-text">
                                                            {{ format_price(Cart::instance('cart')->rawTax()) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif @if (session('applied_coupon_code'))
                                                <div class="row coupon-information">
                                                    <div class="col-6">
                                                        <p>{{ __('Coupon code') }}:</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="price-text coupon-code-text">
                                                            {{ session('applied_coupon_code') }} </p>
                                                    </div>
                                                </div>
                                            @endif @if ($couponDiscountAmount > 0)
                                                <div class="row price discount-amount">
                                                    <div class="col-6">
                                                        <p>{{ __('Coupon code discount amount') }}:</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="price-text total-discount-amount-text">
                                                            {{ format_price($couponDiscountAmount) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif @if ($promotionDiscountAmount > 0)
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>{{ __('Promotion discount amount') }}:</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="price-text">
                                                            {{ format_price($promotionDiscountAmount) }} </p>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (!empty($shipping) && Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>{{ __('Shipping fee') }}:</p>
                                                    </div>
                                                    <div class="col-6 float-end">
                                                        <p class="price-text sub-total-text text-end">
                                                            {{ format_price(Cart::instance('cart')->shippingFee()) }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>
                                                            <strong>{{ __('Shipping fee') }}</strong>:
                                                        </p>
                                                    </div>
                                                    <div class="col-6 float-end">
                                                        <p class="price-text sub-total-text text-end">{{ format_price(Cart::instance('cart')->shippingFee()) }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <button id="sonrakibuton" class="btn green sonrakibuton">{{ __('Continue') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="login-singup-invoice {{ EcommerceHelper::isEnabledGuestCheckout() && !auth('customer')->check() ? '' : 'd-none'}}">
                            <div class="login-mcf-tab">
                                <nav class="nav nav-pills flex-column flex-sm-row">
                                    <a href="#pills-login" class="mevcutuyebtn active"  data-bs-toggle="pill" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Login') }}</a>
                                    <a href="#pills-register" class="mevcutuyebtn" data-bs-toggle="pill"  type="button" role="tab" aria-controls="pills-register" aria-selected="false">{{ __('Register')}}</a>
                                </nav>
                            </div>
                              <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                                    <h1 class="invoice-login-tab">{{ __('Login') }}</h1>
                                    <div id="Customer_Login">
                                        <span class="failureNotification"></span>
                                        <div style="max-width:400px;margin:auto;">
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
                                                <div class="login_footer form-group mb-10">
                                                    <div class="chek-form">
                                                        <div class="custome-checkbox">
                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember-checkbox" value="" />
                                                            <label class="form-check-label" for="remember-checkbox"><span>{{ __('Remember me') }}</span></label>
                                                        </div>
                                                    </div>
                                                    <a class="text-muted" href="{{ route('customer.password.reset') }}">{{ __('Forgot password?') }}</a>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-heading btn-block hover-up btn-mn">{{ __('Login') }}</button>
                                                </div>
                                            </form>
                                            <div style="padding-top:6px;">
                                                <a class="btn green membershipbtn" href="#">{{ __('Continue Without Membership') }}</a>
                                                <div class="sosyalmedyaline">
                                                    <span>{{ __('Login with social account') }}</span>
                                                </div>
                                                {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                                                <br>
                                                <br>
                                                <a href="/terms-conditions">{{ __('Terms & Conditions') }}</a>
                                            </div>
                                            <br>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab">
                                    <h1 class="invoice-login-tab">{{ __('Register') }}</h1>
                                    <form method="POST" action="{{ route('customer.register.post') }}">
                                        @csrf
                                        <div class="form__content">
                                            <div class="form-group">
                                                <input class="form-control" name="name" id="txt-name" type="text" value="{{ old('name') }}" placeholder="{{ __('Your name') }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" name="email" id="txt-email" type="email" value="{{ old('email') }}" placeholder="{{ __('Your email address') }}">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control" type="password" name="password" id="txt-password" placeholder="{{ __('Your password') }}">
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <input class="form-control" type="password" name="password_confirmation" id="txt-password-confirmation" placeholder="{{ __('Password confirmation') }}">
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                                @endif
                                            </div>
                                            @if (is_plugin_active('captcha'))
                                                @if(Captcha::isEnabled() && get_ecommerce_setting('enable_recaptcha_in_register_page', 0))
                                                    <div class="form-group">
                                                        {!! Captcha::display() !!}
                                                    </div>
                                                @endif

                                                @if (get_ecommerce_setting('enable_math_captcha_in_register_page', 0))
                                                    <div class="form-group">
                                                        <label class="form-label" for="math-group">{{ app('math-captcha')->label() }}</label>
                                                        {!! app('math-captcha')->input(['class' => 'form-control', 'id' => 'math-group', 'placeholder' => app('math-captcha')->getMathLabelOnly()]) !!}
                                                    </div>
                                                @endif
                                            @endif

                                            <div class="login_footer form-group">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input type="hidden" name="agree_terms_and_policy" value="0">
                                                        <input class="form-check-input" type="checkbox" name="agree_terms_and_policy" id="agree-terms-and-policy" value="1" @if (old('agree_terms_and_policy') == 1) checked @endif>
                                                        <label class="form-check-label" for="agree-terms-and-policy"><span>{!! BaseHelper::clean(__('I agree to terms & Policy.')) !!}</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up btn-mn">{{ __('Register') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div style="padding-top:6px;">
                                        <a class="btn green membershipbtn" href="#">{{ __('Continue Without Membership') }}</a>
                                        <div class="sosyalmedyaline">
                                            <span>{{ __('Login with social account') }}</span>
                                        </div>
                                        {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Ecommerce\Models\Customer::class) !!}
                                        <br>
                                        <br>
                                        <a href="/terms-conditions">{{ __('Terms & Conditions') }}</a>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var url = '{{ route('public.checkout.save-information', session('tracked_start_checkout')) }}';
            setTimeout(function () {
                $('#sonrakibuton').click(function () {
                    var disabledbtn = false;
                    [
                        $('#address_name').val(),
                        $('#address_phone').val(),
                        $('#address_email').val(),
                        $('#address_city').val()
                    ].forEach(function (v) {
                        if (!String(v).length) {
                            disabledbtn = true;
                        }
                    })
                    if(!disabledbtn && $('#adreskaydetCheckBox1div').data('visible')) {
                        [
                            $('#address_company_name').val(),
                            $('#address_company_tax').val(),
                            $('#address_company_tax_id').val(),
                        ].forEach(function (v) {
                            if (!String(v).length) {
                                disabledbtn = true;
                            }
                        })
                    }
                    if(disabledbtn)
                        window.showAlert('alert-danger', 'Please complete the details.')
                    else {
                        $.ajax({
                            type: 'POST',
                            //url: '{{ route('public.checkout.save-information', session('tracked_start_checkout')) }}',
                            url: '{{ route('public.checkout.process', session('tracked_start_checkout')) }}',
                            data: {
                                _token: $('meta[name=csrf-token]').prop('content'),
                                address: {
                                    name: $('#address_name').val(),
                                    phone: $('#address_phone').val(),
                                    email: $('#address_email').val(),
                                    address: $('#address_address').val(),
                                    city: $('#address_city').val(),
                                    is_company: $('#adreskaydetCheckBox1div').data('visible'),
                                    company_name: $('#address_company_name').val(),
                                    company_tax: $('#address_company_tax').val(),
                                    company_tax_id: $('#address_company_tax_id').val(),
                                },
                                payment_method: 'cod',
                                shipping_method: 'default',
                            },
                            success: (response) => {
                                if (response.error) {
                                    window.showAlert('alert-danger', response.message)
                                    return false
                                }
                                window.showAlert('alert-success', response.message??'Successfully done')
                                window.location.href = "{{ route('public.checkout.success', session('tracked_start_checkout')) }}"
                            },
                            error: (response) => {
                                window.showAlert('alert-danger', response.responseJSON.message)
                            },
                        })
                    }
                })
                $('.membershipbtn').click(function () {
                    $('.login-singup-invoice').addClass('d-none')
                    $('.invoice-form').removeClass('d-none')
                })
            }, 1000)
        </script>
        </body>
    @endif
@else
<div class="container-fluid ">
    <div class="row">
       <div class="col-md-12">
            <div class="card-body cart">
                <div class="col-sm-12 empty-cart-cls text-center">
                    <img src="{{ Theme::asset()->url('imgs/theme/empty-cart-mcf.webp') }}" width="500" height="500" class="img-fluid mb-4 mr-3">
                    <h3><strong>{{ __('No products in the cart.') }}</strong></h3>
                    <h5>{{ __('Add something to make me happy') }}</h5><br>
                    <a class="btn btn-primary" style="padding: 20px;" href="{{ route('public.products') }}" role="button">{{ __('Start shopping') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
