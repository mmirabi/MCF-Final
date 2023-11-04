{!! apply_filters('ecommerce_product_variation_form_start', null, $product) !!}
<div class="row price-group">
    <input
        class="detect-schedule hidden"
        name="sale_type"
        type="hidden"
        value="{{ old('sale_type', $product ? $product->sale_type : 0) }}"
    >

    <div class="col-md-4">
        <div class="form-group mb-3 @if ($errors->has('sku')) has-error @endif">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.sku') }}</label>
            {!! Form::text('sku', old('sku', $product ? $product->sku : (new \Botble\Ecommerce\Models\Product())->generateSku()), ['class' => 'next-input', 'id' => 'sku']) !!}
        </div>
        @if (($isVariation && !$product) || ($product && $product->is_variation && !$product->sku))
            <div class="form-group mb-3">
                <label class="text-title-field">
                    <input
                        name="auto_generate_sku"
                        type="hidden"
                        value="0"
                    >
                    <input
                        name="auto_generate_sku"
                        type="checkbox"
                        value="1"
                    >
                    &nbsp;{{ trans('plugins/ecommerce::products.form.auto_generate_sku') }}
                </label>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.price') }}</label>
            <div class="next-input--stylized">
                <span
                    class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input
                    class="next-input input-mask-number regular-price next-input--invisible"
                    name="price"
                    data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                    data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                    type="text"
                    value="{{ old('price', $product ? $product->price : $originalProduct->price ?? 0) }}"
                    step="any"
                >
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label class="text-title-field">
                <span class="d-inline-block me-1">{{ trans('plugins/ecommerce::products.form.price_sale') }}</span>
                <a
                    class="turn-on-schedule @if (old('sale_type', $product ? $product->sale_type : $originalProduct->sale_type ?? 0) == 1) hidden @endif"
                    href="javascript:;"
                >{{ trans('plugins/ecommerce::products.form.choose_discount_period') }}</a>
                <a
                    class="turn-off-schedule @if (old('sale_type', $product ? $product->sale_type : $originalProduct->sale_type ?? 0) == 0) hidden @endif"
                    href="javascript:;"
                >{{ trans('plugins/ecommerce::products.form.cancel') }}</a>
            </label>
            <div class="next-input--stylized">
                <span
                    class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                <input
                    class="next-input input-mask-number sale-price next-input--invisible"
                    name="sale_price"
                    data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                    data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                    type="text"
                    value="{{ old('sale_price', $product ? $product->sale_price : $originalProduct->sale_price ?? null) }}"
                >
            </div>
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : $originalProduct->sale_type ?? 0) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.start') }}</label>
            <input
                class="next-input form-date-time"
                name="start_date"
                type="text"
                value="{{ old('start_date', $product ? $product->start_date : $originalProduct->start_date ?? null) }}"
                placeholder="{{ config('core.base.general.date_format.date_time') }}"
            >
        </div>
    </div>
    <div class="col-md-6 scheduled-time @if (old('sale_type', $product ? $product->sale_type : $originalProduct->sale_type ?? 0) == 0) hidden @endif">
        <div class="form-group mb-3">
            <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.date.end') }}</label>
            <input
                class="next-input form-date-time"
                name="end_date"
                type="text"
                value="{{ old('end_date', $product ? $product->end_date : $originalProduct->end_date ?? null) }}"
                placeholder="{{ config('core.base.general.date_format.date_time') }}"
            >
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.cost_per_item') }}</label>
                <div class="next-input--stylized">
                    <span
                        class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                    <input
                        class="next-input input-mask-number regular-price next-input--invisible"
                        name="cost_per_item"
                        type="text"
                        value="{{ old('cost_per_item', $product ? $product->cost_per_item : $originalProduct->cost_per_item ?? 0) }}"
                        step="any"
                        placeholder="{{ trans('plugins/ecommerce::products.form.cost_per_item_placeholder') }}"
                    >
                </div>
                {!! Form::helper(trans('plugins/ecommerce::products.form.cost_per_item_helper')) !!}
            </div>
        </div>
        <input
            name="product_id"
            type="hidden"
            value="{{ $product->id ?? null }}"
        >
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.barcode') }}</label>
                <div class="next-input--stylized">
                    <input
                        class="next-input next-input--invisible"
                        name="barcode"
                        type="text"
                        value="{{ old('barcode', $product ? $product->barcode : $originalProduct->barcode ?? null) }}"
                        step="any"
                        placeholder="{{ trans('plugins/ecommerce::products.form.barcode_placeholder') }}"
                    >
                </div>
            </div>
        </div>
    </div>
