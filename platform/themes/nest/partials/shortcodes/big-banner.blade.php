<section class="hero-3 position-relative align-items" @if ($shortcode->cover_image) style="background-image: url({{ RvMedia::getImageUrl($shortcode->cover_image) }}) !important;" @endif>
    <h2 class="mb-30 text-center">{{ $shortcode->title }}</h2>
    @if ($shortcode->show_newsletter_form == 'yes' && is_plugin_active('newsletter'))
        {!! Theme::partial('newsletter-form', ['className' => 'mb-30 text-center']) !!}
    @endif
    @if ($shortcode->number_display_featured_categories && is_plugin_active('ecommerce'))
        @php
            $categories = ProductCategoryHelper::getActiveTreeCategories()
                ->where('is_featured', 1)
                ->take((int) $shortcode->number_display_featured_categories);
        @endphp
        @if ($categories->count())
            <ul class="list-inline nav nav-tabs links font-xs text-center">
                @foreach ($categories as $category)
                    <li class="list-inline-item nav-item"><a class="nav-link font-xs" href="{{ $category->url }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        @endif
    @endif
</section>
