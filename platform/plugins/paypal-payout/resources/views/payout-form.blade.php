@if ($data->canEditStatus() && !$data->transaction_id)
    <a
        class="btn btn-warning btn-payout-button"
        href="{{ route('paypal-payout.make', $data->id) }}"
    ><i class="fab fa-paypal"></i> {{ __('Process payout') }}</a>
@else
    <div
        id="payout-transaction-detail"
        data-url="{{ route('paypal-payout.retrieve', $data->transaction_id) }}"
    >
        @include('core/base::elements.loading')
    </div>
@endif
