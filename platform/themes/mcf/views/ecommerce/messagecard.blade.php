<html>
    <head>        
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/messagecart.css') }}">
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
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet4.png">
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
                                                    <span class="sepettitle" style="text-align:center;">{{ __('Message Card') }}</span>
                                                </th>
                                            </tr>
                                            @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                                @php
                                                    $product = $products->find($cartItem->id);
                                                @endphp
                                            <tr>
                                                <td>
                                                    <div class="">
                                                        <div class="container">
                                                            <div class="row align-items-center">
                                                                <div class="col col-lg-2">
                                                                    <a href="{{ $product->original_product->url }}"><img alt="{{ $product->original_product->name }}" src="{{ RvMedia::getImageUrl($cartItem->options['image'], 'thumb', false, RvMedia::getDefaultImage()) }}" style="margin-right:15px;max-width:100%;width: 100%;border-radius: 5px;"></a>
                                                                </div>
                                                                <div class="col-7">
                                                                    <span class="sepeturuntitle"><a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}  @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</a></span>
                                                                    <p class="address-medyanossa">
                                                                        @if (!empty($cartItem->options['options']))
                                                                        {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
                                                                        @endif
                                                                    </p> 
                                                                </div>
                                                                <div class="col col-lg-2">
                                                                    <span><span class="d-inline-block">{{ format_price($cartItem->price) }}</span> @if ($product->front_sale_price != $product->price)
                                                                    <small><del>{{ format_price($product->price) }}</del></small>@endif</h3>
                                                                </div>
                                                                <div class="col col-lg-1">
                                                                    <a href="#" class="text-body remove-cart-button" data-url="{{ route('public.ajax.cart.destroy', $cartItem->rowId) }}"><i class="fi-rs-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="width:100%;">
                                                        <div>
                                                            <div>
                                                                <div class="locabackButton44 locabackButton4486925 locabackButton">
                                                                    <img src="https://www.ribbonflowers.com/ikonlar/leftarrow.png" style="width:24px;">
                                                                </div>
                                                            </div>
                                                            <div class="modal-body kartbilgi2" id="modal-body3" style="padding:0;">
                                                                <div id="kartnotsecdiv86925" data-id="86925" style="display:none;" aaaa="display:none;max-height:100%;max-height: 60vh;overflow-y: auto;"></div>
                                                                <div id="kartnotformdiv86925">
                                                                    <div class="notunuz">{{ __('Your Note') }}</div>
                                                                    <div class="hazirbuton" data-id="86925">
                                                                        <div class="hktitle" data-id="86925">{{ __('Choose from Ready Card Notes') }}</div>
                                                                        <div class="hazirkartcatsdiv hazirkartcatsdiv86925">
                                                                            <span class="hkcatbtn" data-cat="Anneler Günü">Anneler Günü</span>
                                                                            <span class="hkcatbtn" data-cat="Babalar Günü">Babalar Günü</span>
                                                                            <span class="hkcatbtn" data-cat="Doğum Günü">Doğum Günü</span>
                                                                            <span class="hkcatbtn" data-cat="Geçmiş Olsun">Geçmiş Olsun</span>
                                                                            <span class="hkcatbtn" data-cat="Kadınlar Günü">Kadınlar Günü</span>
                                                                            <span class="hkcatbtn" data-cat="Öğretmenler Günü">Öğretmenler Günü</span>
                                                                            <span class="hkcatbtn" data-cat="Sevgiliye">Sevgiliye</span>
                                                                            <span class="hkcatbtn" data-cat="Tebrikler">Tebrikler</span>
                                                                            <span class="hkcatbtn" data-cat="Teşekkürler">Teşekkürler</span>
                                                                            <span class="hkcatbtn" data-cat="Yeni Bebek">Yeni Bebek</span>
                                                                            <span class="hkcatbtn" data-cat="Yeni İş">Yeni İş</span>
                                                                            <span class="hkcatbtn" data-cat="Yılbaşı">Yılbaşı</span>
                                                                            <span class="hkcatbtn" data-cat="Yıldönümü">Yıldönümü</span>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <textarea name="ctl00$MainContent$sepet_sepet1$lstCart$ctl02$kartnotTextBox1" rows="3" cols="20" maxlength="500" id="kartnotTextBox1" class="kn86925" placeholder="{{ __('Your Card Note') }}" style="margin-bottom:0px;border-radius: 0;  "></textarea>
                                                                        <br>
                                                                        <input name="ctl00$MainContent$sepet_sepet1$lstCart$ctl02$kartadTextBox1" type="text" maxlength="150" id="kartadTextBox1" class="kartad86925 kartad" placeholder="{{ __('Sender Name') }}">
                                                                        <br>
                                                                        <input id="kartadCheckBox86925" class="kartadCheckBox" name="kartadCheckBox86925" type="checkbox" data-id="86925">
                                                                        <label style=" margin-top: 10px; line-height: 25px;" for="kartadCheckBox86925">{{ __('Send Anonymous') }}</label>
                                                                        <br>
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer" style="text-align:center;">
                                                                <input type="button" value="Ekle" id="hmesajeklebtn2" class="btn green sepeteklebtn" style="width: 100%; max-width: 400px; display: none;">
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
                                    <a href="/additionalgifts">
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
                                <div class="mt-3 mb-5"> @include('plugins/ecommerce::themes.discounts.partials.form') </div>
                                <hr>
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
