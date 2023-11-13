@if (is_plugin_active('ads') && $config['ads_key'])
    @php
        $ads = AdsManager::getData()->where('key', $config['ads_key'])->first();
    @endphp
    @if ($ads)
    <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
        <img src="{{ RvMedia::getImageUrl($ads->image) }}" alt="{{ $ads->name }}" />
        <div class="banner-text">
            <span>{{ $config['name'] ?: $ads->name }}</span>
            <h4>{!! BaseHelper::clean($ads->getMetaData('subtitle', true)) !!}</h4>
            <a href="{{ route('public.ads-click', $ads->key) }}"  class="btn btn-xs">
                {{ $ads->getMetaData('button_text', true) ?: __('Shop Now') }} <i class="fi-rs-arrow-small-right"></i>
            </a>
        </div>
    </div>
    @endif
@endif
