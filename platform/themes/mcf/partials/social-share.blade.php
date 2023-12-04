<div class="single-social-share clearfix mt-50 mb-15">
    <h4 style="margin-bottom:20px;">{{ __('Share') }}</h4>
    <div class="mobile-social-icon wow fadeIn mb-sm-5 mb-md-0 animated">
        <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank">
            <img class="svgInject" src="{{ Theme::asset()->url('imgs/theme/icons/facebook.svg') }}" />
        </a>
        <a class="twitter" href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ strip_tags($description) }}" target="_blank">
            <img class="svgInject" src="{{ Theme::asset()->url('imgs/theme/icons/twitter.svg') }}" />
        </a>
        <a class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($url) }}&summary={{ rawurldecode(strip_tags($description)) }}" target="_blank">
            <img class="svgInject" src="{{ Theme::asset()->url('imgs/theme/icons/linkedin.svg') }}" />
        </a>
        {{-- <a class="mail-to-friend font-sm color-grey" href="mailto:someone@example.com?subject={{ __('Buy :name', ['name' => $product->name]) }}&body={{ __('Buy this one: :link', ['link' => $product->url]) }}" target="_blank">
            <img class="svgInject" src="{{ Theme::asset()->url('imgs/theme/icons/email.svg') }}" />
        </a> --}}
    </div>
</div>
