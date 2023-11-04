@php
    $layout = MetaBox::getMetaData($post, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'blog-post-right-sidebar';
    Theme::layout($layout);
    Theme::asset()->container('footer')->usePath()->add('magic-popup', 'js/plugins/magnific-popup.js');
@endphp

@if (Str::endsWith($layout, ['full-width', 'right-sidebar', 'left-sidebar']))
    <div class="single-page pt-50 pr-30">
        <div class="single-header style-2">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    @if ($post->first_category && $post->first_category->name)
                        <p class="mb-10 font-heading h6">
                            <a href="{{ $post->first_category->url }}">{{ $post->first_category->name }}</a>
                        </p>
                    @endif
                    <h2 class="mb-10">{{ $post->name }}</h2>
                    <div class="single-header-meta">
                        <div class="entry-meta meta-1 font-xs mt-15 mb-15">
                            <span class="author-avatar">
                                <img class="img-circle" src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}">
                            </span>
                            <span class="post-by">{{ __('By :name', ['name' => $post->author->name]) }}</span>
                            <span class="post-on has-dot">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($post->image)
            <figure class="single-thumbnail">
                <img src="{{ RvMedia::getImageUrl($post->image) }}" alt="{{ $post->name }}">
            </figure>
        @endif
        <div class="single-content">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="ck-content">{!! BaseHelper::clean($post->content) !!}</div>
                    <br>
                    {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}

                    <!--Entry bottom-->
                    <div class="entry-bottom mt-50 mb-30">
                        <div class="tags w-50 w-sm-100">
                            @if (!$post->tags->isEmpty())
                                @foreach ($post->tags as $tag)
                                    <a href="{{ $tag->url }}" rel="tag" class="hover-up btn btn-sm btn-rounded mr-10 mt-10">{{ $tag->name }}</a>
                                @endforeach
                            @endif
                        </div>
                        {!! Theme::partial('social-share', ['url' => $post->url, 'description' => $post->description]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
