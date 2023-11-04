<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\TaxRuleForm;
use Botble\Ecommerce\Http\Requests\TaxRuleRequest;
use Botble\Ecommerce\Models\Tax;
use Botble\Ecommerce\Models\TaxRule;
use Botble\Ecommerce\Tables\TaxRuleTable;
use Exception;
use Illuminate\Http\Request;

class TaxRuleController extends BaseController
{
    public function index(Tax $tax, TaxRuleTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::tax.rule.name', ['title' => $tax->title]));

        return $dataTable->renderTable();
    }

    public function create(Request $request, FormBuilder $formBuilder, BaseHttpResponse $response)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::tax.rule.create'));

        $form = $formBuilder->create(TaxRuleForm::class)->renderForm();
        if ($request->ajax()) {
            return $response
                ->setData(['html' => $form])
                ->setMessage(PageTitle::getTitle(false));
        }

        return $form;
    }

    public function store(TaxRuleRequest $request, BaseHttpResponse $response)
    {
        $rule = TaxRule::query()->create($request->input());

        event(new CreatedContentEvent(TAX_RULE_MODULE_SCREEN_NAME, $request, $rule));

        return $response
            ->setPreviousUrl(route('tax.rule.index', $rule->tax_id))
            ->setNextUrl(route('tax.rule.edit', $rule->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(TaxRule $rule, TaxRuleRequest $request, FormBuilder $formBuilder, BaseHttpResponse $response)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::tax.rule.edit', ['title' => '#' . $rule->id]));

        $form = $formBuilder->create(TaxRuleForm::class, ['model' => $rule])->renderForm();

        if ($request->ajax()) {
            return $response
                ->setData(['html' => $form])
                ->setMessage(PageTitle::getTitle(false));
        }

        return $form;
    }

    public function update(TaxRule $rule, TaxRuleRequest $request, BaseHttpResponse $response)
    {
        $rule->fill($request->input());
        $rule->save();

        event(new UpdatedContentEvent(TAX_RULE_MODULE_SCREEN_NAME, $request, $rule));

        return $response
            ->setPreviousUrl(route('tax.rule.index', $rule->tax_id))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(TaxRule $rule, Request $request, BaseHttpResponse $response)
    {
        try {
            $rule->delete();
            event(new DeletedContentEvent(TAX_RULE_MODULE_SCREEN_NAME, $request, $rule));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
