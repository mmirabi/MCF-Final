<section class="product-tabs pt-40 pb-30 wow fadeIn animated">
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($productCollections as $item)
                <li class="nav-item" role="presentation">
                    <button class="{{ $loop->first ? 'nav-link active': 'nav-link' }}" data-url="{{ route('public.ajax.products-by-collection', $item->id) }}?limit={{ $limit }}" type="button" role="tab" aria-controls="product-collections-product" aria-selected="true">{{ $item->name }}</button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content wow fadeIn animated">
            <div class="half-circle-spinner loading-spinner d-none">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
            <div class="tab-pane fade show active" id="product-collections-product" role="tabpanel" aria-labelledby="product-collections-product-tab">
                <div class="row product-grid-{{ $perRow }}">
                    @foreach($products as $product)
                        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-5 mb-sm-5">
                            @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
