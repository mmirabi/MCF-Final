<section class="content-page">
    <div class="container">
        <div class="row">

            <div class="list-page-title">
                <h2 class="">{{ $tag->name }} <small> {{ $tag->products->count() }} {{ __('products') }}
                    </small></h2>
            </div>
            <div class="row product-list-item">
                @if ($tag->products->count() > 0)
                    @foreach ($tag->products as $product)
                        <li>
                            <div class="product-item product-loop">
                                <img
                                    class="product-item-thumb"
                                    src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                    alt="{{ $product->name }}"
                                >
                                <h3>{{ $product->name }}</h3>
                                <span class="price">
                                    {!! the_product_price($product) !!}
                                </span>
                                <div class="product-action">
                                    <a
                                        class="btn btn-info"
                                        data-quantity='1'
                                        data-product='{{ $product->id }}'
                                        href="javascript: void(0);"
                                    >{{ __('Add to cart') }}</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
