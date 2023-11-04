{!! Form::open(['url' => route('orders.update-tax-information', $tax->getKey())]) !!}
<input
    name="order_id"
    type="hidden"
    value="{{ $orderId }}"
>

<div class="next-form-section">
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label
                class="text-title-field required">{{ trans('plugins/ecommerce::order.tax_info.company_name') }}</label>
            <input
                class="next-input"
                name="company_name"
                type="text"
                value="{{ $tax->company_name }}"
                placeholder="{{ trans('plugins/ecommerce::order.tax_info.company_name') }}"
            >
        </div>
        <div class="next-form-grid-cell">
            <label class="text-title-field">{{ trans('plugins/ecommerce::order.tax_info.company_email') }}</label>
            <input
                class="next-input"
                name="company_email"
                type="email"
                value="{{ $tax->company_email }}"
                placeholder="{{ trans('plugins/ecommerce::order.tax_info.company_email') }}"
            >
        </div>
    </div>
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label class="text-title-field">{{ trans('plugins/ecommerce::order.tax_info.company_tax_code') }}</label>
            <input
                class="next-input"
                name="company_tax_code"
                type="text"
                value="{{ $tax->company_tax_code }}"
                placeholder="{{ trans('plugins/ecommerce::order.tax_info.company_tax_code') }}"
            >
        </div>
    </div>

    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label
                class="text-title-field required">{{ trans('plugins/ecommerce::order.tax_info.company_address') }}</label>
            <input
                class="next-input"
                name="company_address"
                type="text"
                value="{{ $tax->company_address }}"
                placeholder="{{ trans('plugins/ecommerce::order.tax_info.company_address') }}"
            >
        </div>
    </div>
</div>
{!! Form::close() !!}
