<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <div class="title">
                <h3>{!! BaseHelper::clean($shortcode->title) !!}</h3>
            </div>
        </div>
        <div class="row product-grid-{{ (int)$shortcode->per_row > 0 ? (int)$shortcode->per_row : 4 }}">
            @foreach($products as $product)
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-5 mb-sm-5">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
                </div>
            @endforeach
        </div>
    </div>
</section>
