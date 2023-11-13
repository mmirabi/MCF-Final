<article class="wow fadeIn animated hover-up mb-30 animated">
    <div class="post-thumb" style="background-image: url({{ RvMedia::getImageUrl($post->image, 'medium', false, RvMedia::getDefaultImage()) }})"></div>
    <div class="entry-content-2 pl-50">
        <h3 class="post-title mb-20">
            <a href="{{ $post->url }}">{!! BaseHelper::clean($post->name) !!}</a>
        </h3>
        <p class="post-exerpt mb-40">{{ $post->description }}</p>
        <div class="entry-meta meta-1 font-xs color-grey mt-10 pb-10">
            <div>
                <span class="post-on mr-10">{{ $post->created_at->translatedFormat('d M Y') }}</span>
                <span class="hit-count has-dot mr-10">{{ __(':count Views', ['count' => number_format($post->views)]) }}</span>
            </div>
            <a href="{{ $post->url }}" class="text-brand font-heading font-weight-bold">{{ __('Read more') }} <i class="fi-rs-arrow-right"></i></a>
        </div>
    </div>
</article>
