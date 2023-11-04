<div class="banner-img style-4 mt-30">
    <img src="{{ RvMedia::getImageUrl($ads->image) }}" alt="{{ $ads->name }}">
    <div class="banner-text">
        <h4 class="mb-30">{!! BaseHelper::clean(nl2br($ads->getMetaData('subtitle', true) ?: '')) !!}</h4>
        @if ($buttonText = $ads->getMetaData('button_text', true))
            <a href="{{ route('public.ads-click', $ads->key) }}" class="btn btn-xs">
                {{ $buttonText }} <i class="fi-rs-arrow-small-right"></i>
            </a>
        @endif
    </div>
</div>
