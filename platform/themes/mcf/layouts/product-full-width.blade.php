{!! Theme::partial('header') !!}

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif

    <div class="container mb-30">
        <div class="row">
            <div class="col-lg-12 m-auto">
                {!! Theme::content() !!}
            </div>
        </div>
    </div>
</main>

{!! Theme::partial('footer') !!}
