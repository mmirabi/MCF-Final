<section class="section-padding mb-30">
    <div class="container">
        <div class="row">
            @foreach($data as $item)
                <div class="col-xl-{{ (12 / count($data)) }} col-lg-6 col-md-6 mb-md-0">
                    <h4 class="section-title style-1 mb-30 animated animated">{{ $item['title'] }}</h4>
                    <div class="product-list-small animated animated">
                        @foreach($item['products'] as $product)
                            @php
                                if ($product->is_variation) {
                                    $product = $product->original_product;
                                    $product->loadMissing('reviews');
                                    $product->reviews_count = $product->reviews->count();
                                    $product->reviews_avg = $product->reviews->avg('star');
                                }
                            @endphp
                            <article class="row align-items-center hover-up">
                                <figure class="col-md-4 mb-0">
                                    <a href="{{ $product->url }}">
                                        {!! RvMedia::image($product->image, $product->name, 'product-thumb') !!}
                                    </a>
                                </figure>
                                <div class="col-md-8 mb-0">
                                    <p class="text-truncate font-heading h6">
                                        <a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                    </p>

                                    @if(EcommerceHelper::isReviewEnabled() && $product->reviews_count)
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted">({{ $product->reviews_count }})</span>
                                        </div>
                                    @endif

                                    <div class="product-price">
                                        <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                        @if ($product->front_sale_price !== $product->price)
                                            <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
