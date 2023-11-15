<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'customer_id' => 'required|exists:ec_customers,id',
            'description' => 'nullable|string|max:400',
        ];

        if (is_plugin_active('payment')) {
            $rules['payment_status'] = Rule::in([PaymentStatusEnum::COMPLETED, PaymentStatusEnum::PENDING]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => trans('plugins/ecommerce::order.required_customer'),
            'customer_id.exists' => trans('plugins/ecommerce::order.customer_not_exists'),
        ];
    }
}
