<html>
    <head>
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/additionalgifts.css') }}">
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/checkout.css') }}">
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
                        <img src="{{ Theme::asset()->url('imgs/theme/cart/message_card.png') }}">
                        <br>
                        <span>{{ __('Message Card') }}</span>
                    </div>
                    <div>
                        <img src="{{ Theme::asset()->url('imgs/theme/cart/invoice.png') }}">
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
                                                                    <p class="address-medyanossa">
                                                                        {{ $cartItem->getShippingRule()->name_item }}
                                                                        <br>
                                                                        {{ $cartItem->shipping_date }} {{ $cartItem->shipping_time }}
                                                                    </p>
                                                                    <p></p>
                                                                </div>
                                                                <div class="col col-lg-2">
                                                                    <span><span class="d-inline-block">{{ format_price($cartItem->price) }}</span> @if ($product->front_sale_price != $product->price)
                                                                    <small><del>{{ format_price($product->price) }}</del></small>@endif</h3>
                                                                </div>
                                                                <div class="col col-lg-1">
                                                                    <a href="#" class="text-body"  data-bs-toggle="modal" data-bs-target="#remove-modal-{{ $cartItem->rowId }}"><i class="fi-rs-trash"></i></a>
                                                                </div>
                                                                <div class="modal fade remove-modals" data-row="{{ $cartItem->rowId }}" id="remove-modal-{{ $cartItem->rowId }}" tabindex="-1" aria-labelledby="remove-modal-{{ $cartItem->rowId }}-label" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                    </div>
                                                                    <div class="modal-dialog22">
                                                                        <div class="modal-content22">
                                                                            <div class="modal-content22-ic">
                                                                                <div class="modal-header22">
                                                                                    Emin misiniz?
                                                                                </div>
                                                                                <div class="modal-body22">
                                                                                    Ürünü sepetinizden kaldırmak istediğinizden emin misiniz?
                                                                                </div>
                                                                                <div class="modal-footer22">
                                                                                    <a class="modalbtnlink22" data-bs-dismiss="modal">Vazgeç</a>
                                                                                    <a id="MainContent_sepet_sepet1_lstCart_Linkbutton1_0" class="modalbtnlink22 remove-cart-button" productid="88626" href="javascript:void(0)" data-url="{{ route('public.ajax.cart.destroy', $cartItem->rowId) }}">Sil</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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
                                                        <div id="gifts-{{ $cartItem->id }}" style="max-height:100%;max-height: 60vh;overflow-y: auto;">
                                                            <div class="ekcatdivTABLE">
                                                                <div class="ekcatdiv ekcatdivACTIVE" data-ccid="{{ $cartItem->id }}" data-catid="0">Tüm</div>
                                                                @foreach(\Botble\Ecommerce\Models\ProductCategory::where('cat_type', 'additional')->get() as $cate_index => $category)
                                                                    <div class="ekcatdiv" data-ccid="{{ $cartItem->id }}" data-catid="{{ $category->id }}">{{ $category->name }}</div>
                                                                @endforeach
                                                            </div>
                                                            <div class="products product-list">
                                                                @foreach(\Botble\Ecommerce\Models\Product::where('product_type', 'additional')->get() as $product)
                                                                    <a class="product EKURUNDIV{{ in_array($product->id, $cartItem->additional_ids?:[]) ? " EKURUNDIVactive" : "" }}"  data-action="{{ route('public.ajax.cart.update') }}" data-row="{{ $cartItem->rowId }}" data-cpid="{{ $cartItem->id }}-{{ $product->id }}" data-pid="{{ $product->id }}" data-cid="{{ $cartItem->id }}" data-catids="{{ implode(',', $product->categories->pluck('id')->toArray()) }}">
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
                                            $(this).click(function () {
                                                var _self = $(this);
                                                var additionals = [];
                                                var remove = false;
                                                $('.product.EKURUNDIVactive[data-cid=' + $(this).data('cid') + ']').each(function () {
                                                    if(_self.data('pid') == $(this).data('pid'))
                                                        remove = true;
                                                    else additionals.push($(this).data('pid'))
                                                })
                                                if(remove) {
                                                    _self.removeClass('EKURUNDIVactive')
                                                }else {
                                                    _self.addClass('EKURUNDIVactive')
                                                    additionals.push(_self.data('pid'))
                                                }
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
                                                                    additional_ids: additionals,
                                                                    additional_remove: additionals.length == 0 ? 1 : 0,
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
                                                        $('#subtotal').text(response.data.total_price)
                                                    },
                                                    error: (response) => {
                                                        window.showAlert('alert-danger', response.message)
                                                    },
                                                })
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
                                                    <p class="price-text sub-total-text text-end" id="subtotal">
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
                                                <p class="price-text sub-total-text text-end">
                                                    {{ format_price(Cart::instance('cart')->shippingFee()) }}</p>
                                            </div>
                                        </div>
                                        @endif
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
