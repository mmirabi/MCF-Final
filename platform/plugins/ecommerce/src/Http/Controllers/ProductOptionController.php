<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\GlobalOptionEnum;
use Botble\Ecommerce\Forms\GlobalOptionForm;
use Botble\Ecommerce\Http\Requests\GlobalOptionRequest;
use Botble\Ecommerce\Models\GlobalOption;
use Botble\Ecommerce\Models\GlobalOptionValue;
use Botble\Ecommerce\Tables\GlobalOptionTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductOptionController extends BaseController
{
    public function index(GlobalOptionTable $table)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::product-option.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::product-option.create'));

        return $formBuilder->create(GlobalOptionForm::class)->renderForm();
    }

    public function store(GlobalOptionRequest $request, BaseHttpResponse $response)
    {
        $option = GlobalOption::query()->create($request->only(['name', 'option_type', 'required']));

        $optionValues = $this->formatOptionValue($request->input());

        $option->values()->whereNotIn('id', collect($optionValues)->pluck('id')->all())->delete();
        $option->values()->saveMany($optionValues);

        event(new CreatedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));

        return $response
            ->setPreviousUrl(route('global-option.index'))
            ->setNextUrl(route('global-option.edit', $option->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int|string $id, FormBuilder $formBuilder, Request $request)
    {
        $option = GlobalOption::query()->with(['values'])->findOrFail($id);

        event(new BeforeEditContentEvent($request, $option));

        PageTitle::setTitle(trans('plugins/ecommerce::product-option.edit', ['name' => $option->name]));

        return $formBuilder->create(GlobalOptionForm::class, ['model' => $option])->renderForm();
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $option = GlobalOption::query()->findOrFail($id);

            $option->delete();

            event(new DeletedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function update(int|string $id, GlobalOptionRequest $request, BaseHttpResponse $response)
    {
        $option = GlobalOption::query()->findOrFail($id);

        $option->fill($request->only(['name', 'option_type', 'required']));
        $option->save();

        $optionValues = $this->formatOptionValue($request->input());

        $option->values()->whereNotIn('id', collect($optionValues)->pluck('id')->all())->delete();
        $option->values()->saveMany($optionValues);

        event(new UpdatedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));

        return $response
            ->setPreviousUrl(route('global-option.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function ajaxInfo(Request $request, BaseHttpResponse $response): BaseHttpResponse
    {
        $optionsValues = GlobalOption::query()->with(['values'])->findOrFail($request->input('id'));

        return $response->setData($optionsValues);
    }

    protected function formatOptionValue(array $data): array
    {
        $type = explode('\\', $data['option_type']);
        $type = end($type);
        $values = [];

        $textTypeArr = ['Field'];

        if (in_array($type, $textTypeArr)) {
            $globalOptionValue = new GlobalOptionValue();
            $item['affect_price'] = $data['affect_price'] ?? 0;
            $item['affect_type'] = $data['affect_type'] ?? GlobalOptionEnum::TYPE_PERCENT;
            $item['option_value'] = 'n/a';
            $globalOptionValue->fill($item);
            $values[] = $globalOptionValue;

            return $values;
        }

        $index = 0;

        foreach (Arr::get($data, 'options', []) as $item) {
            $globalOptionValue = null;
            if (! empty($item['id'])) {
                $globalOptionValue = GlobalOptionValue::query()->find($item['id']);
            }

            if (! $globalOptionValue) {
                $globalOptionValue = new GlobalOptionValue();
            }

            $item['affect_price'] = ! empty($item['affect_price']) ? $item['affect_price'] : 0;
            $item['order'] = $index;
            $globalOptionValue->fill($item);
            $values[] = $globalOptionValue;

            $index++;
        }

        return $values;
    }
}
