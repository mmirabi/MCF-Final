<section class="section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <div class="title">
                <h3>{{ $shortcode->title }}</h3>
            </div>
        </div>

        <div class="row vendor-grid">
            @foreach($stores as $store)
                @include(Theme::getThemeNamespace('views.marketplace.stores.item.' . $layout))
            @endforeach
        </div>
    </div>
</section>
