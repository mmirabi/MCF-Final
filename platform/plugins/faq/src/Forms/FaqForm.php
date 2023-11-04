<?php

namespace Botble\Faq\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Faq\Http\Requests\FaqRequest;
use Botble\Faq\Models\Faq;
use Botble\Faq\Models\FaqCategory;

class FaqForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Faq())
            ->setValidatorClass(FaqRequest::class)
            ->withCustomFields()
            ->add('category_id', 'customSelect', [
                'label' => trans('plugins/faq::faq.category'),
                'required' => true,
                'choices' => ['' => trans('plugins/faq::faq.select_category')] + FaqCategory::query()->pluck('name', 'id')->all(),
            ])
            ->add('question', 'text', [
                'label' => trans('plugins/faq::faq.question'),
                'required' => true,
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('answer', 'editor', [
                'label' => trans('plugins/faq::faq.answer'),
                'required' => true,
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'required' => true,
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
