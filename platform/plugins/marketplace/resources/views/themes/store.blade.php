<div class="container">
    <img
        src="{{ $store->logo_url }}"
        alt="{{ $store->name }}"
    >

    <h3 class="text-white">{{ $store->name }}</h3>

    @if (EcommerceHelper::isReviewEnabled())
        <p>{{ $store->reviews()->count() }} reviews</p>
    @endif

    @if ($store->full_address)
        <p>{{ $store->full_address }}</p>
    @endif
    @if (!MarketplaceHelper::hideStorePhoneNumber() && $store->phone)
        <p>{{ $store->phone }}</p>
    @endif
    @if (!MarketplaceHelper::hideStoreEmail() && $store->email)
        <p><a href="mailto:{{ $store->email }}">{{ $store->email }}</a></p>
    @endif
    <h3>Products</h3>
    @if ($products->isNotEmpty())
        <div class="row">
            @foreach ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6">
                    <a href="{{ $product->url }}">
                        {!! RvMedia::image($product->image, $product->name) !!}
                        <p>{{ $product->name }} - {{ format_price($product->front_sale_price_with_taxes) }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    {!! $products->withQueryString()->links() !!}
</div>
