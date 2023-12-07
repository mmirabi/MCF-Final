<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\MessageCategoryForm;
use Botble\Ecommerce\Http\Requests\MessageCategoryRequest;
use Botble\Ecommerce\Http\Resources\MessageCategoryResource;
use Botble\Ecommerce\Models\MessageCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MessageCategoryController extends BaseController
{
    public function index(
        FormBuilder $formBuilder,
        Request $request,
        BaseHttpResponse $response
    ) {
        PageTitle::setTitle(trans('plugins/ecommerce::message-categories.name'));

        $categories = MessageCategory::query()
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->withCount('cards')
            ->get();

        if ($request->ajax()) {
            $data = view('core/base::forms.partials.tree-categories', $this->getOptions(compact('categories')))
                ->render();

            return $response->setData($data);
        }

        Assets::addStylesDirectly(['vendor/core/core/base/css/tree-category.css'])
            ->addScriptsDirectly(['vendor/core/core/base/js/tree-category.js']);

        $form = $formBuilder->create(MessageCategoryForm::class, ['template' => 'core/base::forms.form-tree-category']);
        $form = $this->setFormOptions($form, null, compact('categories'));

        return $form->renderForm();
    }

    public function create(FormBuilder $formBuilder, Request $request, BaseHttpResponse $response)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::message-categories.create'));

        if ($request->ajax()) {
            return $response->setData($this->getForm());
        }

        return $formBuilder->create(MessageCategoryForm::class)->renderForm();
    }

    public function store(MessageCategoryRequest $request, BaseHttpResponse $response)
    {
        $messageCategory = MessageCategory::query()->create($request->input());

        event(new CreatedContentEvent(PRODUCT_CATEGORY_MODULE_SCREEN_NAME, $request, $messageCategory));

        if ($request->ajax()) {
            $messageCategory = MessageCategory::query()->findOrFail($messageCategory->id);

            if ($response->isSaving()) {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($messageCategory);
            }

            $response->setData([
                'model' => $messageCategory,
                'form' => $form,
            ]);
        }

        return $response
            ->setPreviousUrl(route('message-categories.index'))
            ->setNextUrl(route('message-categories.edit', $messageCategory->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(
        MessageCategory $messageCategory,
        FormBuilder $formBuilder,
        Request $request,
        BaseHttpResponse $response
    ) {
        if ($request->ajax()) {
            return $response->setData($this->getForm($messageCategory));
        }

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $messageCategory->name]));

        return $formBuilder->create(MessageCategoryForm::class, ['model' => $messageCategory])->renderForm();
    }

    public function update(
        MessageCategory $messageCategory,
        MessageCategoryRequest $request,
        BaseHttpResponse $response
    ) {
        $messageCategory->fill($request->input());
        $messageCategory->save();

        event(new UpdatedContentEvent(PRODUCT_CATEGORY_MODULE_SCREEN_NAME, $request, $messageCategory));

        if ($request->ajax()) {
            if ($response->isSaving()) {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($messageCategory);
            }

            $response->setData([
                'model' => $messageCategory,
                'form' => $form,
            ]);
        }

        return $response
            ->setPreviousUrl(route('message-categories.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(MessageCategory $messageCategory, Request $request, BaseHttpResponse $response)
    {
        try {
            $messageCategory->delete();
            event(new DeletedContentEvent(PRODUCT_CATEGORY_MODULE_SCREEN_NAME, $request, $messageCategory));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    protected function getForm(?MessageCategory $model = null): string
    {
        $options = ['template' => 'core/base::forms.form-no-wrap'];
        if ($model) {
            $options['model'] = $model;
        }

        $form = app(FormBuilder::class)->create(MessageCategoryForm::class, $options);

        $form = $this->setFormOptions($form, $model);

        return $form->renderForm();
    }

    protected function setFormOptions(FormAbstract $form, ?MessageCategory $model = null, array $options = [])
    {
        if (! $model) {
            $form->setUrl(route('message-categories.create'));
        }

        if (! Auth::user()->hasPermission('message-categories.create') && ! $model) {
            $class = $form->getFormOption('class');
            $form->setFormOption('class', $class . ' d-none');
        }

        $form->setFormOptions($this->getOptions($options));

        return $form;
    }

    protected function getOptions(array $options = []): array
    {
        return array_merge([
            'canCreate' => Auth::user()->hasPermission('message-categories.create'),
            'canEdit' => Auth::user()->hasPermission('message-categories.edit'),
            'canDelete' => Auth::user()->hasPermission('message-categories.destroy'),
            'createRoute' => 'message-categories.create',
            'editRoute' => 'message-categories.edit',
            'deleteRoute' => 'message-categories.destroy',
        ], $options);
    }

    public function getSearch(Request $request, BaseHttpResponse $response)
    {
        $term = $request->input('search');

        $categories = MessageCategory::query()
            ->select(['id', 'name'])
            ->where('name', 'LIKE', '%' . $term . '%')
            ->paginate(10);

        $data = MessageCategoryResource::collection($categories);

        return $response->setData($data)->toApiResponse();
    }

    public function getListForSelect(BaseHttpResponse $response)
    {
        $categories = MessageCategory::query()
            ->toBase()
            ->select([
                'id',
                'name',
                'parent_id',
            ])
            ->orderByDesc('created_at')
            ->orderBy('order')
            ->get();

        return $response->setData($this->buildTree($categories->groupBy('parent_id')));
    }

    protected function buildTree(
        Collection $categories,
        Collection $tree = null,
        int|string $parentId = 0,
        string $indent = null
    ): Collection {
        if ($tree === null) {
            $tree = collect();
        }

        $currentCategories = $categories->get($parentId);

        if ($currentCategories) {
            foreach ($currentCategories as $category) {
                $tree->push([
                    'id' => $category->id,
                    'name' => $indent . ' ' . $category->name,
                ]);

                if ($categories->has($category->id)) {
                    $this->buildTree($categories, $tree, $category->id, $indent . '&nbsp;&nbsp;');
                }
            }
        }

        return $tree;
    }
}
