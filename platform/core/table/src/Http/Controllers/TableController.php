<?php

namespace Botble\Table\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Base\Facades\Form;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Http\Requests\BulkChangeRequest;
use Botble\Table\Http\Requests\DispatchBulkActionRequest;
use Botble\Table\Http\Requests\FilterRequest;
use Botble\Table\Http\Requests\SaveBulkChangeRequest;
use Botble\Table\TableBuilder;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TableController extends Controller
{
    public function __construct(protected TableBuilder $tableBuilder)
    {
    }

    public function getDataForBulkChanges(BulkChangeRequest $request): array
    {
        $class = $request->input('class');

        if (! class_exists($class)) {
            return [];
        }

        $object = $this->tableBuilder->create($class);

        $data = $object->getValueInput(null, null, 'text');

        $key = $request->input('key');

        if (! $key) {
            return $data;
        }

        $column = Arr::get($object->getAllBulkChanges(), $key);
        if (empty($column)) {
            return $data;
        }

        if (isset($column['callback'])) {
            $callback = $column['callback'];

            if (is_callable($callback)) {
                $data = $object->getValueInput(
                    $column['title'],
                    null,
                    $column['type'],
                    $callback()
                );
            } elseif (method_exists($object, $callback)) {
                $data = $object->getValueInput(
                    $column['title'],
                    null,
                    $column['type'],
                    call_user_func([$object, $callback])
                );
            }
        } else {
            $data = $object->getValueInput($column['title'], null, $column['type'], Arr::get($column, 'choices', []));
        }

        if (! empty($column['title'])) {
            $labelClass = config('laravel-form-builder.label_class');
            if (Str::contains(Arr::get($column, 'validate'), 'required')) {
                $labelClass .= ' required';
            }

            $data['html'] = Form::label($column['title'], null, ['class' => $labelClass])->toHtml() . $data['html'];
        }

        return $data;
    }

    public function postSaveBulkChange(SaveBulkChangeRequest $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/table::table.please_select_record'));
        }

        $inputKey = $request->input('key');
        $inputValue = $request->input('value');

        $class = $request->input('class');

        if (! class_exists($class)) {
            return $response->setError();
        }

        $object = $this->tableBuilder->create($class);

        $columns = $object->getAllBulkChanges();

        if (! empty($columns[$inputKey]['validate'])) {
            $validator = Validator::make($request->input(), [
                'value' => $columns[$inputKey]['validate'],
            ]);

            if ($validator->fails()) {
                return $response
                    ->setError()
                    ->setMessage($validator->messages()->first());
            }
        }

        try {
            $object->saveBulkChanges($ids, $inputKey, $inputValue);
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }

        return $response->setMessage(trans('core/table::table.save_bulk_change_success'));
    }

    public function postDispatchBulkAction(DispatchBulkActionRequest $request, BaseHttpResponse $response): BaseHttpResponse
    {
        if (
            ! class_exists($request->input('bulk_action_table')) ||
            ! class_exists($request->input('bulk_action_target'))
        ) {
            return $response
                ->setError()
                ->setMessage(trans('core/table::invalid_bulk_action'));
        }

        try {
            /**
             * @var TableAbstract $table
             */
            $table = app()->make($request->input('bulk_action_table'));

            abort_unless($table instanceof TableAbstract, 400);

            return $table->dispatchBulkAction();
        } catch (BindingResolutionException) {
            return $response
                ->setError()
                ->setMessage(__('Something went wrong.'));
        }
    }

    public function getFilterInput(FilterRequest $request)
    {
        $class = $request->input('class');

        if (! class_exists($class)) {
            return [];
        }

        $key = $request->input('key');

        $object = $this->tableBuilder->create($class);

        $data = $object->getValueInput(null, null, 'text');

        if (! $key) {
            return $data;
        }

        $column = Arr::get($object->getFilters(), $key);
        if (empty($column)) {
            return $data;
        }

        $value = $request->input('value');

        $choices = Arr::get($column, 'choices', []);

        if (isset($column['callback'])) {
            $callback = $column['callback'];

            if (is_callable($callback)) {
                $choices = $callback($value);
            } elseif (method_exists($object, $callback)) {
                $choices = call_user_func_array([$object, $callback], [$value]);
            }
        }

        return $object->getValueInput(
            null,
            $value,
            $column['type'],
            $choices
        );
    }
}
