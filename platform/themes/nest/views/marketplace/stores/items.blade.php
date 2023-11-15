<div class="list-content-loading m-0">
    <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
</div>

<input type="hidden" name="page" data-value="{{ $products->currentPage() }}">
<input type="hidden" name="sort-by" value="{{ BaseHelper::stringify(request()->input('sort-by')) }}">
<input type="hidden" name="num" value="{{ BaseHelper::stringify((int)request()->input('num')) }}">

<div class="shop-product-filter">
    <div class="total-product">
        <p>{!! BaseHelper::clean(__('We found :total items for you!', ['total' => '<strong class="text-brand">' . $products->total() . '</strong>'])) !!}</p>
    </div>
    @include(Theme::getThemeNamespace('views/ecommerce/includes/sort'))
</div>

@if (theme_option('vendor_page_detail_layout') == 'list')
    <div class="product-list mb-50">
        @forelse ($products as $product)
            @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item-list'), compact('product'))
        @empty
            <div class="mt-60 mb-60 text-center">
                <p>{{ __('No products found!') }}</p>
            </div>
        @endforelse
    </div>
@else
    <div class="row product-grid">
        @forelse ($products as $product)
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
                @include(Theme::getThemeNamespace('views.ecommerce.includes.product-item'), compact('product'))
            </div>
        @empty
            <div class="mt-60 mb-60 text-center">
                <p>{{ __('No products found!') }}</p>
            </div>
        @endforelse
    </div>
@endif

{!! $products->withQueryString()->links(Theme::getThemeNamespace('partials.custom-pagination')) !!}
