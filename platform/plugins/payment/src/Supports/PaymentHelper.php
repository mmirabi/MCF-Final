<?php

namespace Botble\Payment\Supports;

use Botble\Base\Models\BaseQueryBuilder;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PaymentHelper
{
    public static function getRedirectURL(?string $checkoutToken = null): string
    {
        return apply_filters(PAYMENT_FILTER_REDIRECT_URL, $checkoutToken, route('public.index'));
    }

    public static function getCancelURL(?string $checkoutToken = null): string
    {
        return apply_filters(PAYMENT_FILTER_CANCEL_URL, $checkoutToken, route('public.index'));
    }

    public static function storeLocalPayment(array $args = []): Model|bool|BaseQueryBuilder
    {
        $data = array_merge([
            'user_id' => Auth::check() ? Auth::id() : 0,
        ], $args);

        $orderIds = (array)$data['order_id'];

        $payment = Payment::query()
            ->where('charge_id', $data['charge_id'])
            ->whereIn('order_id', $orderIds)
            ->first();

        if ($payment) {
            return false;
        }

        $paymentChannel = Arr::get($data, 'payment_channel', PaymentMethodEnum::COD);

        return Payment::query()->create([
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'charge_id' => $data['charge_id'],
            'order_id' => Arr::first($orderIds),
            'customer_id' => Arr::get($data, 'customer_id'),
            'customer_type' => Arr::get($data, 'customer_type'),
            'payment_channel' => $paymentChannel,
            'status' => Arr::get($data, 'status', PaymentStatusEnum::PENDING),
        ]);
    }

    public static function formatLog(array $input, string|int $line = '', string $function = '', string $class = ''): array
    {
        return array_merge($input, [
            'user_id' => Auth::check() ? Auth::id() : 0,
            'ip' => Request::ip(),
            'line' => $line,
            'function' => $function,
            'class' => $class,
            'userAgent' => Request::header('User-Agent'),
        ]);
    }

    public static function defaultPaymentMethod(): string
    {
        return setting('default_payment_method', PaymentMethodEnum::COD);
    }
}
