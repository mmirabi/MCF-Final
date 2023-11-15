@php
    $layout = theme_option('product_list_layout');

    if (Route::currentRouteName() === 'public.product') {
        $layout = theme_option('product_single_layout');

        $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-right-sidebar';
    } else {
        $requestLayout = request()->input('layout');
        if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
            $layout = $requestLayout;
        }

        $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';
    }

    Theme::asset()->usePath()
                    ->add('custom-scrollbar-css', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.css');
    Theme::asset()->container('footer')->usePath()
                ->add('custom-scrollbar-js', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.js', ['jquery']);

    [$categories, $brands, $tags, $rand, $categoriesRequest, $urlCurrent, $categoryId, $maxFilterPrice] = EcommerceHelper::dataForFilter($category ?? null);
@endphp

<input type="hidden" name="layout" value="{{ $layout }}">

@if ($layout === 'product-full-width')
    <div class="shop-product-filter-header my-3" style="display: none">
        <div class="row">
            @if ($categories->isNotEmpty())
                <div class="col-lg-3 col-md-4 mb-lg-0 mb-md-5 mb-sm-5 widget-filter-item product-categories-filter-widget">
                    <h5 class="mb-20 widget__title" data-title="{{ __('Category') }}">{{ __('By :name', ['name' => __('categories')]) }}</h5>
                    <div class="custome-checkbox ps-custom-scrollbar">
                        <ul class="ps-list--categories">
                            @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                                'categories' => $categories,
                                'activeCategoryId' => $categoryId,
                                'categoriesRequest' => $categoriesRequest,
                                'urlCurrent' => $urlCurrent
                            ])
                        </ul>
                    </div>
                </div>
            @endif

            @if ($brands->isNotEmpty())
                <div class="col-lg-3 col-md-4 mb-lg-0 mb-md-5 mb-sm-5 widget-filter-item">
                    <h5 class="mb-20 widget__title" data-title="{{ __('Brand') }}">{{ __('By :name', ['name' => __('Brands')]) }}</h5>
                    <div class="custome-checkbox ps-custom-scrollbar">
                        @foreach($brands as $brand)
                            <input class="form-check-input"
                                   name="brands[]"
                                   type="checkbox"
                                   id="brand-filter-{{ $brand->id }}"
                                   value="{{ $brand->id }}"
                                   @if (in_array($brand->id, (array)request()->input('brands', []))) checked @endif>
                            <label class="form-check-label" for="brand-filter-{{ $brand->id }}"><span class="d-inline-block">{{ $brand->name }}</span> <span class="d-inline-block">({{ $brand->products_count }})</span> </label>
                            <br>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($tags->isNotEmpty())
                <div class="col-lg-3 col-md-4 mb-lg-0 mb-md-5 mb-sm-5 widget-filter-item">
                    <h5 class="mb-20 widget__title" data-title="{{ __('Tag') }}">{{ __('By :name', ['name' => __('tags')]) }}</h5>
                    <div class="custome-checkbox ps-custom-scrollbar">
                        @foreach($tags as $tag)
                            <input class="form-check-input"
                                   name="tags[]"
                                   type="checkbox"
                                   id="tag-filter-{{ $tag->id }}"
                                   value="{{ $tag->id }}"
                                   @if (in_array($tag->id, (array)request()->input('tags', []))) checked @endif>
                            <label class="form-check-label" for="tag-filter-{{ $tag->id }}"><span class="d-inline-block">{{ $tag->name }}</span> <span class="d-inline-block">({{ $tag->products_count }})</span> </label>
                            <br>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($maxFilterPrice)
                <div class="col-lg-3 col-md-4 mb-lg-0 mb-md-5 mb-sm-5 widget-filter-item" data-type="price">
                    <h5 class="mb-20 widget__title" data-title="{{ __('Price') }}">{{ __('By :name', ['name' => __('Price')]) }}</h5>
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.filter-by-price'))
                </div>
            @endif
        </div>

        <a class="show-advanced-filters" href="#">
            <span class="title">{{ __('Advanced filters') }}</span>
            <i class="fi-rs-angle-up angle-down"></i>
            <i class="fi-rs-angle-down angle-up"></i>
        </a>

        <div class="advanced-search-widgets" style="display: none">
            <div class="row">
                {!! render_product_swatches_filter([
                    'view' => Theme::getThemeNamespace() . '::views.ecommerce.attributes.attributes-filter-renderer'
                ]) !!}
            </div>
        </div>

        <div class="widget">
            <button type="submit" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5 ml-0"></i> {{ __('Filter') }}</button>

            <a class="clear_filter dib clear_all_filter mx-4 btn btn-danger btn-sm" href="{{ route('public.products') }}"><i class="fi-rs-refresh mr-5 ml-0"></i> {{ __('Clear All Filters') }}</a>
        </div>
    </div>
@else
    <div class="product-sidebar">
        @if($categories->isNotEmpty())
            <div class="sidebar-widget widget-filter-item product-categories-filter-widget mb-30" data-type="price">
                <h5 class="section-title style-1 mb-30">{{ __('Categories') }}</h5>
                <div class="custome-checkbox ps-custom-scrollbar">
                    <ul class="ps-list--categories">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                            'categories' => $categories,
                            'activeCategoryId' => $categoryId,
                            'categoriesRequest' => $categoriesRequest,
                            'urlCurrent' => $urlCurrent
                        ])
                    </ul>
                </div>
            </div>
        @endif

        @if ($maxFilterPrice)
            <div class="sidebar-widget widget-filter-item mb-30" data-type="price">
                <h5 class="section-title style-1 mb-30" data-title="{{ __('Price') }}">{{ __('Price Range') }}</h5>
                @include(Theme::getThemeNamespace('views.ecommerce.includes.filter-by-price'))
            </div>
        @endif

        @if ($brands->isNotEmpty())
            <div class="sidebar-widget widget-filter-item mb-30">
                <h5 class="section-title style-1 mb-30">{{ __('Brands') }}</h5>
                <div class="custome-checkbox ps-custom-scrollbar">
                    @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="brands[]" value="{{ $brand->id }}" @checked(in_array($brand->id, request()->query('brands', []))) id="brand-filter-{{ $brand->id }}">
                            <label class="form-check-label" for="brand-filter-{{ $brand->id }}">
                                {{ $brand->name }} ({{ $brand->products_count }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($tags->isNotEmpty())
            <div class="sidebar-widget widget-filter-item mb-30">
                <h5 class="section-title style-1 mb-30">{{ __('Tags') }}</h5>
                <div class="custome-checkbox ps-custom-scrollbar">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, request()->query('tags', []))) id="tag-filter-{{ $tag->id }}">
                            <label class="form-check-label" for="tag-filter-{{ $tag->id }}">
                                {{ $tag->name }} ({{ $tag->products_count }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {!! render_product_swatches_filter([
            'view' => Theme::getThemeNamespace('views.ecommerce.attributes.attributes-filter-sidebar-renderer')
        ]) !!}
    </div>
@endif
