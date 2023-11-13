@if ($flashSales && $flashSales->count())
    <section class="section-padding pb-5">
        <div class="container">
            <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="0">
                <h3>{!! BaseHelper::clean($shortcode->title) !!}</h3>
            </div>
            <div class="row justify-content-center">
                @foreach ($flashSales as $flashSale)
                    @foreach ($flashSale->products as $product)
                        <div class="col-xxl-3 col-xl-4 col-lg col-md-6">
                            {!! Theme::partial('flash-sale-product', compact('product', 'flashSale')) !!}
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
@endif
@if ($flashSalePopup && $flashSalePopup->products->count())
    @php
        $product = $flashSalePopup->products->random();
        $flashSalePopup->load('metadata');
    @endphp

    <div class="modal fade custom-modal" id="flash-sale-modal" data-id="flash-sale-id-{{ $flashSalePopup->id }}" tabindex="-1" aria-labelledby="onloadModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="deal" style="background-image: url({{ RvMedia::getImageUrl($flashSalePopup->getMetaData('image', true), null, false, RvMedia::getDefaultImage()) }}) !important;">
                        <div class="deal-top">
                            <p class="mb-10 text-brand-2 font-heading h6">{{ $flashSalePopup->name }}</p>
                        </div>
                        <div class="deal-content detail-info">
                            <h4 class="product-title"><a href="{{ $product->url }}" class="text-heading">{!! BaseHelper::clean($product->name) !!}</a></h4>
                            <div class="clearfix product-price-cover">
                                <div class="product-price primary-color float-left">
                                    <span class="current-price text-brand">{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                    <span>
                                        @if ($product->front_sale_price !== $product->price)
                                            <span class="save-price font-md color3 ml-15">{{ __(':percent% Off', ['percent' => get_sale_percentage($product->price, $product->front_sale_price)]) }}</span>
                                            <span class="old-price font-md ml-15">{{ format_price($product->price_with_taxes) }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="deal-bottom">
                            <p class="mb-20">{{ __('Hurry Up! Offer End In:') }}</p>
                            <div class="deals-countdown pl-5" data-countdown="{{ $flashSalePopup->end_date }}">
                            </div>
                            <div class="product-detail-rating">
                                @if (EcommerceHelper::isReviewEnabled() && $product->reviews_count)
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted">({{ $product->reviews_count }})</span>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ $product->url }}" class="btn hover-up">{{ __('Shop Now') }} <i class="fi-rs-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