</div>

<hr />

{!! apply_filters('ecommerce_product_variation_form_middle', null, $product) !!}

<div class="form-group mb-3">
    <div class="storehouse-management">
        <div class="mt5">
            <input
                name="with_storehouse_management"
                type="hidden"
                value="0"
            >
            <label><input
                    class="storehouse-management-status"
                    name="with_storehouse_management"
                    type="checkbox"
                    value="1"
                    @if (old(
                            'with_storehouse_management',
                            $product ? $product->with_storehouse_management : $originalProduct->with_storehouse_management ?? 0) == 1) checked @endif
                > {{ trans('plugins/ecommerce::products.form.storehouse.storehouse') }}</label>
        </div>
    </div>
</div>
<div class="storehouse-info @if (old(
        'with_storehouse_management',
        $product ? $product->with_storehouse_management : $originalProduct->with_storehouse_management ?? 0) == 0) hidden @endif">
    <div class="form-group mb-3">
        <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.storehouse.quantity') }}</label>
        <input
            class="next-input input-mask-number input-medium"
            name="quantity"
            type="text"
            value="{{ old('quantity', $product ? $product->quantity : $originalProduct->quantity ?? 0) }}"
        >
    </div>
    <div class="form-group mb-3">
        <label class="text-title-field">
            <input
                name="allow_checkout_when_out_of_stock"
                type="hidden"
                value="0"
            >
            <input
                name="allow_checkout_when_out_of_stock"
                type="checkbox"
                value="1"
                @if (old(
                        'allow_checkout_when_out_of_stock',
                        $product ? $product->allow_checkout_when_out_of_stock : $originalProduct->allow_checkout_when_out_of_stock ?? 0) == 1) checked @endif
            >
            &nbsp;{{ trans('plugins/ecommerce::products.form.stock.allow_order_when_out') }}
        </label>
    </div>
</div>

<div class="form-group stock-status-wrapper @if (old(
        'with_storehouse_management',
        $product ? $product->with_storehouse_management : $originalProduct->with_storehouse_management ?? 0) == 1) hidden @endif">
    <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.stock_status') }}</label>
    @foreach (\Botble\Ecommerce\Enums\StockStatusEnum::labels() as $status => $label)
        <label class="me-3">
            <input
                name="stock_status"
                type="radio"
                value="{{ $status }}"
                @checked(old('stock_status', $product ? $product->stock_status : null) == $status)
            />
            {{ $label }}
        </label>
    @endforeach
</div>

<hr />

