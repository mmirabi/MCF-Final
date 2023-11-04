<div class="sidebar-widget mb-30">
    @if (!empty($isShowSearchForm))
        <div class="sidebar-widget-2 widget_search mb-50">
            <div class="search-form form-group">
                <input name="q" value="{{ BaseHelper::stringify(request()->input('q')) }}" type="text" placeholder="{{ __('Search in this store...') }}">
            </div>
        </div>
    @endif

    @php
        $categories = ProductCategoryHelper::getProductCategoriesWithIndent('&nbsp;&nbsp;', false)
            ->loadCount(['products' => function ($q) use ($store) {
                $q
                    ->where('store_id', $store->id)
                    ->where('ec_products.status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED);
            }])
            ->where('products_count');
    @endphp
    @if (count($categories) > 0)
        <div class="widget-category-2 mb-30 widget-filter-item">
            <h5 class="section-title style-1 mb-30 widget__title" data-title="{{ __('Category') }}">{{ __('By :name', ['name' => __('categories')]) }}</h5>
            <div class="custome-checkbox">
                @foreach($categories as $category)
                    {!! $category->indent_text !!}
                    <input class="form-check-input"
                        name="categories[]"
                        type="checkbox"
                        id="category-filter-{{ $category->id }}"
                        value="{{ $category->id }}"
                        @if (in_array($category->id, (array)request()->input('categories', []))) checked @endif>
                    <label class="form-check-label" for="category-filter-{{ $category->id }}">
                        <span class="d-inline-block">{!! BaseHelper::clean($category->name) !!} ({{ $category->products_count }})</span>
                    </label>
                    <br>
                @endforeach
            </div>
        </div>
    @endif

    <div class="price_range range mb-30 widget-filter-item" data-type="price">
        <h5 class="section-title style-1 mb-20 widget__title" data-title="{{ __('Price') }}">{{ __('By :name', ['name' => __('Price')]) }}</h5>
        <div class="price-filter range">
            <div class="price-filter-inner">
                <div class="slider-range"></div>
                <input type="hidden"
                    class="min_price min-range"
                    name="min_price"
                    value="{{ (float)request()->input('min_price', 0) }}"
                    data-min="0"
                    data-label="{{ __('Min price') }}"/>
                <input type="hidden"
                    class="min_price max-range"
                    name="max_price"
                    value="{{ (float)request()->input('max_price', theme_option('max_filter_price', 100000)) }}"
                    data-max="{{ (float)theme_option('max_filter_price', 100000) }}"
                    data-label="{{ __('Max price') }}"/>
                <div class="price_slider_amount">
                    <div class="label-input">
                        <span class="d-inline-block">{{ __('Range:') }} </span>
                        <span class="from d-inline-block"></span>
                        <span class="to d-inline-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> {{ __('Filter') }}</button>
</div>
