<div style="margin-bottom: 20px;">
    <label class="me-1">{{ __('Availability') }}: </label>
    <span class="number-items-available">
        @if ($product->isOutOfStock())
            <span class="text-danger">{{ __('Out of stock') }}</span>
        @elseif  (!$product->with_storehouse_management || $product->quantity < 1)
            {!! BaseHelper::clean($product->stock_status_html) !!}
        @elseif ($product->quantity)
            @if (EcommerceHelper::showNumberOfProductsInProductSingle())
                <span class="text-success">
                @if ($product->quantity != 1)
                    {{ __(':number products available', ['number' => $product->quantity]) }}
                @else
                    {{ __(':number product available', ['number' => $product->quantity]) }}
                @endif
                    </span>
            @else
                <span class="text-success">{{ __('In stock') }}</span>
            @endif
        @endif
    </span>
</div>

