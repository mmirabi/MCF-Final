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
                            <img src="https://www.ribbonflowers.com/ikonlar/sepet1_aktif.png?v=1">
                            <br>
                            <span>{{ __('Delivery') }}</span>
                        </div>
                        <div>
                            <img src="https://www.ribbonflowers.com/ikonlar/sepet2_aktif.png?v=1">
                            <br>
                            <span>{{ __('Additional Gifts') }}</span>
                        </div>
                        <div>
                            <img src="https://www.ribbonflowers.com/ikonlar/sepet3_aktif.png?v=1">
                            <br>
                            <span>{{ __('Message Card') }}</span>
                        </div>
                        <div>
                            <img src="https://www.ribbonflowers.com/ikonlar/sepet4_aktif.png?v=1">
                            <br>
                            <span>{{ __('Invoice') }}</span>
                        </div>
                        <div>
                            <img src="https://www.ribbonflowers.com/ikonlar/sepet5.png">
                            <br>
                            <span>{{ __('Payment') }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="clearfix">
                            <div class="table-wrapper-responsive" style="margin-top:50px">
                                <div class="SEPETSOL">
                                    <div>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <th class="delivery-address" scope="col">
                                                        <span class="sepettitle" style="text-align:center;">{{ __('Invoice information') }}</span>
                                                    </th>
                                                </tr>
                                                @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                                    @php
                                                        $product = $products->find($cartItem->id);
                                                    @endphp
                                                <tr>
                                                    <td>
                                                        <div style="width:100%;">
                                                            <div style="padding-top:20px;max-width: 400px;margin: auto;">
                                                                <div>
                                                                  <label>Ad Soyad <span id="MainContent_RequiredFieldValidator2" class="require" style="visibility:hidden;">Gerekli</span>
                                                                    <span id="MainContent_RegularExpressionValidator1" class="require" style="visibility:hidden;">Hatalı</span>
                                                                  </label>
                                                                  <input name="ctl00$MainContent$ad_m" type="text" maxlength="50" id="MainContent_ad_m" placeholder="Adınız Soyadınız">
                                                                </div>
                                                                <div>
                                                                  <label>E-posta Adresi <span id="MainContent_RequiredFieldValidator1" class="require" style="visibility:hidden;">Gerekli</span>
                                                                    <span id="MainContent_RegularExpressionValidator2" title="Hatalı Email Girildi. " class="require" style="visibility:hidden;">Hatalı</span>
                                                                  </label>
                                                                  <input name="ctl00$MainContent$UserName" maxlength="50" id="MainContent_UserName" type="email" placeholder="E-posta">
                                                                </div>
                                                                <div>
                                                                  <label>Telefon <span id="MainContent_RequiredFieldValidator3" class="require" style="visibility:hidden;">Gerekli</span>
                                                                  </label>
                                                                  <input name="ctl00$MainContent$telefon_m" maxlength="20" id="MainContent_telefon_m" type="tel" placeholder="Telefon">
                                                                </div>
                                                                <div style="display:none;"> T.C. Kimlik No <input name="ctl00$MainContent$tcno" type="text" maxlength="11" id="MainContent_tcno" value="12345678910">
                                                                </div>
                                                                <textarea name="ctl00$MainContent$seethem" rows="3" cols="20" id="MainContent_seethem" style="display:none;"></textarea>
                                                                <div id="MainContent_UpdatePanel1">
                                                                  <script type="text/javascript" language="javascript">
                                                                    function jScript() {
                                                                     
                                                                    Sys.Application.add_load(jScript);
                                                                  </script>
                                                                  <div>
                                                                    <div id="MainContent_faturagoster">
                                                                      <div id="MainContent_yeniadrestable">
                                                                        <div>
                                                                          <div style="display:none;">
                                                                            <label>Ad Soyad: </label> &nbsp; <input name="ctl00$MainContent$yeni_adsoyad0" type="text" maxlength="100" id="MainContent_yeni_adsoyad0">
                                                                          </div>
                                                                          <div style="display:none;">
                                                                            <label>Telefon: </label> &nbsp; <input name="ctl00$MainContent$yeni_telefon" type="text" maxlength="50" id="MainContent_yeni_telefon" class="form-control phone">
                                                                          </div>
                                                                          <div>
                                                                            <div class="row">
                                                                              <div class="col-md-12"></div>
                                                                              <div style="padding:0 15px">
                                                                                <div id="MainContent_ildiv" class="col-md-6"></div>
                                                                              </div>
                                                                            </div>
                                                                            <div id="MainContent_UpdateProgress1" style="display:none;" role="status" aria-hidden="true">
                                                                            </div>
                                                                          </div>
                                                                        </div>
                                                                        <div>
                                                                          <div style="
                                                                  position: relative;
                                                              ">
                                                                            <label>Adres <span id="MainContent_RequiredFieldValidator12" class="require" style="visibility:hidden;">Gerekli</span>
                                                                            </label>
                                                                            <textarea name="ctl00$MainContent$yeni_adres" rows="3" cols="20" maxlength="256" id="MainContent_yeni_adres" onkeyup="TextBoxMaxLength('lblMaxLength', this, '', 256)" onchange="TextBoxMaxLength('lblMaxLength', this, '', 256)" placeholder="Adres"></textarea>
                                                                            <br>
                                                                          </div>
                                                                          <script>
                                                                            function kurumsalformcheck() {
                                                                              $('#kurumsalform').toggle();
                                                                              $('.slider1').toggleClass('checked1');
                                                                            }
                                                                          </script>
                                                                          <div id="adreskaydetCheckBox1div" visible="false" onclick="kurumsalformcheck()"> Şirket Adına <span class="switch1">
                                                                              <span class="slider1 round"></span>
                                                                            </span>
                                                                          </div>
                                                                          <div id="kurumsalform" style="display:none;">
                                                                            <div id="MainContent_unvantr">
                                                                              <div>
                                                                                <input name="ctl00$MainContent$yeni_unvan" type="text" maxlength="255" id="MainContent_yeni_unvan" placeholder="Firma Adı" style="margin-bottom:0">
                                                                              </div>
                                                                            </div>
                                                                            <div id="MainContent_vergidairetr">
                                                                              <div>
                                                                                <input name="ctl00$MainContent$yeni_vdaire" type="text" maxlength="50" id="MainContent_yeni_vdaire" placeholder="Vergi Dairesi" style="margin-bottom:0">
                                                                              </div>
                                                                            </div>
                                                                            <div id="MainContent_verginotr">
                                                                              <div>
                                                                                <input name="ctl00$MainContent$yeni_vno" maxlength="11" id="MainContent_yeni_vno" type="number" placeholder="Vergi Kimlik No" style="margin-bottom:0">
                                                                                <span id="MainContent_RegExp1" style="color:Red;visibility:hidden;">Vergi numarası ise 10 karakter, şahıs şirketiyseniz TCNO 11 karakter ve sadece sayı olmalıdır.</span>
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
                                            <span class="sepettitle" style="text-align:center;">{{ __('Order Summary') }}</span><hr>
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
                                            @endif @if (!empty($shipping) && Arr::get($sessionCheckoutData, 'is_available_shipping', true))
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>{{ __('Shipping fee') }}:</p>
                                                    </div>
                                                    <div class="col-6 float-end">
                                                        <p class="price-text shipping-price-text">
                                                            {{ format_price($shippingAmount) }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>
                                                        <strong>{{ __('Shipping fee') }}</strong>:
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <a href="/invoice" class="btn green sonrakibuton">{{ __('Continue') }}</a>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <a class="btn btn-primary" style="padding: 20px;" href="{{ route('public.products') }}" role="button">{{ __('Start shopping') }}</a>
        </div>
    </div>
    
</div>
@endif
