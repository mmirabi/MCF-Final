<div class="list-content-loading">
    <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
</div>

@if($products->isNotEmpty())
    <div class="shop-product-filter">
        <div class="total-product">
            <p>{!! BaseHelper::clean(__('We found :total items for you!', ['total' => '<strong class="text-brand">' . $products->count() . '</strong>'])) !!}</p>
        </div>
        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/sort')
    </div>
@endif

<input type="hidden" name="page" data-value="{{ $products->currentPage() }}">
<input type="hidden" name="sort-by" value="{{ BaseHelper::stringify(request()->input('sort-by')) }}">
<input type="hidden" name="num" value="{{ BaseHelper::stringify(request()->input('num')) }}">
<input type="hidden" name="q" value="{{ BaseHelper::stringify(request()->input('q')) }}">

<div class="row product-grid">
    @forelse ($products as $product)
        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-12 col-sm-6">
            @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
        </div>
    @empty
        <div class="mt__60 mb__60 text-center">
            <p>{{ __('No products found!') }}</p>
        </div>
    @endforelse
</div>

@if ($products->hasPages())
    <br>
    {!! $products->withQueryString()->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}
@endif
