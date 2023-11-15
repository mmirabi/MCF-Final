@if (is_plugin_active('ecommerce'))
    <div class="sidebar-widget product-sidebar  mb-30 p-30 bg-grey border-radius-10">
        <div class="widget-header position-relative mb-20 pb-10">
            <h5 class="widget-title mb-10">{{ $config['name'] }}</h5>
            <div class="bt-1 border-color-1"></div>
        </div>
        @foreach(get_featured_products(['take' => $config['number_display']]) as $item)
            <div class="single-post clearfix">
                <div class="image">
                    <a href="{{ $item->url }}"><img src="{{ RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $item->name }}"></a>
                </div>
                <div class="content pt-10">
                    <h5><a href="{{ $item->url }}">{{ $item->name }}</a></h5>
                    <p class="price mb-0 mt-5">
                        <span>{{ format_price($item->front_sale_price_with_taxes) }}</span>
                        @if ($item->front_sale_price !== $item->price)
                            <span class="old-price"><small><del>{{ format_price($item->price_with_taxes) }}</del></small></span>
                        @endif
                    </p>
                    {!! Theme::partial('rating-item', ['ratingCount' => $item->reviews_count, 'ratingAvg' => $item->reviews_avg]) !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
