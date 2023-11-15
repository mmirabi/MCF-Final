<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <div class="title">
                <h3>{{ $shortcode->title }}</h3>
            </div>
        </div>
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
