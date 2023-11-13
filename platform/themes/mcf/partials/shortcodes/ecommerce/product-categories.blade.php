<section class="popular-categories section-padding" id="product-categories">
    <div class="container">
        <div class="section-title">
            <div class="title">
                <h3>{{ $shortcode->title }}</h3>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carousel-8-columns-arrow" id="carousel-8-columns-arrows"></div>
        </div>
        <div class="carousel-8-columns-cover position-relative">
            <div class="carousel-slider-wrapper carousel-8-columns" id="carousel-8-columns" data-items-xxl="{{ (int)$shortcode->scroll_items > 0 ? (int)$shortcode->scroll_items : 8 }}" :title="'{!! BaseHelper::clean($shortcode->title) !!}'"slick_config="{{ json_encode([
                'autoplay' => $shortcode->is_autoplay == 'yes',
                'infinite' => $shortcode->infinite == 'yes' || $shortcode->is_infinite == 'yes',
                'autoplaySpeed' => (int)(in_array($shortcode->autoplay_speed, theme_get_autoplay_speed_options()) ? $shortcode->autoplay_speed : 3000),
                'speed' => 800,
        ]) }}" data-items-xl="6" data-items-lg="4" data-items-md="3" data-items-sm="2">
                @foreach($categories as $category)
                    <div class="card-1">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="{{ $category->url }}"><img src="{{ RvMedia::getImageUrl($category->getMetaData('icon_image', true), null, false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}" /></a>
                        </figure>
                        <p class="font-heading h6"><a href="{{ $category->url }}" title="{{ $category->name }}">{{ $category->name }}</a></p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
