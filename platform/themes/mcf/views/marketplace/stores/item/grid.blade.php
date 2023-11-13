<div class="col-lg-3 col-md-6 col-12 col-sm-6">
    <div class="vendor-wrap mb-40">
        <div class="vendor-img-action-wrap">
            <div class="vendor-img">
                <a href="{{ $store->url }}">
                    <img class="default-img" src="{{ RvMedia::getImageUrl($store->logo, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $store->name }}" />
                </a>
            </div>
        </div>
        <div class="vendor-content-wrap">
            <div class="d-flex justify-content-between align-items-end mb-30">
                <div class="overflow-hidden">
                    <div class="product-category">
                        <span class="text-muted">{{ __('Since :year', ['year' => $store->created_at->year]) }}</span>
                    </div>
                    <h4 class="mb-5 text-truncate"><a href="{{ $store->url }}">{!! BaseHelper::clean($store->name) !!}</a></h4>
                    <p>({{ __(':total products', ['total' => $store->products_count]) }})</p>
                    @include(Theme::getThemeNamespace('views.marketplace.stores.partials.rating'))
                </div>
            </div>

            <div class="vendor-info mb-30">
                @include(Theme::getThemeNamespace('views.marketplace.stores.partials.info'))
            </div>
            <a href="{{ $store->url }}" class="btn btn-xs">{{ __('Visit Store') }} <i class="fi-rs-arrow-small-right"></i></a>
        </div>
    </div>
</div>
