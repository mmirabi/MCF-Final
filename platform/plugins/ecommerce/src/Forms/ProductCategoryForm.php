<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Ecommerce\Http\Requests\ProductCategoryRequest;
use Botble\Ecommerce\Models\ProductCategory;

class ProductCategoryForm extends FormAbstract
{
    public function buildForm(): void
    {
        $categories = ProductCategoryHelper::getTreeCategoriesOptions(ProductCategoryHelper::getActiveTreeCategories());

        $categories = [0 => trans('plugins/ecommerce::product-categories.none')] + $categories;

        $maxOrder = ProductCategory::query()
            ->whereIn('parent_id', [0, null])
            ->orderByDesc('order')
            ->value('order');

        $this
            ->setupModel(new ProductCategory())
            ->setValidatorClass(ProductCategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('parent_id', 'customSelect', [
                'label' => trans('core/base::forms.parent'),
                'required' => true,
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => $categories,
            ])
            ->add('description', 'editor', [
                'label' => trans('core/base::forms.description'),
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 500,
                ],
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => $maxOrder + 1,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('image', 'mediaImage')
            ->add(
                'icon',
                $this->getFormHelper()->hasCustomField('themeIcon') ? 'themeIcon' : 'text',
                [
                    'label' => __('Font Icon'),
                    'label_attr' => [
                        'class' => 'control-label',
                    ],
                    'attr' => [
                        'placeholder' => 'ex: fa fa-home',
                    ],
                    'empty_value' => __('-- None --'),
                ]
            )
            ->add('icon_image', 'mediaImage', [
                'label' => __('Icon image'),
                'help_block' => [
                    'text' => __('It will replace Icon Font if it is present.'),
                ],
                'wrapper' => [
                    'style' => 'display: block;',
                ],
            ])
            ->add('is_featured', 'onOff', [
                'label' => trans('core/base::forms.is_featured'),
                'default_value' => false,
            ])
            ->setBreakFieldPoint('status');
    }
}
