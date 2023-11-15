<?php

namespace Botble\Blog\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\Fields\TagField;
use Botble\Base\Forms\FormAbstract;
use Botble\Blog\Forms\Fields\CategoryMultiField;
use Botble\Blog\Http\Requests\PostRequest;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Blog\Models\Tag;

class PostForm extends FormAbstract
{
    public function buildForm(): void
    {
        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }

        if (! $this->getModel() && empty($selectedCategories)) {
            $selectedCategories = Category::query()
                ->where('is_default', 1)
                ->pluck('id')
                ->all();
        }

        $tags = null;

        if ($this->getModel()) {
            $tags = $this->getModel()
                ->tags()
                ->select('name')
                ->get()
                ->map(fn (Tag $item) => $item->name)
                ->implode(',');
        }

        $this
            ->setupModel(new Post())
            ->setValidatorClass(PostRequest::class)
            ->hasTabs()
            ->withCustomFields()
            ->addCustomField('tags', TagField::class)
            ->addCustomField('categoryMulti', CategoryMultiField::class)
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'required' => true,
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 150,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('is_featured', 'onOff', [
                'label' => trans('core/base::forms.is_featured'),
                'default_value' => false,
            ])
            ->add('content', 'editor', [
                'label' => trans('core/base::forms.content'),
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'choices' => BaseStatusEnum::labels(),
            ])
            ->when(get_post_formats(true), function ($form, $postFormats) {
                if (count($postFormats) > 1) {
                    $form
                        ->add('format_type', 'customRadio', [
                            'label' => trans('plugins/blog::posts.form.format_type'),
                            'choices' => $postFormats,
                        ]);
                }
            })
            ->add('categories[]', 'categoryMulti', [
                'label' => trans('plugins/blog::posts.form.categories'),
                'choices' => get_categories_with_children(),
                'value' => old('categories', $selectedCategories),
            ])
            ->add('image', 'mediaImage')
            ->add('tag', 'tags', [
                'label' => trans('plugins/blog::posts.form.tags'),
                'value' => $tags,
                'attr' => [
                    'placeholder' => trans('plugins/blog::base.write_some_tags'),
                    'data-url' => route('tags.all'),
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
