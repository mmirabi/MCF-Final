<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class MessageCardRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:250',
            'status' => Rule::in(BaseStatusEnum::values()),
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|exists:ec_message_categories,id',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => trans('plugins/ecommerce::products.product_create_validate_name_required'),
        ];
    }
}
