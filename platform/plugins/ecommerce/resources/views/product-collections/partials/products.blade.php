<div
    class="widget meta-boxes"
    id="product-extras"
>
    <div class="widget-title">
        <h4><span>{{ trans('plugins/ecommerce::products.name') }}</span></h4>
    </div>
    <div class="widget-body">
        <div class="form-group mb-3">
            <label class="control-label">{{ trans('plugins/ecommerce::products.name') }}</label>
            <input
                name="collection_products"
                type="hidden"
                value="@if ($productCollection) {{ implode(',', $productCollection->products->pluck('id')->all()) }} @endif"
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
            @include('plugins/ecommerce::products.partials.selected-products-list', [
                'products' => $productCollection->products ?: collect(),
                'includeVariation' => false,
            ])
        </div>
    </div>
</div>

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
</script>
