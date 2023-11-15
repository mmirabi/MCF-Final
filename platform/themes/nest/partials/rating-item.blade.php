@if (EcommerceHelper::isReviewEnabled())
    <div class="product-rate d-inline-block" @if (! $ratingCount) style="visibility: hidden" @endif>
        <div class="product-rating" style="width: {{ $ratingAvg * 20 }}%"></div>
    </div>
@endif
