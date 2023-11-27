<div class="row promo coupon coupon-section">
    <div class="row">
        <div class="col">
            <input
                class="form-control coupon-code input-md"
                name="coupon_code"
                type="text"
                value="{{ old('coupon_code') }}"
                placeholder="{{ __('Enter coupon code...') }}"
            >
            <div class="coupon-error-msg">
                <span class="text-danger"></span>
            </div>
        </div>  
    </div>

    <div class="row">
        <div class="col d-grid gap-2 col-6 mx-auto" style="margin-top:20px; width: 100%;">
            <button
                class="btn mb-20 w-100"
                data-url="{{ route('public.coupon.apply') }}"
                type="button"
                style="margin-top: 0;padding: 10px 20px;><i class="
            ><i class="fa fa-gift"></i> {{ __('Apply') }}</button>
        </div>
    </div>
</div>
