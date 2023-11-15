<div class="banner-img style-6 wow animate__animated animate__fadeInUp {{ $class ?? '' }}" @if (!empty($loop)) data-wow-delay="{{ $loop->iteration * 2 / 10 }}" @endif>
    {!! AdsManager::displayAds($ads->key) !!}
    <div class="banner-text">
        <p class="mb-10 mt-30 font-heading h6">{!! BaseHelper::clean(nl2br($ads->getMetaData('subtitle', true) ?: '')) !!}</p>
        @if ($buttonText = $ads->getMetaData('button_text', true))
            @if ($ads->url)
                <a href="{{ route('public.ads-click', $ads->key) }}" class="btn btn-xs">
                    {{ $buttonText }} <i class="fi-rs-arrow-small-right"></i>
                </a>
            @else
                <p>{{ $buttonText }}</p>
            @endif
        @endif
    </div>
</div>
