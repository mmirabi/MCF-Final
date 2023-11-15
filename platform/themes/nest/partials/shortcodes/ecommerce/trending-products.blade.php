@if ((int) $shortcode->limit)
    @php
        $products = get_trending_products([
            'take'      => (int) $shortcode->limit,
            'with'      => ['slugable'],
        ] + EcommerceHelper::withReviewsParams());
    @endphp
    @if ($products->count())
        <section class="bg-grey-1 section-padding pt-100 pb-80">
            <div class="container">
                <h1 class="mb-80 text-center">{!! BaseHelper::clean($shortcode->title) !!}</h1>
                <div class="row product-grid">
                    @foreach ($products as $product)
                        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'), compact('product'))
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif
