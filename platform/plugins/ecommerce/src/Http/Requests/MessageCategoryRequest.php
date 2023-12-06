<?php

namespace Botble\Ecommerce\Http\Requests;

use Botble\Support\Http\Requests\Request;

class MessageCategoryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:220',
            'order' => 'nullable|integer|min:0',
        ];
    }
}
