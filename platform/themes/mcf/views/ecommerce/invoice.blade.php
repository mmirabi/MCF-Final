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
                    <div>
                        <div class="clearfix">
                            <div class="table-wrapper-responsive">
                                <div class="SEPETSOL">
                                    <div>
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th class="delivery-address" scope="col">
                                                    <span class="sepettitle"
                                                          style="text-align:center;">{{ __('Invoice information') }}</span>
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
                                                                    <label>Ad Soyad <span
                                                                            id="MainContent_RequiredFieldValidator2"
                                                                            class="require" style="visibility:hidden;">Gerekli</span>
                                                                        <span
                                                                            id="MainContent_RegularExpressionValidator1"
                                                                            class="require" style="visibility:hidden;">Hatalı</span>
                                                                    </label>
                                                                    <input name="address[name]"
                                                                           value="{{ old('address.name', Arr::get($sessionCheckoutData, 'name')) ?:(auth('customer')->check() ? auth('customer')->user()->name : '') }}"
                                                                           type="text" maxlength="50"
                                                                           id="address_name"
                                                                           placeholder="Adınız Soyadınız">
                                                                </div>
                                                                <div>
                                                                    <label>E-posta Adresi <span
                                                                            id="MainContent_RequiredFieldValidator1"
                                                                            class="require" style="visibility:hidden;">Gerekli</span>
                                                                        <span
                                                                            id="MainContent_RegularExpressionValidator2"
                                                                            title="Hatalı Email Girildi. "
                                                                            class="require" style="visibility:hidden;">Hatalı</span>
                                                                    </label>
                                                                    <input name="address[email]"
                                                                           value="{{ old('address.email', Arr::get($sessionCheckoutData, 'email')) ?:(auth('customer')->check() ? auth('customer')->user()->email : '') }}"
                                                                           maxlength="50" id="address_email"
                                                                           type="email" placeholder="E-posta">
                                                                </div>
                                                                <div>
                                                                    <label>Telefon <span
                                                                            id="MainContent_RequiredFieldValidator3"
                                                                            class="require" style="visibility:hidden;">Gerekli</span>
                                                                    </label>
                                                                    <input name="address[phone]"
                                                                           value="{{ old('address.phone', Arr::get($sessionCheckoutData, 'phone')) ?:(auth('customer')->check() ? auth('customer')->user()->phone : '') }}"
                                                                           maxlength="20" id="address_phone"
                                                                           type="tel" placeholder="Telefon">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label>Şehir <span
                                                                            id="MainContent_RequiredFieldValidator3"
                                                                            class="require" style="visibility:hidden;">Gerekli</span>
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
                                                                                        <label>Adres <span
                                                                                                id="MainContent_RequiredFieldValidator12"
                                                                                                class="require"
                                                                                                style="visibility:hidden;">Gerekli</span>
                                                                                        </label>
                                                                                        <textarea name="address[address]"
                                                                                                   rows="3"
                                                                                                  cols="20"
                                                                                                  maxlength="256"
                                                                                                  id="address_address"
                                                                                                  onkeyup="TextBoxMaxLength('lblMaxLength', this, '', 256)"
                                                                                                  onchange="TextBoxMaxLength('lblMaxLength', this, '', 256)"
                                                                                                  placeholder="Adres">{{ old('address.address', Arr::get($sessionCheckoutData, 'address')) ?:(auth('customer')->check() ? auth('customer')->user()->address : '') }}</textarea>
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
                                                                                        Şirket Adına <span
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
                                                                                                    placeholder="Firma Adı"
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
                                                                                                    placeholder="Vergi Dairesi"
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
                                                                                                    placeholder="Vergi Kimlik No"
                                                                                                    value="{{ old('address.company_tax_id', Arr::get($sessionCheckoutData, 'company_tax_id')) ?:(auth('customer')->check() ? auth('customer')->user()->company_tax_id : '') }}"
                                                                                                    style="margin-bottom:0">
                                                                                                <span
                                                                                                    id="MainContent_RegExp1"
                                                                                                    style="color:Red;visibility:hidden;">Vergi numarası ise 10 karakter, şahıs şirketiyseniz TCNO 11 karakter ve sadece sayı olmalıdır.</span>
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
                </div>
            </div>
        </div>
        <script>
            var url = '{{ route('public.checkout.save-information', session('tracked_start_checkout')) }}';
            setTimeout(function () {
                $('#sonrakibuton').click(function () {
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
                })
            }, 1000)
        </script>
        </body>
    @endif
@else
    <div class="container" style="height: 350px;">
        <div class="row row justify-content-md-center">
            <div class="col-md-auto">
                <h3>{{ __('No products in the cart.') }}</h3>
            </div>

        </div>

        <div class="row row justify-content-md-center">
            <div class="col-md-auto margin-50">
                <a class="btn btn-primary" style="padding: 20px;" href="{{ route('public.products') }}"
                   role="button">{{ __('Start shopping') }}</a>
            </div>
        </div>

    </div>
@endif
