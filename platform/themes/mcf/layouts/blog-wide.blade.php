@php
    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/plugins/jquery.theia.sticky.js');
    Theme::asset()->usePath()->add('magnific-popup-css', 'css/plugins/magnific-popup.css');
    Theme::asset()->container('footer')->usePath()->add('magnific-popup-js', 'js/plugins/magnific-popup.js', ['jquery']);
@endphp

{!! Theme::partial('header') !!}

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb', ['big' => true, 'background' => theme_option('blog_page_background')]) !!}
    @endif

    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                {!! Theme::content() !!}
            </div>
        </div>
    </div>
</main>
{!! Theme::partial('footer') !!}
