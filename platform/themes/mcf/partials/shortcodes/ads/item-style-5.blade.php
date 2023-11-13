<div class="banner-img style-5 mt-5 mt-md-30">
    <img src="{{ RvMedia::getImageUrl($ads->image) }}" alt="{{ $ads->name }}">
    <div class="banner-text">
        <h5 class="mb-20">{!! BaseHelper::clean(nl2br($ads->getMetaData('subtitle', true) ?: '')) !!}</h5>
        @if ($buttonText = $ads->getMetaData('button_text', true))
            <a href="{{ route('public.ads-click', $ads->key) }}" class="btn btn-xs">
                {{ $buttonText }} <i class="fi-rs-arrow-small-right"></i>
            </a>
        @endif
    </div>
</div>
