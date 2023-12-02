<html>
    <head>        
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/additionalgifts.css') }}">
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
                        <img src="https://www.ribbonflowers.com/ikonlar/sepet3.png">
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
                                                    <span class="sepettitle" style="text-align:center;">{{ __('Additional Gifts') }}</span>
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
                                                    <div class="ekuruneklebtn">
                                                        <span class="modal-title" id="modal-title3" style="font-weight:bold;">{{ __('Would You Like to Send Additional Gifts?')}}</span>
                                                        <div aaaa="max-height:100%;max-height: 60vh;overflow-y: auto;">
                                                            <div class="ekcatdivTABLE">
                                                                <div class="ekcatdiv ekcatdivACTIVE" catid="0"> TÜMÜ </div>
                                                                <div class="ekcatdiv" catid="1458"> NOT KARTI </div>
                                                                <div class="ekcatdiv" catid="1460"> BALON </div>
                                                                <div class="ekcatdiv" catid="1463"> FOTOĞRAF </div>
                                                                <div class="ekcatdiv" catid="1461"> AYICIK </div>
                                                                <div class="ekcatdiv" catid="1459"> ÇİKOLATA </div>
                                                                <div class="ekcatdiv" catid="1462"> MUM </div>
                                                                <div class="ekcatdiv" catid="1464"> HEDİYE KUTULARI </div>
                                                                <div class="ekcatdiv" catid="1465"> VAZO VE ÇANTA </div>
                                                            </div>
                                                            <div class="products product-list">
                                                                <a hids="-1459-" pid="86925" code="D518355" pr="1984" urunad="Canım Öğretmenim Pembe Çikolata Mini Tepsi" urunkod="P-1984" urunurl="canim-ogretmenim-pembe-cikolata-mini-tepsi" urunfiyat="1495,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/17214_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>Canım Öğretmenim Pembe Çikolata Mini Tepsi </b>
                                                                        <div style="margin-top:10px;">1495,00 TL</div>
                                                                    </div>
                                                                </a>
                                                                <a hids="" pid="86925" code="D518355" pr="1991" urunad="Canım Öğretmenim Mum Çikolata Hediye Kutusu" urunkod="P-1991" urunurl="canim-ogretmenim-mum-cikolata-hediye-kutusu" urunfiyat="3195,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/17249_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>Canım Öğretmenim Mum Çikolata Hediye Kutusu </b>
                                                                        <div style="margin-top:10px;">3195,00 TL</div>
                                                                    </div>
                                                                </a>
                                                                <a hids="" pid="86925" code="D518355" pr="1977" urunad="Canım Öğretmenim Kişiye Özel Polaroid Fotoğraflı Hediye Kutusu" urunkod="P-1977" urunurl="canim-ogretmenim-kisiye-ozel-polaroid-fotografli-hediye-kutusu" urunfiyat="3395,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/17198_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>Canım Öğretmenim Kişiye Özel Polaroid Fotoğraflı Hediye Kutusu </b>
                                                                        <div style="margin-top:10px;">3395,00 TL</div>
                                                                    </div>
                                                                </a>
                                                                <a hids="" pid="86925" code="D518355" pr="1976" urunad="The Best Teacher Cappucino Çikolata Hediye Kutusu" urunkod="P-1976" urunurl="the-best-teacher-cappucino-cikolata-hediye-kutusu" urunfiyat="3295,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/17184_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>The Best Teacher Cappucino Çikolata Hediye Kutusu </b>
                                                                        <div style="margin-top:10px;">3295,00 TL</div>
                                                                    </div>
                                                                </a>
                                                                <a hids="" pid="86925" code="D518355" pr="678" urunad="Canım Öğretmenim Turuncu Çikolata Hediye Kutusu" urunkod="P-678" urunurl="turuncu-kisiye-ozel-fotografli-canim-ogretmenim-hediye-kutusu" urunfiyat="3295,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/10373_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>Canım Öğretmenim Turuncu Çikolata Hediye Kutusu </b>
                                                                        <div style="margin-top:10px;">3295,00 TL</div>
                                                                    </div>
                                                                </a>
                                                                <a hids="" pid="86925" code="D518355" pr="677" urunad="Canım Öğretmenim Pembe Hediye Kutusu" urunkod="P-677" urunurl="pembe-kisiye-ozel-fotografli-canim-ogretmenim-hediye-kutusu" urunfiyat="3295,00" class="product EKURUNDIV">
                                                                    <div class="ekloading">
                                                                        
                                                                    </div>
                                                                    <div class="product_resimdiv">
                                                                        <img class="resimX" src="https://cdn.ikost.com/3020/urunler/10347_500.jpg">
                                                                    </div>
                                                                    <div style="padding: 15px 0;text-align: left;">
                                                                        <b>Canım Öğretmenim Pembe Hediye Kutusu </b>
                                                                        <div style="margin-top:10px;">3295,00 TL</div>
                                                                    </div>
                                                                </a>
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
                                    <a href="/delivery">
                                        <u>{{ __('Back to Delivery') }}</u>
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
                                <a href="/messagecard" class="btn green sonrakibuton">{{ __('Continue') }}</a>
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
