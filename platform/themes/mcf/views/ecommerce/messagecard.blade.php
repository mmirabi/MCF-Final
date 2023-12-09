<html>
    <head>
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/messagecart.css') }}">
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
                        <img src="{{ Theme::asset()->url('imgs/theme/cart/message_card_active.png') }}">
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
                                                                <div class="col col-lg-3">
                                                                    <a href="{{ $product->original_product->rl }}"><img alt="{{ $product->original_product->name }}" src="{{ RvMedia::getImageUrl($cartItem->options['image'], 'thumb', false, RvMedia::getDefaultImage()) }}" class="product-image-delivery"></a>
                                                                </div>
                                                                <div class="col-6">
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
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="width:100%;">
                                                        <div>
                                                            <div>
                                                                <div class="locabackButton" data-row="{{ $cartItem->rowId }}" style="display: none">
                                                                    <img src="https://www.ribbonflowers.com/ikonlar/leftarrow.png" style="width:24px;">
                                                                </div>
                                                            </div>

                                                            <div class="modal-body kartbilgi2" id="modal-body3" style="padding:0;">
                                                                <div class="kartnotsecdiv" data-row="{{ $cartItem->rowId }}" style="display:none;max-height:100%;max-height: 60vh;overflow-y: auto;">
                                                                    @foreach(\Botble\Ecommerce\Models\MessageCard::all() as $card)
                                                                        <div class="mesajli" data-id="142" data-catids="{{ implode(',', $card->categories->pluck('id')->toArray()) }}" data-carid="{{ $cartItem->id }}" data-row="{{ $cartItem->rowId }}" data-msgid="{{ $card->id }}" data-msg="{{ strip_tags($card->content) }}" style="display:none;">
                                                                            {!! $card->description?:$card->content !!}
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="kartnotformdiv" data-row="{{ $cartItem->rowId }}">
                                                                    <div class="notunuz">{{ __('Your Note') }}</div>
                                                                    <div class="hazirbuton" data-id="86925">
                                                                        <div class="hktitle" data-id="86925">{{ __('Choose from Ready Card Notes') }}</div>
                                                                        <div class="hazirkartcatsdiv hazirkartcatsdiv86925">
                                                                            @foreach(\Botble\Ecommerce\Models\MessageCategory::all() as $category)
                                                                                <span class="hkcatbtn" data-catid="{{ $category->id }}" data-carid="{{ $cartItem->id }}" data-row="{{ $cartItem->rowId }}">{{ $category->name }}</span>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <textarea name="message_text" data-row="{{ $cartItem->rowId }}" rows="3" cols="20" maxlength="500" placeholder="{{ __('Your Card Note') }}" style="margin-bottom:0px;border-radius: 0;  ">{{ $cartItem->message_text }}</textarea>
                                                                        <br>
                                                                        <input name="message_sender" value="{{ $cartItem->message_sender }}" data-row="{{ $cartItem->rowId }}" type="text" maxlength="150" placeholder="{{ __('Sender Name') }}">
                                                                        <br>
                                                                        <input class="kartadCheckBox" name="is_anonymous" type="checkbox" id="kartadCheckBox{{ $cartItem->rowId }}" data-row="{{ $cartItem->rowId }}">
                                                                        <label style=" margin-top: 10px; line-height: 25px;" for="kartadCheckBox{{ $cartItem->rowId }}">{{ __('Send Anonymous') }}</label>
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
                                <script>
                                    function changecart(rowId) {
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ route('public.ajax.cart.update') }}',
                                            data: {
                                                _token: $('meta[name=csrf-token]').prop('content'),
                                                _method: 'PUT',
                                                items: {
                                                    [rowId]: {
                                                        rowId: rowId,
                                                        values: {
                                                            qty: 1,
                                                            message_text:$('[name=message_text][data-row=' + rowId +']').val(),
                                                            message_sender: $('[name=message_sender][data-row=' +rowId +']').val(),
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
                                                //window.location.reload()
                                            },
                                            error: (response) => {
                                                window.showAlert('alert-danger', response.message)
                                            },
                                        })
                                    }
                                    setTimeout(function () {
                                        $('.hkcatbtn').each(function () {
                                            var _self = $(this);
                                            var $val = _self.data('catid')
                                            _self.click(function () {
                                                $('.kartnotformdiv[data-row=' + _self.data('row') +']').hide();
                                                $('.locabackButton[data-row=' + _self.data('row') +']').show();
                                                $('.kartnotsecdiv[data-row=' + _self.data('row') +']').show();
                                                $('.mesajli[data-row=' + _self.data('row') + ']').each(function (){
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
                                        $('.locabackButton').each(function () {
                                            var _self = $(this);
                                            _self.click(function () {
                                                $('.kartnotformdiv[data-row=' + _self.data('row') +']').show();
                                                $('.locabackButton[data-row=' + _self.data('row') +']').hide();
                                                $('.kartnotsecdiv[data-row=' + _self.data('row') +']').hide();
                                            })
                                        })
                                        $('.mesajli').each(function () {
                                            var _self = $(this);
                                            _self.click(function () {
                                                $('.kartnotformdiv[data-row=' + _self.data('row') +']').show();
                                                $('.locabackButton[data-row=' + _self.data('row') +']').hide();
                                                $('.kartnotsecdiv[data-row=' + _self.data('row') +']').hide();
                                                $('[name=message_text][data-row=' + _self.data('row') +']').val(_self.data('msg'));
                                                changecart(_self.data('row'))
                                            })
                                        })
                                        $('[name=is_anonymous]').each(function () {
                                            var _self = $(this);
                                            _self.change(function () {
                                                if (_self.prop('checked')) {
                                                    $('[name=message_sender][data-row=' + _self.data('row') +']').val('');
                                                    $('[name=message_sender][data-row=' + _self.data('row') +']').prop('disabled', true);
                                                }else {
                                                    $('[name=message_sender][data-row=' + _self.data('row') +']').prop('disabled', false);
                                                }
                                                changecart(_self.data('row'))
                                            })
                                        })
                                        $('[name=message_text]').each(function () {
                                            var _self = $(this);
                                            _self.change(function () {
                                                changecart(_self.data('row'))
                                            })
                                        })

                                    }, 1000)
                                </script>
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
