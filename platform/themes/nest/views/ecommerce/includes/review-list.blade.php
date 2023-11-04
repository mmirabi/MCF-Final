<div class="block__content comment-list">
    @foreach ($reviews as $review)
        <div class="block--review single-comment justify-content-between d-flex mb-30  @if($loop->index % 2 == 0) ml-30 @endif">
            <div class="user justify-content-between d-flex">
                <div class="thumb text-center">
                    <img src="{{ $review->user->avatar_url }}"
                         alt="{{ $review->user->name }}" />
                    <span class="font-heading text-brand d-block">{{ $review->user->name }}</span>
                </div>
                <div class="desc">
                    <div class="d-flex justify-content-between mb-10">
                        <div>
                            <time class="font-sm text-muted" datetime="{{ $review->created_at->translatedFormat('Y-m-d\TH:i:sP') }}">{{ $review->created_at->diffForHumans() }}</time>
                                @if ($review->order_created_at)
                                    <span
                                        class="ms-2">{{ __('✅ Purchased :time', ['time' => $review->order_created_at->diffForHumans()]) }}</span>
                                @endif
                        </div>
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: {{ $review->star * 20 }}%"></div>
                        </div>
                    </div>
                    <p class="mb-10">{{ $review->comment }}</p>

                    @if ($review->images && count($review->images))
                        <div class="block__images">
                            @foreach ($review->images as $image)
                                <a href="{{ RvMedia::getImageUrl($image) }}">
                                    <img
                                        class="img-responsive rounded h-100"
                                        src="{{ RvMedia::getImageUrl($image, 'thumb') }}"
                                        alt="{{ $review->comment }}"
                                    >
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <div class="pagination">
        {!! $reviews->withQueryString()->links(Theme::getThemeNamespace('partials.custom-pagination')) !!}
    </div>
</div>
