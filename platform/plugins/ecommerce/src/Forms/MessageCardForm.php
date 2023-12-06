<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\Assets;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Facades\MessageCategoryHelper;
use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Ecommerce\Forms\Fields\CategoryMultiField;

use Botble\Ecommerce\Models\MessageCard;
use Botble\Ecommerce\Models\MessageCategory;

class MessageCardForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this->addAssets();

        $messageId = null;
        $selectedCategories = [];
        if ($this->getModel()) {
            $messageId = $this->getModel()->id;

            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }

        $this
            ->setupModel(new MessageCard())
            ->withCustomFields()
            ->addCustomField('categoryMulti', CategoryMultiField::class)
            ->addCustomField('multiCheckList', MultiCheckListField::class)
            ->add('title', 'text', [
                'label' => trans('plugins/ecommerce::messages.form.name'),
                'label_attr' => ['class' => 'text-title-field required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 150,
                ],
            ])
            ->add('description', 'editor', [
                'label' => trans('core/base::forms.description'),
                'attr' => [
                    'rows' => 2,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 1000,
                ],
            ])
            ->add('content', 'editor', [
                'label' => trans('plugins/ecommerce::messages.form.content'),
                'attr' => [
                    'rows' => 4,
                    'data-counter' => 1000,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('categories[]', 'categoryMulti', [
                'label' => trans('plugins/ecommerce::messages.form.categories'),
                'choices' => MessageCategoryHelper::getActiveTreeCategories(),
                'value' => old('categories', $selectedCategories),
            ]);

    }

    public function addAssets(): void
    {
        Assets::addStyles(['datetimepicker'])
            ->addScripts([
                'moment',
                'datetimepicker',
                'jquery-ui',
                'input-mask',
                'blockui',
            ])
            ->addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/js/edit-product.js',
            ]);
    }
}
