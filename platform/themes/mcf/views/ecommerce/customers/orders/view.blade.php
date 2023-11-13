@extends(Theme::getThemeNamespace() . '::views.ecommerce.customers.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="customer-order-detail">
            @include('plugins/ecommerce::themes.includes.order-tracking-detail')

            <div class="mt-4 row">
                @if ($order->isInvoiceAvailable())
                    <div class="col-auto me-auto">
                        <a href="{{ route('customer.print-order', $order->id) }}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Download invoice') }}</a>
                    </div>
                @endif
                @if ($order->canBeCanceled())
                    <div class="col-auto">
                        <a href="{{ route('customer.orders.cancel', $order->id) }}"
                            onclick="return confirm('{{ __('Are you sure?') }}')"
                            class="btn btn-danger btn-sm ml-2">{{ __('Cancel order') }}</a>
                    </div>
                @endif
                @if ($order->canBeReturned())
                    <div class="col-auto">
                        <a href="{{ route('customer.order_returns.request_view', $order->id) }}"
                           class="btn btn-danger btn-sm ml-2">
                            {{ __('Return Product(s)') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
