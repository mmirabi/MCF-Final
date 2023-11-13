@if (is_plugin_active('ecommerce'))
    @php
        $products = app(Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)
            ->advancedGet([
                'take'      => (int) $config['number_display'] ?: 3,
                'condition' => [
                    'ec_products.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                    'ec_products.is_variation' => 0,
                ],
                'order_by' => [
                    'created_at' => 'DESC',
                ],
            ] + EcommerceHelper::withReviewsParams());
    @endphp
    <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
        <h5 class="section-title style-1 mb-30">{{ $config['name'] }}</h5>
        @foreach ($products as $product)
            <div class="single-post clearfix">
                <div class="image">
                    <img src="{{ RvMedia::getImageUrl($product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                </div>
                <div class="content pt-10">
                    <h5><a href="{{ $product->url }}">{!! BaseHelper::clean($product->name) !!}</a></h5>
                    <p class="price mb-0 mt-5">{{ format_price($product->front_sale_price_with_taxes) }}</p>
                    {!! Theme::partial('rating-item', ['ratingCount' => $product->reviews_count, 'ratingAvg' => $product->reviews_avg]) !!}
                </div>
            </div>
        @endforeach
    </div>
@endif
