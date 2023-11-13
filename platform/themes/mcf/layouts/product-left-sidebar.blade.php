@php
    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/plugins/jquery.theia.sticky.js');
@endphp

{!! Theme::partial('header') !!}

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif

    <div class="container mb-30">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="row flex-row-reverse">
                    <div class="col-xl-9">
                        {!! Theme::content() !!}
                    </div>
                    <div class="col-xl-3 primary-sidebar sticky-sidebar mt-30">
                        <div class="widget-area">
                            {!! dynamic_sidebar('product_sidebar') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

{!! Theme::partial('footer') !!}
