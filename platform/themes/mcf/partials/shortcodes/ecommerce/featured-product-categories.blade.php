<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>{{ BaseHelper::clean($shortcode->title) }}</h3>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carousel-10-columns-arrow" id="carousel-10-columns-arrows"></div>
        </div>
        <div class="carousel-10-columns-cover position-relative">
            <div class="carousel-slider-wrapper carousel-10-columns" id="carousel-10-columns" data-items-xxl="{{ (int)$shortcode->scroll_items > 0 ? (int)$shortcode->scroll_items : 10 }}" title="{{ $shortcode->title }}"
                 slick_config="{{ json_encode([
                'autoplay' => $shortcode->is_autoplay == 'yes',
                'infinite' => $shortcode->infinite == 'yes' || $shortcode->is_infinite == 'yes',
                'autoplaySpeed' => (int)(in_array($shortcode->autoplay_speed, theme_get_autoplay_speed_options()) ? $shortcode->autoplay_speed : 3000),
                'speed' => 800,
        ]) }}" data-items-xl="6" data-items-lg="4" data-items-md="3" data-items-sm="2">
               @foreach($categories as $category)
                    <div class="card-2 wow animate__animated animate__fadeInUp"
                         data-wow-delay="{{ ($loop->index + 1) / 10 }}s"
                         style="{{ $category->getMetaData('background_color', true) ? 'background-color:' . $category->getMetaData('background_color', true) : '' }}">
                        <figure class="img-hover-scale overflow-hidden">
                            <a href="{{ $category->url }}"><img src="{{ RvMedia::getImageUrl($category->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}" /></a>
                        </figure>
                        <p class="heading-card"><a href="{{ $category->url }}" title="{{ $category->name }}">{{ $category->name }}</a></p>
                        <span>{{ __(':count items', ['count' => $category->products_count]) }}</span>
                    </div>
               @endforeach
            </div>
        </div>
    </div>
</section>
