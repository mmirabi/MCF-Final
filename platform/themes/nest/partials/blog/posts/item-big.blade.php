<article class="first-post mb-30 hover-up animated" style="visibility: visible">
    <div class="position-relative overflow-hidden">
        <div class="post-thumb border-radius-15">
            <a href="{{ $post->url }}">
                <img class="border-radius-15" src="{{ RvMedia::getImageUrl($post->image, null, false, RvMedia::getDefaultImage()) }}" alt="{{ $post->name }}" />
            </a>
        </div>
    </div>
    <div class="entry-content">
        <h2 class="post-title mb-20 text-truncate">
            <a href="{{ $post->url }}" title="{{ $post->name }}">{{ $post->name }}</a>
        </h2>
        <p class="post-exerpt font-medium text-muted mb-30">{{ $post->description }}</p>
        <div class="mb-20 entry-meta meta-2">
            <div class="entry-meta meta-1 mb-30">
                <div class="font-sm">
                    <span><span class="post-on mr-10"><i class="fi-rs-calendar"></i></span> {{ $post->created_at->translatedFormat('d M Y') }}</span>
                    <span><span class="mr-10 text-muted"><i class="fi-rs-eye"></i></span>{{ number_format($post->views) }}</span>
                </div>
            </div>
            <a href="{{ $post->url }}" class="btn btn-sm">{{ __('Read more') }}<i class="fi-rs-arrow-right ml-10"></i></a>
        </div>
    </div>
</article>
