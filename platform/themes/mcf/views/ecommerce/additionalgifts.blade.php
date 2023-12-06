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
                        <div class="table-wrapper-responsive">
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
                                                            <div class="container">
                                                                <div class="row align-items-center">
                                                                    <div class="col col-lg-3">
                                                                        <a href="{{ $product->original_product->rl }}"><img alt="{{ $product->original_product->name }}" src="{{ RvMedia::getImageUrl($cartItem->options['image'], 'thumb', false, RvMedia::getDefaultImage()) }}" class="product-image-delivery"></a>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <span class="sepeturuntitle"><a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}  @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</a></span>
                                                                        <p class="address-medyanossa">
                                                                            @if (!empty($cartItem->options['options']))
                                                                            {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
                                                                            @endif
                                                                            <div class="adreseklebtn2">
                                                                                <b style="padding-right:20px;">
                                                                                    <span>{{ $cartItem->getShippingRule()->name_item }}</span><br>
                                                                                    <span>, {{ $cartItem->shipping_date }}</span>
                                                                                    <span>, {{ $cartItem->shipping_time }}</span>
                                                                                </b>
                                                                            </div>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col col-lg-2">
                                                                        <span class="d-inline-block price-delivery">{{ format_price($cartItem->price) }}</span> @if ($product->front_sale_price != $product->price)
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
                                                        <span class="modal-title" data-show="gifts-{{ $cartItem->id }}" style="font-weight:bold;">{{ __('Would You Like to Send Additional Gifts?')}}</span>
                                                        <div id="gifts-{{ $cartItem->id }}" class="d-none" style="max-height:100%;max-height: 60vh;overflow-y: auto;">
                                                            <div class="ekcatdivTABLE">
                                                                <div class="ekcatdiv ekcatdivACTIVE" data-ccid="{{ $cartItem->id }}" data-catid="0">Tüm</div>
                                                                @foreach(\Botble\Ecommerce\Models\ProductCategory::where('cat_type', 'additional')->get() as $cate_index => $category)
                                                                    <div class="ekcatdiv" data-ccid="{{ $cartItem->id }}" data-catid="{{ $category->id }}">{{ $category->name }}</div>
                                                                @endforeach
                                                            </div>
                                                            <div class="products product-list">
                                                                @foreach(\Botble\Ecommerce\Models\Product::where('product_type', 'additional')->get() as $product)
                                                                    <a class="product EKURUNDIV{{ $cartItem->additional_id == $product->id ? " EKURUNDIVactive" : "" }}"  data-action="{{ route('public.ajax.cart.update') }}" data-row="{{ $cartItem->rowId }}" data-cpid="{{ $cartItem->id }}-{{ $product->id }}" data-pid="{{ $product->id }}" data-cid="{{ $cartItem->id }}" data-catids="{{ implode(',', $product->categories->pluck('id')->toArray()) }}">
                                                                        <div class="ekloading"></div>
                                                                        <div class="product_resimdiv">
                                                                            <img class="resimX" src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                                                        </div>
                                                                        <div style="padding: 15px 0;text-align: left;">
                                                                            <b>{{ $product->name }}</b>
                                                                            <div style="margin-top:10px;">{{ format_price($product->price) }}</div>
                                                                        </div>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <script>
                                    setTimeout(function () {
                                        $('[data-show]').each(function (){
                                            $(this).click(function () {
                                                var _self = $("#" + $(this).data('show'));
                                                if(_self.hasClass('d-none')) {
                                                    _self.removeClass('d-none')
                                                }else {
                                                    _self.addClass('d-none')
                                                }
                                            })
                                        })
                                        $('.ekcatdiv[data-catid]').each(function (){
                                            $(this).click(function () {
                                                var _self = $(this);
                                                var $val = _self.data('catid')
                                                if($(this).hasClass('ekcatdivACTIVE')) {
                                                    $('.ekcatdiv[data-ccid=' + $(this).data('ccid') + ']').removeClass('ekcatdivACTIVE')
                                                    $(this).addClass('ekcatdivACTIVE')
                                                }else {
                                                    $('.ekcatdiv[data-ccid=' + $(this).data('ccid') + ']').removeClass('ekcatdivACTIVE')
                                                    $(this).addClass('ekcatdivACTIVE')
                                                }
                                                $('.product[data-cid=' + _self.data('ccid') + ']').each(function (){
                                                    if($val == 0) {
                                                        $(this).show()
                                                    }else {
                                                        if(String($(this).data('catids')).split(',').indexOf(String($val)) !== -1){
                                                            $(this).show()
                                                        }else {
                                                            $(this).hide()

                                                        }
                                                    }
                                                })
                                            })
                                        })
                                        $('.product[data-cpid]').each(function (){
                                            var _self = $(this);
                                            $(this).click(function () {
                                                if($(this).hasClass('EKURUNDIVactive')) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: _self.data('action'),
                                                        data: {
                                                            _token: $('meta[name=csrf-token]').prop('content'),
                                                            _method: 'PUT',
                                                            items: {
                                                                [_self.data('row')]: {
                                                                    rowId: _self.data('row'),
                                                                    values: {
                                                                        qty: 1,
                                                                        additional_id: null,
                                                                    }
                                                                },
                                                            }
                                                        },
                                                        success: (response) => {
                                                            if (response.error) {
                                                                window.showAlert('alert-danger', response.message)
                                                                return false
                                                            }
                                                            window.showAlert('alert-success', response.message)
                                                            $('.product[data-cid=' + $(this).data('cid') + ']').removeClass('EKURUNDIVactive')
                                                        },
                                                        error: (response) => {
                                                            window.showAlert('alert-danger', response.message)
                                                        },
                                                    })
                                                }else {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: _self.data('action'),
                                                        data: {
                                                            _token: $('meta[name=csrf-token]').prop('content'),
                                                            _method: 'PUT',
                                                            items: {
                                                                [_self.data('row')]: {
                                                                    rowId: _self.data('row'),
                                                                    values: {
                                                                        qty: 1,
                                                                        additional_id: _self.data('pid'),
                                                                    }
                                                                },
                                                            }
                                                        },
                                                        success: (response) => {
                                                            if (response.error) {
                                                                window.showAlert('alert-danger', response.message)
                                                                return false
                                                            }
                                                            window.showAlert('alert-success', response.message)
                                                            $('.product[data-cid=' + $(this).data('cid') + ']').removeClass('EKURUNDIVactive')
                                                            $(this).addClass('EKURUNDIVactive')
                                                        },
                                                        error: (response) => {
                                                            window.showAlert('alert-danger', response.message)
                                                        },
                                                    })
                                                }
                                            })
                                        })
                                    }, 1000)
                                </script>
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
                                                    <p class="price-text sub-total-text text-end">
                                                        {{ format_price($shippingAmount + Cart::instance('cart')->shippingFee()) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-6">
                                                <p>
                                                    <strong>{{ __('Shipping fee') }}</strong>:
                                                </p>
                                            </div>
                                            <div class="col-6 float-end">
                                                <p class="price-text sub-total-text text-end">
                                                    {{ format_price(Cart::instance('cart')->shippingFee()) }}</p>
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
