<div class="product-cart-wrap style-2 wow animate__animated animate__fadeInUp" data-wow-delay="0">
    <div class="product-img-action-wrap">
        <div class="product-img">
            <a href="{{ $product->url }}">
                <img src="{{ RvMedia::getImageUrl($flashSale->getMetaData('image', true), null, false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" />
            </a>
        </div>
    </div>
    <div class="product-content-wrap">
        <div class="deals-countdown-wrap">
            <div class="deals-countdown" data-countdown="{{ $flashSale->end_date }}"></div>
        </div>
        <div class="deals-content">
            <h2 class="text-truncate"><a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a></h2>
            @if (EcommerceHelper::isReviewEnabled())
                <div class="product-rate-cover">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted">({{ $product->reviews_count }})</span>
                </div>
            @endif
            @if (is_plugin_active('marketplace') && $product->store->id)
                <div>
                    <span class="font-small text-muted">{{ __('Sold By') }} <a href="{{ $product->store->url }}">{!! BaseHelper::clean($product->store->name) !!}</a></span>
                </div>
            @endif
            <div class="product-card-bottom">
                <div class="product-price">
                    <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                    @if ($product->front_sale_price !== $product->price)
                        <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                    @endif
                </div>
                @if (EcommerceHelper::isCartEnabled())
                    <div class="add-cart">
                        <a aria-label="{{ __('Add To Cart') }}"
                            class="action-btn add-to-cart-button add"
                            data-id="{{ $product->id }}"
                            data-url="{{ route('public.ajax.cart.store') }}"
                            href="#">
                            <i class="fi-rs-shopping-cart mr-5"></i> <span class="d-inline-block">{{ __('Add') }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
