<div class="mb-80 mt-50 section--shopping-cart">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <h1 class="heading-2 mb-10">{{ __('Your Cart') }}</h1>
            <div class="d-flex justify-content-between">
                @if (count($products) > 0)
                    <p class="text-body font-heading h6">{!! BaseHelper::clean(__('There are :total products in your cart', ['total' => '<span class="text-brand">' . count($products) . '</span>'])) !!}</p>
                @endif
            </div>
        </div>
    </div>
    <form method="post" action="{{ route('public.ajax.cart.update') }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                @if (count($products) > 0)
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist table--cart">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col" colspan="2" class="start pl-30">{{ __('Product') }}</th>
                                    <th scope="col">{{ __('Unit Price') }}</th>
                                    <th scope="col">{{ __('Quantity') }}</th>
                                    <th scope="col">{{ __('Subtotal') }}</th>
                                    <th scope="col" class="end">{{ __('Remove') }}</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                                    @if ($product = $products->find($cartItem->id))
                                        <tr class="pt-30">
                                            <td class="image product-thumbnail pt-40">
                                                <input type="hidden" name="items[{{ $key }}][rowId]" value="{{ $cartItem->rowId }}">
                                                <img src="{{ RvMedia::getImageUrl($cartItem->options['image'], 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->original_product->name }}" />
                                            </td>
                                            <td class="product-des product-name">
                                                <p class="mb-5 font-heading h6">
                                                    <a class="product-name mb-10 text-heading" href="{{ $product->original_product->url }}">{{ $product->original_product->name }}  @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</a>
                                                </p>
                                                @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                                                    <p class="d-block mb-0 sold-by">
                                                        <small>
                                                            <span>{{ __('Sold by') }}: </span>
                                                            <a href="{{ $product->original_product->store->url }}">{{ $product->original_product->store->name }}</a>
                                                        </small>
                                                    </p>
                                                @endif
                                                <p class="mb-0">
                                                    <small>{{ Arr::get($cartItem->options, 'attributes') }}</small>
                                                </p>

                                                @if (!empty($cartItem->options['options']))
                                                    {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
                                                @endif

                                                @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                                    @foreach($cartItem->options['extras'] as $option)
                                                        @if (!empty($option['key']) && !empty($option['value']))
                                                            <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @if (EcommerceHelper::isReviewEnabled() && $product->reviews_count)
                                                    <div class="product-rate-cover">
                                                        <div class="product-rate d-inline-block">
                                                            <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                                        </div>
                                                        <span class="font-small ml-5 text-muted">({{ $product->reviews_count }})</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="price" data-title="{{ __('Price') }}">
                                                <h4 class="text-body">{{ format_price($cartItem->price) }} </h4>
                                                @if ($product->front_sale_price != $product->price)
                                                    <small><del>{{ format_price($product->price) }}</del></small>
                                                @endif
                                            </td>
                                            <td class="text-center detail-info" data-title="{{ __('Stock') }}">
                                                <div class="detail-extralink mr-15">
                                                    <div class="detail-qty border radius m-auto">
                                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                        <input type="number" min="1" value="{{ $cartItem->qty }}" name="items[{{ $key }}][values][qty]" class="qty-val qty-input" />
                                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price" data-title="{{ __('Price') }}">
                                                <h4 class="text-brand">{{ format_price($cartItem->price * $cartItem->qty) }} </h4>
                                            </td>
                                            <td class="action text-center" data-title="{{ __('Remove') }}">
                                                <a href="#" class="text-body remove-cart-button" data-url="{{ route('public.ajax.cart.destroy', $cartItem->rowId) }}"><i class="fi-rs-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between">
                        <a class="btn " href="{{ route('public.products') }}"><i class="fi-rs-arrow-left mr-10"></i>{{ __('Continue Shopping') }}</a>
                    </div>
                    <div class="row mt-50">
                        @if (Cart::instance('cart')->count() > 0)
                            <div class="col-lg-7">
                                <div class="p-40">
                                    <h4 class="mb-10">{{ __('Apply Coupon') }}</h4>
                                    <p class="mb-30"><span class="font-lg text-muted">{{ __('Using A Promo Code?') }}</p>
                                    <div class="d-flex justify-content-between form-coupon-wrapper">
                                        <input class="font-medium mr-15 coupon coupon-code" type="text" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="{{ __('Enter Your Coupon') }}">
                                        <button class="btn btn-apply-coupon-code" type="button" data-url="{{ route('public.coupon.apply') }}"><i class="fi-rs-label mr-10"></i>{{ __('Apply') }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-center">{{ __('Your cart is empty!') }}</p>
                @endif
            </div>
            @if (Cart::instance('cart')->count() > 0)
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody class="border-0">
                                    @if (EcommerceHelper::isTaxEnabled())
                                        <tr>
                                            <td class="cart_total_label">
                                                <p class="h6">{{ __('Tax') }}</p>
                                            </td>
                                            <td class="cart_total_amount">
                                                <strong>
                                                    <p class="text-brand text-end">{{ format_price(Cart::instance('cart')->rawTax()) }}</p>
                                                </strong>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($couponDiscountAmount > 0 && session('applied_coupon_code'))
                                        <tr>
                                            <td class="cart_total_label">
                                                <p class="h6">{{ __('Coupon code: :code', ['code' => session('applied_coupon_code')]) }} (<small><a class="btn-remove-coupon-code text-danger" data-url="{{ route('public.coupon.remove') }}" href="javascript:void(0)" data-processing-text="{{ __('Removing...') }}">{{ __('Remove') }}</a></small>)</p>
                                            </td>
                                            <td class="cart_total_amount">
                                                <strong>
                                                    <p class="text-brand text-end">{{ format_price($couponDiscountAmount) }}</p>
                                                </strong>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($promotionDiscountAmount)
                                        <tr>
                                            <td class="cart_total_label">
                                                <p class="h6">{{ __('Discount promotion') }}</p>
                                            </td>
                                            <td class="cart_total_amount">
                                                <strong>
                                                    <p class="text-brand text-end">{{ format_price($promotionDiscountAmount) }}</p>
                                                </strong>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="cart_total_label">
                                            <p class="h6">{{ __('Total') }}</p>
                                            <small>({{ __('Shipping fees not included') }})</small>
                                        </td>
                                        <td class="cart_total_amount">
                                            <strong>
                                                <h4 class="text-brand text-end">{{ ($promotionDiscountAmount + $couponDiscountAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }}</h4>
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}" class="btn mb-20 w-100">{{ __('Proceed To Checkout') }} <i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

@if (count($crossSellProducts) > 0)
    <div class="mt-60">
        <h3 class="section-title style-1 mb-30">{{ __('You may also like') }}</h3>

        <div class="row">
            @foreach($crossSellProducts as $crossProduct)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', ['product' => $crossProduct])
                </div>
            @endforeach
        </div>
    </div>
@endif
