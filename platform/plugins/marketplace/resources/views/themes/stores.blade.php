<div class="container">
    <h3>{{ __('Our Stores') }}</h3>

    <div class="row">
        @foreach ($stores as $store)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <a href="{{ $store->url }}">
                    <img
                        src="{{ RvMedia::getImageUrl($store->logo, null, false, RvMedia::getDefaultImage()) }}"
                        alt="{{ $store->name }}"
                    >
                    <h4>{{ $store->name }}</h4>
                </a>
                @if (EcommerceHelper::isReviewEnabled())
                    <p>{{ $store->reviews->count() }} reviews</p>
                @endif
                <p>{{ $store->full_address }}</p>
                @if (!MarketplaceHelper::hideStorePhoneNumber() && $store->phone)
                    <p>{{ $store->phone }}</p>
                @endif
                @if (!MarketplaceHelper::hideStoreEmail() && $store->email)
                    <p><a href="mailto:{{ $store->email }}">{{ $store->email }}</a></p>
                @endif
            </div>
        @endforeach
    </div>

    {!! $stores->withQueryString()->links() !!}
</div>
