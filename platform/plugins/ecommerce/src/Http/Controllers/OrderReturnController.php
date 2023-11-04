<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\OrderReturnStatusEnum;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\OrderReturnHelper;
use Botble\Ecommerce\Http\Requests\UpdateOrderReturnRequest;
use Botble\Ecommerce\Models\OrderReturn;
use Botble\Ecommerce\Tables\OrderReturnTable;
use Exception;
use Illuminate\Http\Request;

class OrderReturnController extends BaseController
{
    public function index(OrderReturnTable $orderReturnTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::order.order_return'));

        return $orderReturnTable->renderTable();
    }

    public function edit(OrderReturn $orderReturn)
    {
        Assets::addStylesDirectly(['vendor/core/plugins/ecommerce/css/ecommerce.css'])
            ->addScriptsDirectly([
                'vendor/core/plugins/ecommerce/libraries/jquery.textarea_autosize.js',
                'vendor/core/plugins/ecommerce/js/order.js',
            ])
            ->addScripts(['blockui', 'input-mask']);

        if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation()) {
            Assets::addScriptsDirectly('vendor/core/plugins/location/js/location.js');
        }

        PageTitle::setTitle(trans('plugins/ecommerce::order.edit_order_return', ['code' => $orderReturn->code]));

        $defaultStore = get_primary_store_locator();

        return view('plugins/ecommerce::order-returns.edit', ['returnRequest' => $orderReturn, 'defaultStore' => $defaultStore]);
    }

    public function update(OrderReturn $orderReturn, UpdateOrderReturnRequest $request, BaseHttpResponse $response)
    {
        $data['return_status'] = $request->input('return_status');

        if (in_array($orderReturn->return_status, [$data['return_status'], OrderReturnStatusEnum::CANCELED, OrderReturnStatusEnum::COMPLETED])) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/ecommerce::order.notices.update_return_order_status_error'));
        }

        [$status, $orderReturn] = OrderReturnHelper::updateReturnOrder($orderReturn, $data);

        if (! $status) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/ecommerce::order.notices.update_return_order_status_error'));
        }

        return $response
            ->setNextUrl(route('order_returns.edit', $orderReturn->getKey()))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(OrderReturn $orderReturn, Request $request, BaseHttpResponse $response)
    {
        try {
            $orderReturn->delete();

            event(new DeletedContentEvent(ORDER_RETURN_MODULE_SCREEN_NAME, $request, $orderReturn));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
