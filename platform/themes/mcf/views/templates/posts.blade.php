@if ($posts->count() > 0)
    <div class="shop-product-filter mb-50 pr-30">
        <div class="total-product">
            <h2>
                @if (theme_option('blog_page_icon'))
                    <img class="w-36px mr-10" src="{{ RvMedia::getImageUrl(theme_option('blog_page_icon')) }}" alt="{{ SeoHelper::getTitle() }}" />
                @endif
                {{ SeoHelper::getTitle() }}
            </h2>
        </div>
    </div>
    @php
        $partial = 'item-grid';
        $className = 'pr-30';
        $hasRowWrapper = true;
        switch (Theme::getLayoutName()) {
            case 'blog-big':
                $partial = 'item-big';
                $className = 'loop-big';
                break;
            case 'blog-wide':
                $partial = 'item-wide';
                $className = '';
                break;
            case 'blog-list':
                $partial = 'item-list';
                $className = 'loop-list pr-30 mb-50';
                $hasRowWrapper = false;
                break;
        }
    @endphp
    <div class="loop-grid {{ $className }}">
        @if ($hasRowWrapper) <div class="row"> @endif
            @foreach ($posts as $post)
                {!! Theme::partial('blog.posts.' . $partial, compact('post')) !!}
            @endforeach
        @if ($hasRowWrapper) </div> @endif
    </div>

    {!! $posts->withQueryString()->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}
@endif