@if (
    !EcommerceHelper::isEnabledSupportDigitalProducts() ||
        (!$product &&
            !$originalProduct &&
            request()->input('product_type') != Botble\Ecommerce\Enums\ProductTypeEnum::DIGITAL) ||
        ($originalProduct && $originalProduct->isTypePhysical()) ||
        ($product && $product->isTypePhysical()))
    <div class="shipping-management">
        <label class="text-title-field">{{ trans('plugins/ecommerce::products.form.shipping.title') }}</label>
        <div class="row">
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.weight') }}
                        ({{ ecommerce_weight_unit() }})</label>
                    <div class="next-input--stylized">
                        <span
                            class="next-input-add-on next-input__add-on--before">{{ ecommerce_weight_unit() }}</span>
                        <input
                            class="next-input input-mask-number next-input--invisible"
                            name="weight"
                            type="text"
                            value="{{ old('weight', $product ? $product->weight : $originalProduct->weight ?? 0) }}"
                        >
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.length') }}
                        ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span
                            class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input
                            class="next-input input-mask-number next-input--invisible"
                            name="length"
                            type="text"
                            value="{{ old('length', $product ? $product->length : $originalProduct->length ?? 0) }}"
                        >
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.wide') }}
                        ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span
                            class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input
                            class="next-input input-mask-number next-input--invisible"
                            name="wide"
                            type="text"
                            value="{{ old('wide', $product ? $product->wide : $originalProduct->wide ?? 0) }}"
                        >
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-6">
                <div class="form-group mb-3">
                    <label>{{ trans('plugins/ecommerce::products.form.shipping.height') }}
                        ({{ ecommerce_width_height_unit() }})</label>
                    <div class="next-input--stylized">
                        <span
                            class="next-input-add-on next-input__add-on--before">{{ ecommerce_width_height_unit() }}</span>
                        <input
                            class="next-input input-mask-number next-input--invisible"
                            name="height"
                            type="text"
                            value="{{ old('height', $product ? $product->height : $originalProduct->height ?? 0) }}"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (EcommerceHelper::isEnabledSupportDigitalProducts() &&
        ((!$product &&
            !$originalProduct &&
            request()->input('product_type') == Botble\Ecommerce\Enums\ProductTypeEnum::DIGITAL) ||
            ($originalProduct && $originalProduct->isTypeDigital()) ||
            ($product && $product->isTypeDigital())))

    <div class="form-check mb-3">
        <input
            name="generate_license_code"
            type="hidden"
            value="0"
        >
        <input
            class="form-check-input"
            id="generate_license_code"
            name="generate_license_code"
            type="checkbox"
            value="1"
            @checked(old(
                    'generate_license_code',
                    $product ? $product->generate_license_code : $originalProduct->generate_license_code ?? 0))
        >
        <label
            class="form-check-label"
            for="generate_license_code"
        >
            {{ trans('plugins/ecommerce::products.digital_attachments.generate_license_code_after_purchasing_product') }}
        </label>
    </div>

    <div class="mb-3 product-type-digital-management">
        <label
            class="mb-2"
            for="product_file"
        >{{ trans('plugins/ecommerce::products.digital_attachments.title') }}</label>
        <table class="table border">
            <thead>
                <tr>
                    <th width="40"></th>
                    <th>{{ trans('plugins/ecommerce::products.digital_attachments.file_name') }}</th>
                    <th width="100">{{ trans('plugins/ecommerce::products.digital_attachments.file_size') }}</th>
                    <th width="100">{{ trans('core/base::tables.created_at') }}</th>
                    <th
                        class="text-end"
                        width="100"
                    ></th>
                </tr>
            </thead>
            <tbody>
                @if ($product)
                    @foreach ($product->productFiles as $file)
                        <tr>
                            <td>
                                {!! Form::checkbox('product_files[' . $file->id . ']', 0, true, ['class' => 'd-none']) !!}
                                {!! Form::checkbox('product_files[' . $file->id . ']', $file->id, true, [
                                    'class' => 'digital-attachment-checkbox',
                                ]) !!}
                            </td>
                            <td>
                                <div>
                                    @if ($file->is_external_link)
                                        <a
                                            href="{{ $file->url }}"
                                            target="_blank"
                                        >
                                            <i class="fas fa-link"></i>
                                            <span
                                                class="ms-1">{{ $file->basename ? Str::limit($file->basename, 50) : $file->url }}</span>
                                        </a>
                                    @else
                                        <i class="fas fa-paperclip"></i>
                                        <span class="ms-1">{{ Str::limit($file->basename, 50) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $file->file_size ? BaseHelper::humanFileSize($file->file_size) : '-' }}</td>
                            <td>{{ BaseHelper::formatDate($file->created_at) }}</td>
                            <td class="text-end"></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="digital_attachments_input">
            <input
                name="product_files_input[]"
                data-id="{{ Str::random(10) }}"
                type="file"
            >
        </div>
        <div class="mt-2">
            <a
                class="digital_attachments_btn"
                href="#"
            >{{ trans('plugins/ecommerce::products.digital_attachments.add') }}</a>
            <span class="px-1">|</span>
            <a
                class="digital_attachments_external_btn text-warning"
                href="#"
            >{{ trans('plugins/ecommerce::products.digital_attachments.add_external_link') }}</a>
        </div>
    </div>
    @if (request()->ajax())
        @include('plugins/ecommerce::products.partials.digital-product-file-template')
    @else
        @pushOnce('footer')
            @include('plugins/ecommerce::products.partials.digital-product-file-template')
        @endpushOnce
    @endif
@endif

{!! apply_filters('ecommerce_product_variation_form_end', null, $product) !!}
