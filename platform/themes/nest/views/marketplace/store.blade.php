@php
    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/plugins/jquery.theia.sticky.js');
    Theme::asset()->usePath()->add('jquery-ui-css', 'css/plugins/jquery-ui.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/plugins/jquery-ui.js');
@endphp

<form action="{{ $store->url }}" method="GET" id="products-filter-ajax" data-scroll-to=".products-listing">
    @if (theme_option('vendor_page_detail_layout') == 'list')
        @include(Theme::getThemeNamespace('views.marketplace.stores.list'))
    @else
        @include(Theme::getThemeNamespace('views.marketplace.stores.grid'))
    @endif
</form>
