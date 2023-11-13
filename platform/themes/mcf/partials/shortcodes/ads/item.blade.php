<div class="banner-img wow animate__animated animate__fadeInUp {{ $class ?? '' }}" @if (!empty($loop)) data-wow-delay="{{ $loop->iteration * 2 / 10 }}" @endif>
    <img src="{{ RvMedia::getImageUrl($ads->image) }}" alt="{{ $ads->name }}">
    <div class="banner-text">
        <h4>{!! BaseHelper::clean(nl2br($ads->getMetaData('subtitle', true) ?: '')) !!}</h4>
        @if ($buttonText = $ads->getMetaData('button_text', true))
            <a href="{{ route('public.ads-click', $ads->key) }}" class="btn btn-xs">
                {{ $buttonText }} <i class="fi-rs-arrow-small-right"></i>
            </a>
        @endif
    </div>
</div>
