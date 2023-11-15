<div class="slider-content">
    @if ($slider->title)
        <h1 class="display-2 mb-40">
            {!! BaseHelper::clean($slider->title) !!}
        </h1>
    @endif
    @if ($slider->description)
        <p class="mb-65">{!! BaseHelper::clean($slider->description) !!}</p>
    @endif
    @if ($shortcode->show_newsletter_form == 'yes' && is_plugin_active('newsletter'))
        <div class="newsletter">
            {!! Theme::partial('newsletter-form') !!}
        </div>
    @endif
</div>
