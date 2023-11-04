<div class="price-filter range">
    <div class="price-filter-inner">
        <div class="slider-range"></div>
        <input type="hidden"
               class="min_price min-range"
               name="min_price"
               value="{{ BaseHelper::stringify(request()->input('min_price', 0)) }}"
               data-min="0"
               data-label="{{ __('Min price') }}"/>
        <input type="hidden"
               class="min_price max-range"
               name="max_price"
               value="{{ BaseHelper::stringify(request()->input('max_price', $maxFilterPrice)) }}"
               data-max="{{ $maxFilterPrice }}"
               data-label="{{ __('Max price') }}"/>
        <div class="price_slider_amount">
            <div class="label-input">
                <span class="d-inline-block">{{ __('Range:') }} </span>
                <span class="from d-inline-block"></span>
                <span class="to d-inline-block"></span>
            </div>
        </div>
    </div>
</div>
