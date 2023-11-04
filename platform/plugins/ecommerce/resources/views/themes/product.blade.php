<div class="page-content-wrapper">
    {!! Theme::breadcrumb()->render() !!}
    <section
        class="content-page single-product-content"
        id="product-detail-page"
    >
        <div
            class="container"
            id="product-detail"
        >
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                    <div class="product-page-image">
                        <div
                            class="product-image-slider product-image-gallery"
                            id="product-image-gallery"
                            data-pswp-uid="3"
                        >
                            @foreach ($productImages as $img)
                                <div class="item">
                                    <img
                                        data-zoom-image="{{ RvMedia::getImageUrl($img, 'product_detail') }}"
                                        src="{{ RvMedia::getImageUrl($img, 'product_detail') }}"
                                        alt="{{ $product->name }}"
                                    />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="product-image-slider-thumbnails">
                        @foreach ($productImages as $thumb)
                            <div class="item">
                                <img
                                    src="{{ RvMedia::getImageUrl($thumb, 'product') }}"
                                    alt="{{ $product->name }}"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                    <div class="product-page-content">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        @if (EcommerceHelper::isReviewEnabled())
                            <div class="product-rating">
                                <div
                                    class="star-rating"
                                    title="Rated {{ $product->reviews_avg }} out of 5"
                                    itemprop="reviewRating"
                                    itemscope=""
                                    itemtype="https://schema.org/Rating"
                                >
                                    <span style="width: {{ $product->reviews_avg * 20 }}%"></span>
                                </div>
                                <div class="product-rating-count"><a href="#list-reviews">( <span
                                            class="count">{{ $product->reviews_count }}</span>
                                        {{ __('Reviews') }} )</a>
                                </div>
                            </div>
                        @endif
                        <div class="product-price">
                            @if ($product->front_sale_price !== $product->price)
                                <del>{{ format_price($product->front_sale_price) }}</del>
                                <span>
                                    <span
                                        class="product-price-text">{{ format_price($product->front_sale_price) }}</span>
                                </span>
                            @else
                                <span>
                                    <span class="product-price-text">{{ format_price($product->price) }}</span>
                                </span>
                            @endif
                        </div>

                        {!! apply_filters('ecommerce_before_product_description', null, $product) !!}
                        <p
                            class="product-description"
                            id="detail-description"
                        >
                            {!! $product->description !!}
                        </p>
                        {!! apply_filters('ecommerce_after_product_description', null, $product) !!}

                        <div class="text-warning"></div>
                        <div class="row product-filters">
                            @if ($product->variations()->count() > 0)
                                {!! render_product_swatches($product, [
                                    'selected' => $selectedAttrs,
                                ]) !!}
                            @endif
                        </div>
                        <form class="single-variation-wrap" action="{{ route('public.cart.add-to-cart') }}" method="post">
                            @csrf
                            {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null) !!}
                            <input
                                id="hidden-product-is_out_of_stock"
                                name="product_is_out_of_stock"
                                type="hidden"
                                value="{{ $product->isOutOfStock() }}"
                            />
                            <input
                                id="hidden-product-id"
                                name="id"
                                type="hidden"
                                value="{{ $product->id }}"
                            />
                            <div class="product-quantity">
                                <span
                                    class="quantity-btn quantityPlus"
                                    data-value="+"
                                ></span>
                                <input
                                    class="quantity input-lg"
                                    name="qty"
                                    type="number"
                                    value="1"
                                    title="Quantity"
                                    step="1"
                                    min="1"
                                    max="20"
                                />
                                <span
                                    class="quantity-btn quantityMinus"
                                    data-value="-"
                                ></span>
                            </div>
                            <button
                                class="btn btn-lg btn-black"
                                id="btn-add-cart"
                                type="submit"
                            ><i
                                    class="fa fa-shopping-bag"
                                    aria-hidden="true"
                                ></i>{{ __('Add to cart') }}
                            </button>
                        </form>
                        <div class="product-meta">
                            @if ($product->sku)
                                <span>{{ __('SKU') }} : <span
                                        class="sku"
                                        id="product-sku"
                                        itemprop="sku"
                                    >{{ $product->sku }}</span></span>
                            @endif
                            <span>
                                <span
                                    id="is-out-of-stock">{{ !$product->isOutOfStock() ? __('In stock') : __('Out of stock') }}</span>
                            </span>

                            @if (!$product->categories->isEmpty())
                                <span>{{ __('Categories') }} :
                                    @foreach ($product->categories as $category)
                                        <a href="{{ $category->url }}"> {{ $category->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        </a>
                                    @endforeach
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tabs-wrapper container">
            <ul
                class="product-content-tabs nav nav-tabs"
                role="tablist"
            >

                <li class="nav-item">
                    <a
                        class="active"
                        data-bs-toggle="tab"
                        href="#tab_description"
                        role="tab"
                    >{{ __('Description') }}</a>
                </li>
                <li class="nav-item">
                    <a
                        class=""
                        data-bs-toggle="tab"
                        href="#tab_additional_information"
                        role="tab"
                    >{{ theme_option('product-bonus-title') }}</a>
                </li>
                @if (EcommerceHelper::isReviewEnabled())
                    <li class="nav-item">
                        <a
                            class=""
                            data-bs-toggle="tab"
                            href="#tab_reviews"
                            role="tab"
                        >{{ __('Reviews') }}
                            (<span> {{ $product->reviews_count }}</span>)</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a
                        class=""
                        data-bs-toggle="tab"
                        href="#tab_more_products"
                        role="tab"
                    >{{ __('Related products') }}</a>
                </li>

            </ul>
            <div class="product-content-tabs-wrapper tab-content container">
                <div
                    class="tab-pane fade in active"
                    id="tab_description"
                    role="tabpanel"
                >
                    <h6
                        class="product-collapse-title"
                        data-bs-toggle="collapse"
                        data-bs-target="#tab_description-coll"
                    >
                        {{ __('Description') }}</h6>
                    <div
                        class="shop_description product-collapse collapse container"
                        id="tab_description-coll"
                    >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ck-content">
                                    {!! BaseHelper::clean($product->content) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="tab-pane fade"
                    id="tab_additional_information"
                    role="tabpanel"
                >
                    <h6
                        class="product-collapse-title"
                        data-bs-toggle="collapse"
                        data-bs-target="#tab_additional_information-coll"
                    >{{ theme_option('product-bonus-title') }}</h6>
                    <div
                        class="container product-collapse collapse"
                        id="tab_additional_information-coll"
                    >

                        {!! theme_option('product-bonus') !!}

                    </div>
                </div>

                @if (EcommerceHelper::isReviewEnabled())
                    <div
                        class="tab-pane fade"
                        id="tab_reviews"
                        role="tabpanel"
                    >
                        <h6
                            class="product-collapse-title"
                            data-bs-toggle="collapse"
                            data-bs-target="#tab_reviews-coll"
                        >{{ __('Reviews') }}
                            ({{ $product->reviews_count }})
                        </h6>
                    </div>
                @endif

                <div
                    class="tab-pane fade"
                    id="tab_more_products"
                    role="tabpanel"
                >
                    <div class="row">
                        @php
                            $crossSaleProducts = get_cross_sale_products($product);
                        @endphp

                        @if ($crossSaleProducts->isNotEmpty())

                            <div class="container product-carousel">
                                <div
                                    class="product-item-4 owl-carousel owl-theme nf-carousel-theme"
                                    id="new-trending"
                                >
                                    @foreach ($crossSaleProducts as $crossSaleProduct)
                                        @include('plugins/ecommerce::themes.includes.default-product', [
                                            'product' => $crossSaleProduct,
                                        ])
                                    @endforeach
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        </div>

        @php
            $relatedProducts = get_related_products($product);
        @endphp

        @if ($relatedProducts->isNotEmpty())
            <div class="container product-carousel">
                <h2 class="page-title">{{ __('Related products') }}</h2>
                <div
                    class="product-item-4 owl-carousel owl-theme nf-carousel-theme1"
                    id="new-trending"
                >
                    @foreach ($relatedProducts as $related)
                        @include('plugins/ecommerce::themes.includes.default-product', [
                            'product' => $related,
                        ])
                    @endforeach

                </div>
            </div>

        @endif
    </section>
</div>
