<div class="col-lg-6 col-md-6 col-12 col-sm-6">
    <div class="vendor-wrap style-2 mb-40">
        <div class="vendor-img-action-wrap">
            <div class="vendor-img">
                <a href="{{ $store->url }}">
                    <img class="default-img" src="{{ RvMedia::getImageUrl($store->logo, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $store->name }}" />
                </a>
            </div>
            <div class="mt-10">
                <span class="font-small total-product d-block">{{ __(':total products', ['total' => $store->products_count]) }}</span>
            </div>
        </div>
        <div class="vendor-content-wrap">
            <div class="mb-30">
                <div class="product-category">
                    <span class="text-muted">{{ __('Since :year', ['year' => $store->created_at->year]) }}</span>
                </div>
                <h4 class="mb-5"><a href="{{ $store->url }}">{{ $store->name }}</a></h4>

                @include(Theme::getThemeNamespace('views.marketplace.stores.partials.rating'))
                <div class="vendor-info d-flex justify-content-between align-items-end mt-10">
                    @include(Theme::getThemeNamespace('views.marketplace.stores.partials.info'))
                    <a href="{{ $store->url }}" class="btn btn-xs">{{ __('Visit Store') }} <i class="fi-rs-arrow-small-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
