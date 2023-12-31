<head>
<link rel="stylesheet" href="{{ Theme::asset()->url('css/delivery.css') }}">
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
                        <img src="{{ Theme::asset()->url('imgs/theme/cart/additional_gifts.png') }}">
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
                                                    <span class="sepettitle" style="text-align:center;">{{ __('Delivery address') }}</span>
                                                </th>
                                            </tr>
                                            @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                                @php
                                                    $product = $products->find($cartItem->id);
                                                @endphp
                                            <tr>
                                                @if(session('success'))
                                                    <div class="alert alert-success">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                                <td>
                                                    <div class="">
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
                                                                                {{ $cartItem->getShippingRule()->name_item }}
                                                                                <br>
                                                                                {{ $cartItem->shipping_date }} {{ $cartItem->shipping_time }}
                                                                            </b>
                                                                        </div>
                                                                    </p>
                                                                </div>
                                                                <div class="col col-lg-2">
                                                                    <span class="d-inline-block price-delivery">{{ format_price($cartItem->price) }}</span> @if ($product->front_sale_price != $product->price)
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
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="adreseklebtn2">
                                                        @if($cartItem->recipient_name)
                                                            <div class="d-flex justify-content-between">
                                                                <div style="padding-right:20px;">
                                                                    <span>{{ __('Delivery') }}:</span>
                                                                    <b>{{ $cartItem->recipient_name }}, </b>
                                                                    <b>{{ $cartItem->recipient_phone }}, </b>
                                                                    <b>{{ $cartItem->recipient_address }}</b>
                                                                </div>
                                                                <div><i class="fi-rs-edit-alt" data-bs-toggle="modal" data-bs-target="#shipping-modal-{{ $cartItem->rowId }}"></i></div>
                                                            </div>
                                                        @else
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-primary address-add" data-bs-toggle="modal" data-bs-target="#shipping-modal-{{ $cartItem->rowId }}"><i class="fi-rs-plus" style="margin-right: 10px;"></i>{{ __('Complete Address Details') }}</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal fade kartbilgi2 shipping-modals" data-action="{{ route('public.ajax.cart.update') }}" data-row="{{ $cartItem->rowId }}" id="shipping-modal-{{ $cartItem->rowId }}" tabindex="-1" aria-labelledby="shipping-modal-{{ $cartItem->rowId }}-label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="shipping-modal-{{ $cartItem->rowId }}-label">Alıcının Adres Detayları</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="adresformdiv">
                                                                        <div id="adresgereklidiv" class="adreZZ adresgereklidiv">

                                                                            <div class="mb-3">
                                                                                <input type="text" placeholder="Alıcı Adı Soyadı" required id="recipient-name-{{ $cartItem->rowId }}" name="recipient_name" value="{{ $cartItem->recipient_name }}">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <input type="text" placeholder="Alıcı Telefonu" required id="recipient-phone-{{ $cartItem->rowId }}" name="recipient_phone" value="{{ $cartItem->recipient_phone }}">
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <textarea required style="height: 100px" id="recipient_address-{{ $cartItem->rowId }}" name="recipient_address" rows="5" placeholder="Alıcının sokak, cadde, kapı no ve diğer bilgilerini buraya giriniz.">{{ $cartItem->recipient_address }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn green sepeteklebtn submitbtn">{{ __('Submit') }}</button>
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
                                <script>
                                    setTimeout(function() {
                                        $('.shipping-modals').each(function () {
                                            var _self = $(this)
                                            _self.find('.submitbtn').click(function () {
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
                                                                    recipient_name: _self.find('[name=recipient_name]').val(),
                                                                    recipient_phone: _self.find('[name=recipient_phone]').val(),
                                                                    recipient_address: _self.find('[name=recipient_address]').val(),
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
                                                        window.location.reload()
                                                    },
                                                    error: (response) => {
                                                        window.showAlert('alert-danger', response.message)
                                                    },
                                                })
                                            })
                                        })
                                        $('[data-remove]').each(function () {
                                            $.ajax({
                                                url: _self.data('url'),
                                                method: 'POST',
                                                data: {
                                                    _method: 'DELETE',
                                                },
                                                success: (response) => {

                                                    if (response.error) {
                                                        window.showAlert('alert-danger', response.message)
                                                        _self.closest('.table--cart').removeClass('content-loading')
                                                        return false
                                                    }else if (response.data.next_url !== undefined) {
                                                        window.location.href = response.data.next_url;
                                                    }

                                                    $('.mini-cart-icon span').text(response.data.count)

                                                    if (response.additional) {
                                                        $('.cart-dropdown-panel').html(response.additional.html)
                                                        if (response.additional.cart_content) {
                                                            $('.section--shopping-cart').html(response.additional.cart_content)
                                                        }
                                                    }

                                                },
                                                error: (response) => {
                                                    _self.closest('.table--cart').removeClass('content-loading')
                                                    window.showAlert('alert-danger', response.message)
                                                },
                                            })
                                        })
                                        $('[data-next]').each(function () {
                                            $(this).click(function (e) {
                                                e.preventDefault();
                                                var disabledbtn = false;
                                                $('.shipping-modals').each(function () {
                                                    var _self_modal = $(this);
                                                    [
                                                        _self_modal.find('[name=recipient_name]').val(),
                                                        _self_modal.find('[name=recipient_phone]').val(),
                                                        _self_modal.find('[name=recipient_address]').val()
                                                    ].forEach(function (v) {
                                                        if (!String(v).length) {
                                                            disabledbtn = true;
                                                        }
                                                    })
                                                });
                                                if(disabledbtn)
                                                    window.showAlert('alert-danger', 'Please complete the address details.')
                                                else
                                                    window.location.href = $(this).data('next')
                                            })
                                        })
                                    },1000)
                                </script>
                                <center>
                                    <a href="/products">
                                        <u>{{ __('Back to Shopping') }}</u>
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
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="mt-3 mb-5"> @include('plugins/ecommerce::themes.discounts.partials.form') </div>
                                <hr>
                                <a href="#" data-next="{{ asset('additionalgifts') }}" id="nextpage" class="btn green sonrakibuton">{{ __('Continue') }}</a>
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
                    <a class="btn btn-primary btnmcf" style="padding: 20px;" href="{{ route('public.products') }}" role="button">{{ __('Start shopping') }}</a>
                </div>
            </div>                 
        </div>  
    </div>  
</div>
@endif
