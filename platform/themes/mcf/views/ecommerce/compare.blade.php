<div class="mb-80 mt-50">
    <div class="row">
        <div class="col-lg-12 m-auto">
            <h1 class="heading-2 mb-10">{{ __('Products Compare') }}</h1>
            @if ($products->isNotEmpty())
                <p class="text-body mb-40 font-heading h6">{!! __('There are :total products to compare', ['total' => '<span class="text-brand">' . $products->count() . '</span>']) !!}</p>
                <div class="table-responsive table__compare">
                    <table class="table text-center table-compare">
                        <tbody class="border-0">
                            <tr class="pr_image">
                                <td class="text-muted font-sm fw-600 font-heading mw-200">{{ __('Preview') }}</td>
                                @foreach($products as $product)
                                    <td class="row_img">
                                        <a href="{{ $product->original_product->url }}">
                                            <img src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="pr_title">
                                <td class="text-muted font-sm fw-600 font-heading">{{ __('Name') }}</td>
                                @foreach($products as $product)
                                    <td class="product_name">
                                        <p class="font-heading h6"><a href="{{ $product->original_product->url }}" class="text-heading">{!! BaseHelper::clean($product->name) !!}</a></p>

                                        @if (is_plugin_active('marketplace') && $product->original_product->store->id)
                                            <p class="d-block mb-0 sold-by">
                                                <small>
                                                    <span>{{ __('Sold by') }}: </span>
                                                    <a href="{{ $product->original_product->store->url }}">{{ $product->original_product->store->name }}</a>
                                                </small>
                                            </p>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="pr_price">
                                <td class="text-muted font-sm fw-600 font-heading">{{ __('Price') }}</td>
                                @foreach($products as $product)
                                    <td class="product_price">
                                        <h4 class="price text-brand">{{ format_price($product->front_sale_price_with_taxes) }}</h4>
                                        @if ($product->front_sale_price !== $product->price)
                                            <del>{{ format_price($product->price_with_taxes) }}</del>
                                            <small>({{ get_sale_percentage($product->price, $product->front_sale_price) }})</small>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @if (EcommerceHelper::isReviewEnabled())
                                <tr class="pr_rating">
                                    <td class="text-muted font-sm fw-600 font-heading">{{ __('Rating') }}</td>
                                    @foreach($products as $product)
                                        <td>
                                            @if ($product->reviews_count)
                                                <div class="rating_wrap">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                                                    </div>
                                                    <span class="rating_num">({{ $product->reviews_count }})</span>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                            <tr class="description text-start">
                                <td class="text-muted font-sm fw-600 font-heading">{{ __('Description') }}</td>
                                @foreach($products as $product)
                                    <td class="row_text font-xs">
                                        <div class="font-sm text-muted p-3">{!! BaseHelper::clean($product->description) !!}</div>
                                    </td>
                                @endforeach
                            </tr>
                            @foreach($attributeSets as $attributeSet)
                                @if ($attributeSet->is_comparable)
                                    <tr>
                                        <td class="text-muted font-sm fw-600 font-heading">
                                            {{ $attributeSet->title }}
                                        </td>

                                        @foreach($products as $product)
                                            @php
                                                $attributes = app(\Botble\Ecommerce\Repositories\Interfaces\ProductInterface::class)
                                                        ->getRelatedProductAttributes($product)
                                                        ->where('attribute_set_id', $attributeSet->id)
                                                        ->sortBy('order');
                                            @endphp

                                            @if ($attributes->count())
                                                @if ($attributeSet->display_layout == 'dropdown')
                                                    <td>
                                                        {{ $attributes->pluck('title')->implode(', ') }}
                                                    </td>
                                                @elseif ($attributeSet->display_layout == 'text')
                                                    <td>
                                                        <div class="attribute-values">
                                                            <ul class="text-swatch attribute-swatch color-swatch">
                                                                @foreach($attributes as $attribute)
                                                                    <li class="attribute-swatch-item" style="display: inline-block">
                                                                        <label>
                                                                            <input class="form-control product-filter-item" type="radio" disabled>
                                                                            <span style="cursor: default">{{ $attribute->title }}</span>
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="attribute-values">
                                                            <ul class="visual-swatch color-swatch attribute-swatch">
                                                                @foreach($attributes as $attribute)
                                                                    <li class="attribute-swatch-item" style="display: inline-block">
                                                                        <div class="custom-radio">
                                                                            <label>
                                                                                <input class="form-control product-filter-item" type="radio" disabled>
                                                                                <span style="{{ $attribute->image ? 'background-image: url(' . RvMedia::getImageUrl($attribute->image) . ');' : 'background-color: ' . $attribute->color . ';' }}; cursor: default;"></span>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </td>
                                                @endif
                                            @else
                                                <td>&mdash;</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                            @if (EcommerceHelper::isCartEnabled())
                                <tr class="pr_add_to_cart">
                                    <td class="text-muted font-sm fw-600 font-heading">{{ __('Buy now') }}</td>
                                    @foreach($products as $product)
                                        <td class="row_btn">
                                            <a href="#" class="btn btn-rounded btn-sm add-to-cart-button" data-id="{{ $product->id }}" data-url="{{ route('public.ajax.cart.store') }}">
                                                <i class="fi-rs-shopping-bag mr-5"></i>{{ __('Add To Cart') }}
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                            <tr class="pr_remove text-muted">
                                <td class="text-muted font-sm fw-600 font-heading">&nbsp;</td>
                                @foreach($products as $product)
                                    <td class="row_remove">
                                        <a class="text-muted js-remove-from-compare-button" href="#" data-url="{{ route('public.compare.remove', $product->id) }}">
                                            <i class="fi-rs-trash mr-5"></i>
                                            <span>{{ __('Remove') }}</span>
                                        </a>
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">{{ __('No products in compare list!') }}</p>
            @endif
        </div>
    </div>
</div>
