<div class="title">
    <h2 class="customer-page-title">{{ __('Wishlist') }}</h2>
</div>
<br>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Product') }}</th>
                <th>{{ __('Price') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($products->total())
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img
                                class="img-fluid"
                                src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                alt="{{ $product->original_product->name }}"
                                style="max-height: 75px"
                                width="50"
                                height="70"
                            >
                        </td>
                        <td>
                            <a href="{{ $product->original_product->url }}">{{ $product->original_product->name }}</a>

                            @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                                <p class="d-block mb-0">
                                    <small>
                                        <span>{{ __('Sold by') }}: </span>
                                        <a href="{{ $product->original_product->store->url }}">{{ $product->original_product->store->name }}</a>
                                    </small>
                                </p>
                            @endif
                        </td>

                        <td>
                            <div class="product__price @if ($product->front_sale_price != $product->price) sale @endif">
                                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                @if ($product->front_sale_price != $product->price)
                                    <small><del>{{ format_price($product->price_with_taxes) }}</del></small>
                                @endif
                            </div>
                        </td>

                        <td>
                            <a href="{{ route('public.wishlist.remove', $product->id) }}">{{ __('Remove') }}</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td
                        class="text-center"
                        colspan="4"
                    >{{ __('No product in wishlist!') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@if ($products->total())
    {!! $products->links() !!}
@endif
