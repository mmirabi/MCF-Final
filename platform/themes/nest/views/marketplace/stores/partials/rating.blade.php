@if (EcommerceHelper::isReviewEnabled())
    <div class="product-rate-cover">
        <div class="product-rate d-inline-block">
            <div class="product-rating" style="width: {{ $store->reviews->avg('star') * 20 }}%"></div>
        </div>
        <span class="font-small ml-5 text-muted"> ({{ $store->reviews->count() }})</span>
    </div>
@endif
