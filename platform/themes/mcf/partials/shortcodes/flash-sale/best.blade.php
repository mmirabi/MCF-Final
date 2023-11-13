<section class="section-padding pb-5 section-flash-sale-products">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3>{!! BaseHelper::clean($shortcode->title) !!}</h3>
        </div>
        <div class="row">
            @if (is_plugin_active('ads') && $ads = AdsManager::getData()->where('key', $shortcode->ads)->first())
                <div class="col-xl-3 d-none d-xl-flex wow animate__animated animate__fadeIn">
                    <div class="banner-img style-2" @if ($ads->image) style="background-image: url({{ RvMedia::getImageUrl($ads->image) }}) !important;" @endif>
                        <div class="banner-text">
                            <h2 class="mb-100">{{ $ads->name }}</h2>
                            @if ($buttonText = $ads->getMetaData('button_text', true))
                                <a href="{{ route('public.ads-click', $ads->key) }}" class="btn btn-xs">{{ $buttonText }} <i class="fi-rs-arrow-small-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="@if (! empty($ads)) col-xl-9 @endif col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".4s">
                <div class="tab-content" >
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-one-1">
                        <div class="carousel-4-columns-cover arrow-center position-relative">
                            <div class="slider-arrow slider-arrow-2 carousel-4-columns-arrow" id="carousel-4-columns-arrows"></div>
                            <div class="carousel-4-columns carousel-arrow-center" id="carousel-4-columns">
                                @foreach ($flashSalePopup->products as $product)
                                    <div class="product-cart-wrap">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ $product->url }}">
                                                    <img class="default-img" src="{{ RvMedia::getImageUrl($product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                                                    <img class="hover-img" src="{{ RvMedia::getImageUrl($product->images[1] ?? $product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="{{ __('Quick View') }}" href="#" class="action-btn hover-up js-quick-view-button" data-url="{{ route('public.ajax.quick-view', $product->id) }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                                @if (EcommerceHelper::isWishlistEnabled())
                                                    <a aria-label="{{ __('Add To Wishlist') }}" href="#" class="action-btn hover-up js-add-to-wishlist-button" data-url="{{ route('public.wishlist.add', $product->id) }}">
                                                        <i class="fi-rs-heart"></i>
                                                    </a>
                                                @endif
                                                @if (EcommerceHelper::isCompareEnabled())
                                                    <a aria-label="{{ __('Add To Compare') }}" href="#" class="action-btn hover-up js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}">
                                                        <i class="fi-rs-shuffle"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                @if ($product->isOutOfStock())
                                                    <span style="background-color: #000; font-size: 11px;">{{ __('Out Of Stock') }}</span>
                                                @else
                                                    @if ($product->productLabels->count())
                                                        @foreach ($product->productLabels as $label)
                                                            <span @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                                                        @endforeach
                                                    @else
                                                        @if ($product->front_sale_price !== $product->price)
                                                            <span class="hot">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</span>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-content-wrap">
                                            @php $category = $product->categories->sortByDesc('id')->first(); @endphp
                                            @if ($category)
                                                <div class="product-category">
                                                    <a href="{{ $category->url }}">{!! BaseHelper::clean($category->name) !!}</a>
                                                </div>
                                            @endif
                                            <h2 class="text-truncate"><a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a></h2>

                                            {!! Theme::partial('rating-item', ['ratingCount' => $product->reviews_count, 'ratingAvg' => $product->reviews_avg]) !!}

                                            <div class="product-price mt-10">
                                                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                                @if ($product->front_sale_price !== $product->price)
                                                    <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                                                @endif
                                            </div>
                                            <div class="sold mt-15 mb-15">
                                                <div class="progress mb-5">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $product->pivot->quantity > 0 ? ($product->pivot->sold / $product->pivot->quantity) * 100 : 0 }}%" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                @if ($product->pivot->quantity > $product->pivot->sold)
                                                    <span class="font-xs text-heading">{{ __('Sold') }}: {{ (int)$product->pivot->sold }}</span>
                                                @else
                                                    <span class="font-xs text-heading">{{ __('Sold out') }}</span>
                                                @endif
                                            </div>
                                            @if (EcommerceHelper::isCartEnabled())
                                                <a aria-label="{{ __('Add To Cart') }}"
                                                    class="action-btn add-to-cart-button btn w-100 hover-up"
                                                    data-id="{{ $product->id }}"
                                                    data-url="{{ route('public.ajax.cart.store') }}"
                                                    href="#">
                                                    <i class="fi-rs-shopping-cart mr-5"></i>{{ __('Add To Cart') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
