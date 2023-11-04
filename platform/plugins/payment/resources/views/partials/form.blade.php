@include('plugins/payment::partials.header')

<div class="checkout-wrapper">
    <div>
        <form
            class="payment-checkout-form"
            action="{{ $action }}"
            method="post"
        >
            @csrf
            <input
                name="name"
                type="hidden"
                value="{{ $name }}"
            >
            <input
                name="amount"
                type="hidden"
                value="{{ $amount }}"
            >
            <input
                name="currency"
                type="hidden"
                value="{{ $currency }}"
            >
            @if (isset($returnUrl))
                <input
                    name="return_url"
                    type="hidden"
                    value="{{ $returnUrl }}"
                >
            @endif
            @if (isset($callbackUrl))
                <input
                    name="callback_url"
                    type="hidden"
                    value="{{ $callbackUrl }}"
                >
            @endif

            {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}

            @include('plugins/payment::partials.payment-methods')

            {!! apply_filters(PAYMENT_FILTER_AFTER_PAYMENT_METHOD, null) !!}

            <br>
            <div class="text-center">
                <button
                    class="payment-checkout-btn btn btn-info"
                    data-processing-text="{{ __('Processing. Please wait...') }}"
                    data-error-header="{{ __('Error') }}"
                >{{ __('Checkout') }}</button>
            </div>
        </form>
    </div>
</div>

@include('plugins/payment::partials.footer')
