<div class="form-group mb-3">
    <input
        name="products"
        type="hidden"
        value="@if ($flashSale->id) {{ implode(',',array_filter($flashSale->products()->allRelatedIds()->toArray())) }} @endif"
    />
    <div class="box-search-advance product">
        <div>
            <input
                class="next-input textbox-advancesearch"
                data-target="{{ route('products.get-list-product-for-search') }}"
                type="text"
                placeholder="{{ trans('plugins/ecommerce::products.search_products') }}"
            >
        </div>
        <div class="panel panel-default">

        </div>
    </div>

    <div class="list-selected-products @if (!$products->count()) hidden @endif">
        <div class="mt20"><label
                class="text-title-field">{{ trans('plugins/ecommerce::products.selected_products') }}:</label></div>
        <div class="table-wrapper p-none mt10 mb20 ps-relative">
            <table class="table-normal">
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr data-product-id="{{ $product->id }}">
                            <td
                                class="width-60-px min-width-60-px"
                                style="padding-top: 15px;"
                            >
                                <div class="wrap-img vertical-align-m-i">
                                    <img
                                        class="thumb-image"
                                        src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                        alt="{{ $product->name }}"
                                    >
                                </div>
                            </td>
                            <td
                                class="pl5 p-r5 min-width-200-px"
                                style="padding-top: 15px;"
                            >
                                <a
                                    class="hover-underline pre-line"
                                    href="{{ route('products.edit', $product->id) }}"
                                    target="_blank"
                                >{{ $product->name }} ({{ format_price($product->sale_price ?: $product->price) }})</a>
                            </td>
                            <td
                                class="pl5 p-r5 text-end width-20-px min-width-20-px"
                                style="padding-top: 15px;"
                            >
                                <a
                                    class="btn-trigger-remove-selected-product"
                                    data-id="{{ $product->id }}"
                                    href="#"
                                    title="{{ trans('plugins/ecommerce::products.delete') }}"
                                >
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <tr data-product-id="{{ $product->id }}">
                            <td
                                style="border-top: none; overflow: hidden; @if (!$loop->last) border-bottom: 1px solid #ececec; @endif"
                                colspan="3"
                            >
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label
                                                class="control-label required">{{ trans('plugins/ecommerce::products.price') }}</label>
                                            <input
                                                class="form-control input-mask-number"
                                                name="products_extra[{{ $index }}][price]"
                                                data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                                                data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                                                type="text"
                                                value="{{ $product->pivot->price }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label
                                                class="control-label required">{{ trans('plugins/ecommerce::products.quantity') }}</label>
                                            <input
                                                class="form-control input-mask-number"
                                                name="products_extra[{{ $index }}][quantity]"
                                                data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                                                data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                                                type="text"
                                                value="{{ $product->pivot->quantity }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('footer')
    <script id="selected_product_list_template" type="text/x-custom-template">
        <tr>
            <td class="width-60-px min-width-60-px">
                <div class="wrap-img vertical-align-m-i">
                    <img class="thumb-image" src="__image__" alt="__name__" title="__name__">
                </div>
            </td>
            <td class="pl5 p-r5 min-width-200-px">
                <a class="hover-underline pre-line" href="__url__">__name__</a>
                <p class="type-subdued">__attributes__</p>
            </td>
            <td class="pl5 p-r5 text-end width-20-px min-width-20-px">
                <a href="#" class="btn-trigger-remove-selected-product" title="{{ trans('plugins/ecommerce::products.delete') }}" data-id="__id__">
                    <i class="fa fa-times"></i>
                </a>
            </td>
        </tr>
        <tr data-product-id="__id__">
            <td colspan="3" style="border-top: none; border-bottom: 1px solid #ececec;">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label class="control-label required">{{ trans('plugins/ecommerce::products.price') }}</label>
                            <input type="text" class="form-control input-mask-number" data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}" data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}" name="products_extra[__index__][price]" value="__price__">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label class="control-label required">{{ trans('plugins/ecommerce::products.quantity') }}</label>
                            <input type="text" class="form-control" name="products_extra[__index__][quantity]" value="1">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </script>
@endpush
