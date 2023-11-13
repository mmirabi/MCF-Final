@php
    $coverImage = $store->getMetaData('cover_image', true) ?: theme_option('vendor_cover_default_image');
@endphp
<div class="archive-header-3 mt-30 mb-80 w-full"
    style="background-image: url({{ $coverImage ? RvMedia::getImageUrl($coverImage) : Theme::asset()->url('imgs/vendor/vendor-header-bg.png') }}) !important;">
        <div class='row'>
            <div class='col-lg-7'>
                <div class='row'>
                    <div class="vendor-logo col-3">
                        <img src="{{ RvMedia::getImageUrl($store->logo, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $store->name }}" />
                    </div>
                    <div class="vendor-content col">
                        <div class="product-category">
                            <span class="text-muted">{{ __('Since :year', ['year' => $store->created_at->year]) }}</span>
                        </div>
                        <h3 class="mb-5 text-white"><a href="{{ $store->url }}" class="text-white">{!! BaseHelper::clean($store->name) !!}</a></h3>
                        <div class="mb-15">
                            @include(Theme::getThemeNamespace('views.marketplace.stores.partials.rating'))
                        </div>
                        <div class="mb-15 text-white">
                            @include(Theme::getThemeNamespace('views.marketplace.stores.partials.info'))
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-5 text-lg-end'>
                <div class="vendor-content">
                    @include(Theme::getThemeNamespace('views.marketplace.stores.partials.socials'), ['headerClass' => 'text-white'])
                </div>
            </div>
        </div>
</div>

<div class='row'>
    <div class="col-12 mb-50">
        @php
            $description = BaseHelper::clean($store->description);
            $content = BaseHelper::clean($store->content);
        @endphp

        @if ($description || $content)
            {!! $content ?: $description !!}
        @endif
    </div>
</div>
<div class="row flex-row-reverse">
    <div class="col-lg-4-5 products-listing position-relative">
        @include(Theme::getThemeNamespace('views.marketplace.stores.items'), compact('products'))
    </div>
    <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
        @include(Theme::getThemeNamespace('views.marketplace.stores.partials.sidebar'), ['isShowSearchForm' => true])
    </div>
</div>
