@php
    Theme::set('layout-data', ['is-wrap-container' => true, 'main-class' => 'pages mb-80', 'wrap-container-class' => 'pt-50']);
    $itemLayout = request()->input('layout') == 'stores-list' ? 'list' : 'grid';
    Theme::set('isShowPreFooterSidebar', true);
@endphp
<div class="page-content pt-50">
    <div class="container">
        <div class="archive-header-2 text-center">
            <h1 class="display-2 mb-50">{!! BaseHelper::clean(SeoHelper::getTitle()) !!}</h1>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="sidebar-widget-2 widget_search mb-50">
                        <div class="search-form form-group">
                            <form action="{{ route('public.stores') }}" method="GET">
                                <input class="form-control" name="q" required value="{{ BaseHelper::stringify(request()->input('q')) }}" type="text" placeholder="{{ __('Search vendor...') }}">
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-50">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="shop-product-filter">
                    <div class="total-product">
                        <p>{!! BaseHelper::clean(__('We have :total vendors now', ['total' => '<strong class="text-brand">' . $stores->total() . '</strong>'])) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row vendor-grid">
            @foreach($stores as $store)
                @include(Theme::getThemeNamespace('views.marketplace.stores.item.' . $itemLayout))
            @endforeach
        </div>

        {!! $stores->withQueryString()->links(Theme::getThemeNamespace('partials.custom-pagination')) !!}
    </div>
</div>
