{!! Form::open(['url' => $url]) !!}

<div class="next-form-section">
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <div class="table-wrap p-none">
                <table class="table border-bottom mb0">
                    <thead>
                        <tr>
                            <th class="text-start">{{ trans('plugins/ecommerce::products.form.product') }}</th>
                            <th class="text-center">{{ trans('plugins/ecommerce::products.form.price') }}</th>
                            <th class="text-center">{{ trans('plugins/ecommerce::products.form.quantity') }}</th>
                            <th class="text-center">{{ trans('plugins/ecommerce::products.form.restock_quantity') }}</th>
                            <th class="text-center">{{ trans('plugins/ecommerce::products.form.remain') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $orderProduct)
                            @php
                                $product = $orderProduct->product->original_product;
                            @endphp
                            <tr>
                                <td class="text-start width-300-px">
                                    <a
                                        class="text-underline wordwrap"
                                        href="{{ $product && $product->id && Auth::user()->hasPermission('products.edit') ? route('products.edit', $product->id) : '#' }}"
                                        title="{{ $orderProduct->product_name }}"
                                        target="_blank"
                                    >{{ $orderProduct->product_name }}</a>
                                </td>
                                <td class="text-center">
                                    <span>{{ format_price($orderProduct->price) }}</span>
                                </td>
                                <td class="text-center">{{ $orderProduct->qty }}</td>
                                <td class="text-center">{{ $orderProduct->restock_quantity }}</td>
                                <td class="text-end">
                                    @if ($orderProduct->qty - $orderProduct->restock_quantity > 0)
                                        <input
                                            class="j-refund-quantity width-50-px pl5 m-auto next-input p-none-r"
                                            name="products[{{ $orderProduct->product_id }}]"
                                            type="number"
                                            value="{{ $orderProduct->qty - $orderProduct->restock_quantity }}"
                                            min="0"
                                        />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-wrap p-none">
                <table class="refund-totals">
                    <tbody>
                        @if ($order->products->sum('qty') - $order->products->sum('restock_quantity') > 0)
                            <tr>
                                <td
                                    class="text-end"
                                    colspan="2"
                                >
                                    <label class="next-label inline mt10">

                                        <input
                                            type="checkbox"
                                            checked
                                        >
                                        <span>
                                            {{ trans('plugins/ecommerce::order.return') }} <span
                                                class="total-restock-items"
                                            >{{ $order->products->sum('qty') - $order->products->sum('restock_quantity') }}</span>
                                            {{ trans('plugins/ecommerce::order.products') }}
                                        </span>
                                    </label>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-end">{{ trans('plugins/ecommerce::products.form.shipping_fee') }}</td>
                            <td class="text-end quantity">
                                <span>{{ format_price($order->shipping_amount) }}</span>
                            </td>
                        </tr>
                        @if (is_plugin_active('payment') && $order->payment->refunded_amount)
                            <tr>
                                <td class="text-end">{{ trans('plugins/ecommerce::order.total_refund_amount') }}:</td>
                                <td class="text-end quantity text-no-bold">
                                    <span>{{ format_price($order->payment->refunded_amount) }}</span>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-end">{{ trans('plugins/ecommerce::order.total_amount_can_be_refunded') }}:
                            </td>
                            <td class="text-end quantity text-no-bold">
                                @if (!is_plugin_active('payment') || $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::PENDING)
                                    <span>{{ format_price(0) }}</span>
                                @else
                                    <span>{{ format_price($order->payment->amount - $order->payment->refunded_amount) }}</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @if (is_plugin_active('payment') &&
                    $order->payment->status !== \Botble\Payment\Enums\PaymentStatusEnum::PENDING &&
                    $order->payment->amount - $order->payment->refunded_amount > 0)
                <div class="table-wrapper p-none">
                    <table class="refund-payments">
                        <tbody>
                            <tr>
                                <td class="p-xs">
                                    <label class="ws-nm mb0">
                                        <i class="fa-cash-small"></i>
                                        <span class="ml5 v-a-t">{{ $order->payment->payment_channel->label() }}</span>
                                    </label>
                                    @if (get_payment_is_support_refund_online($order->payment))
                                        <label class="help-block d-block">
                                            {{ trans('plugins/ecommerce::order.payment_method_refund_automatic', [
                                                'method' => $order->payment->payment_channel->label(),
                                            ]) }}
                                        </label>
                                    @endif
                                </td>
                                <td class="p-xs width-150-px">
                                    <div class="next-input--stylized">
                                        <input
                                            class="next-input next-input--invisible input-mask-number input-sync-item"
                                            name="refund_amount"
                                            data-thousands-separator="{{ EcommerceHelper::getThousandSeparatorForInputMask() }}"
                                            data-decimal-separator="{{ EcommerceHelper::getDecimalSeparatorForInputMask() }}"
                                            data-target=".refund-amount-text"
                                            type="text"
                                            value="{{ $order->payment->amount - $order->payment->refunded_amount }}"
                                        >
                                        <span
                                            class="next-input-add-on next-input__add-on--before">{{ get_application_currency()->symbol }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="next-form-devide-hr"></div>
    <div class="next-form-grid">
        <div class="next-form-grid-cell">
            <label
                class="text-title-field"
                for="refund-note"
            >{{ trans('plugins/ecommerce::order.refund_reason') }}</label>
            <div>
                <input
                    class="next-input"
                    id="refund-note"
                    name="refund_note"
                    type="text"
                    value="{{ $order->payment->refund_note }}"
                >
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
