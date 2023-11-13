@php
    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/plugins/jquery.theia.sticky.js');
    Theme::asset()->usePath()->add('magnific-popup-css', 'css/plugins/magnific-popup.css');
    Theme::asset()->container('footer')->usePath()->add('magnific-popup-js', 'js/plugins/magnific-popup.js', ['jquery']);
@endphp

{!! Theme::partial('header') !!}

<main class="main pages" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif
    <div class="page-content pt-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="row">
                        <div class="col-lg-9">
                            {!! Theme::content() !!}
                        </div>
                        <div class="col-lg-3 primary-sidebar sticky-sidebar">
                            <div class="widget-area">
                                {!! dynamic_sidebar('primary_sidebar') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{!! Theme::partial('footer') !!}
