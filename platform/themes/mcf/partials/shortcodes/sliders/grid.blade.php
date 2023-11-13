<div class="hero-slider-1 dot-style-1 dot-style-1-position-1 {{ $class ?? ''}}">
    @foreach($sliders as $slider)
        @if ($slider->link && !($shortcode->show_newsletter_form == 'yes' && is_plugin_active('newsletter')))
            <a href="{{ url($slider->link) }}">
        @endif

        @php
            $tabletImage = $slider->getMetaData('tablet_image', true) ?: $slider->image;
            $mobileImage = $slider->getMetaData('mobile_image', true) ?: $tabletImage;
        @endphp

        <div class="single-hero-slider single-animation-wrap {{ $itemClass ?? ''}}" style="@if (!$loop->first) display: none; @endif"
         data-original-image="{{ RvMedia::getImageUrl($slider->image, null, false, RvMedia::getDefaultImage()) }}"
         @if ($tabletImage) data-tablet-image="{{ RvMedia::getImageUrl($tabletImage, null, false, RvMedia::getDefaultImage()) }}" @endif
         @if ($mobileImage) data-mobile-image="{{ RvMedia::getImageUrl($mobileImage, null, false, RvMedia::getDefaultImage()) }}" @endif
        >
            {!! Theme::partial('shortcodes.sliders.content', compact('slider', 'shortcode')) !!}
        </div>

        @if ($slider->link && !($shortcode->show_newsletter_form == 'yes' && is_plugin_active('newsletter')))
            </a>
        @endif
    @endforeach
</div>
<div class="slider-arrow hero-slider-1-arrow"></div>
