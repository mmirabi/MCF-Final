<div class="mb-30 mt-50">
    <div class="row">
        <div class="col-lg-12 m-auto">
            <div class="mb-50">
                <h1 class="heading-2 mb-10">{{ __('Your Wishlist') }}</h1>
                @if ($products->total())
                    <p class="text-body  font-heading h6">{!! BaseHelper::clean(__('There are :total products in this list', ['total' => '<span class="text-brand">' . $products->total() . '</span>'])) !!}</p>
                @endif
            </div>
            @if ($products->total())
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th scope="col" colspan="2" class="pl-30 start">{{ __('Product') }}</th>
                                <th scope="col">{{ __('Price') }}</th>
                                <th scope="col">{{ __('Stock Status') }}</th>
                                @if (EcommerceHelper::isCartEnabled())
                                    <th scope="col">{{ __('Action') }}</th>
                                @endif
                                <th scope="col" class="end">{{ __('Remove') }}</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @foreach($products as $product)
                                <tr class="pt-30">
                                    <td class="image product-thumbnail pt-40 pl-30">
                                        <img alt="{{ $product->name }}" src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                                    </td>
                                    <td class="product-des product-name">
                                        <p class="mb-5 font-heading h6">
                                            <a class="product-name mb-10 text-heading" href="{{ $product->original_product->url }}">{{ $product->original_product->name }}  @if ($product->isOutOfStock()) <span class="stock-status-label">({!! $product->stock_status_html !!})</span> @endif</a>
                                        </p>
                                        @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                                            <p class="d-block mb-0 sold-by">
                                                <small>
                                                    <span>{{ __('Sold by') }}: </span>
                                                    <a href="{{ $product->original_product->store->url }}">{{ $product->original_product->store->name }}</a>
                                                </small>
                                            </p>
                                        @endif

                                        @if (EcommerceHelper::isReviewEnabled() && $product->reviews_count)
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted">({{ $product->reviews_count }})</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="price" data-title="{{ __('Price') }}">
                                        <span class="text-brand">{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                        @if ($product->front_sale_price != $product->price)
                                            <small class="old-price"><del>{{ format_price($product->price_with_taxes) }}</del></small>
                                        @endif
                                    </td>
                                    <td class="text-center detail-info" data-title="{{ __('Stock') }}">
                                        <span class="stock-status in-stock mb-0">
                                            {!! BaseHelper::clean($product->stock_status_html) !!}
                                        </span>
                                    </td>
                                    @if (EcommerceHelper::isCartEnabled())
                                        <td class="text-right" data-title="{{ __('Action') }}">
                                            <a href="#" class="btn btn-rounded btn-sm add-to-cart-button" data-id="{{ $product->id }}" data-url="{{ route('public.ajax.cart.store') }}"><i class="fi-rs-shopping-cart mr-5"></i>{{ __('Add to cart') }}</a>
                                        </td>
                                    @endif

                                    <td class="action" data-title="{{ __('Remove') }}">
                                        <a href="#" class="js-remove-from-wishlist-button" data-url="{{ route('public.wishlist.remove', $product->id) }}"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($products->total())
                    {!! $products->withQueryString()->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}
                @endif
            @else
                <p>{{ __('No item in wishlist!') }}</p>
            @endif
        </div>
    </div>
</div>
