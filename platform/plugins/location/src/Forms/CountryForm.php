<?php

namespace Botble\Location\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Location\Http\Requests\CountryRequest;
use Botble\Location\Models\Country;

class CountryForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Country())
            ->setValidatorClass(CountryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('code', 'text', [
                'label' => trans('plugins/location::country.code'),
                'attr' => [
                    'placeholder' => trans('plugins/location::country.code_placeholder'),
                    'data-counter' => 10,
                ],
                'help_block' => [
                    'text' => trans('plugins/location::country.code_helper'),
                    'tag' => 'p',
                    'attr' => [
                        'class' => 'help-ts',
                    ],
                ],
            ])
            ->add('nationality', 'text', [
                'label' => trans('plugins/location::country.nationality'),
                'attr' => [
                    'placeholder' => trans('plugins/location::country.nationality'),
                    'data-counter' => 120,
                ],
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('is_default', 'onOff', [
                'label' => trans('core/base::forms.is_default'),
                'default_value' => false,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
