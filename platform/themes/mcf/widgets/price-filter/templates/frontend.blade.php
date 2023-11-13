@if (is_plugin_active('ecommerce') && $maxFilterPrice = EcommerceHelper::getProductMaxPrice())
    @php
        Theme::asset()->usePath()->add('jquery-ui-css', 'css/plugins/jquery-ui.css');
        Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/plugins/jquery-ui.js');
        Theme::asset()->container('footer')->usePath()->add('jquery-ui-touch-punch-js', 'js/plugins/jquery.ui.touch-punch.min.js');
    @endphp
    <form action="{{ route('public.products') }}" method="GET">
        <div class="sidebar-widget price_range range mb-30 widget-filter-item" data-type="price">
            <h5 class="section-title style-1 mb-30">{{ $config['name'] }}</h5>
            @include(Theme::getThemeNamespace('views.ecommerce.includes.filter-by-price'))
            <button class="btn btn-sm btn-default mt-3"><i class="fi-rs-filter mr-5"></i> {{ __('Filter') }}</button>
        </div>
    </form>
@endif
