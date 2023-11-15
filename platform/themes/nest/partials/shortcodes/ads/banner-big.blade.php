<div class="banner-img style-3 animated animated">
    {!! AdsManager::displayAds($ads->key) !!}

    <div class="banner-text mt-50">
        <h2 class="mb-50">{!! BaseHelper::clean(nl2br($ads->getMetaData('subtitle', true))) !!}</h2>
        @if ($buttonText = $ads->getMetaData('button_text', true))
            <a href="{{ route('public.ads-click', $ads->key) }}"  class="btn btn-xs">
                {{ $buttonText }} <i class="fi-rs-arrow-small-right"></i>
            </a>
        @endif
    </div>
</div>
