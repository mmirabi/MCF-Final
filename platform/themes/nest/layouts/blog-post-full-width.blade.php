{!! Theme::partial('header') !!}

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif

    <div class="page-content mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 m-auto">
                    {!! Theme::content() !!}
                </div>
            </div>
        </div>
    </div>
</main>
{!! Theme::partial('footer') !!}
