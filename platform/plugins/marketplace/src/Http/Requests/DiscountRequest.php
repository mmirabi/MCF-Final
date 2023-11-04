<?php

namespace Botble\Marketplace\Http\Requests;

use Botble\Ecommerce\Http\Requests\DiscountRequest as BaseDiscountRequest;
use Botble\Marketplace\Facades\MarketplaceHelper;
use Illuminate\Validation\Rule;

class DiscountRequest extends BaseDiscountRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        return [
            'title' => ['nullable', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:ec_discounts,code'],
            'value' => ['required', 'numeric', 'min:0'],
            'type_option' => ['required', Rule::in(array_keys(MarketplaceHelper::discountTypes()))],
            'quantity' => $rules['quantity'],
            'start_date' => $rules['start_date'],
            'end_date' => $rules['end_date'],
        ];
    }
}
