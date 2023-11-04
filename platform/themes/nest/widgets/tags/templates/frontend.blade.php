@if (is_plugin_active('blog'))
    <div class="sidebar-widget widget-tags mb-50 pb-10">
        <h5 class="section-title style-1 mb-30">{{ $config['name'] }}</h5>
        <ul class="tags-list">
            @foreach (get_popular_tags($config['number_display'], ['slugable'], ['posts']) as $tag)
                <li class="hover-up">
                    <a href="{{ $tag->url }}"><i class="fi-rs-cross mr-10"></i>{{ $tag->name }}</a>
                </li>
            @endforeach
        </div>
    </div>
@endif
