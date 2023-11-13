@if ($products->isNotEmpty())
    <div class="panel__content ">
        <div class="row py-2 mx-0 ">
            @foreach($products as $product)
            <div class="col-12 px-1 px-md-2 py-1 product-cart-wrap border-0 rounded-0">
                <div class="row mx-md-2 gx-md-2 gx-1">
                    <div class="col-xl-2 col-3 product-img-action-wrap mb-0">
                        <div class="product-img product-img-zoom">
                            <a href="{{ $product->url }}">
                                <img class="default-img" src="{{ RvMedia::getImageUrl($product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-9 product__content">
                        <div class="product-content-wrap px-1 px-md-3">
                            <a class="product__title" href="{{ $product->url }}">{!! BaseHelper::clean($product->name) !!}</a>
                            @if (EcommerceHelper::isReviewEnabled() && $product->reviews_avg > 0)
                                <div class="rating_wrap">
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                    </div>
                                    <span class="rating_num">({{ $product->reviews_count }})</span>
                                </div>
                            @endif
                            <div class="product-price">
                                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                @if ($product->front_sale_price !== $product->price)
                                    <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        @if ($products->hasMorePages() && $products->nextPageUrl())
            <div class="col-12 text-center loadmore-container">
                <a class="loadmore position-relative mx-auto pt-1 pb-3" href="{{ $products->withQueryString()->nextPageUrl() }}">
                    <span>{{ __('Load more') }}</span>
                </a>
            </div>
        @endif
    </div>
    <div class="panel__footer text-center">
        <a href="{{ route('public.products', $queries) }}">{{ __('See all results') }}</a>
    </div>
@else
    <div class="panel__content row py-2 mx-0">
        <div class="text-center">{{ __('No products found.') }}</div>
    </div>
@endif
