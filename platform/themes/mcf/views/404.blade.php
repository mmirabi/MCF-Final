@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fireEventGlobalAssets();
@endphp

{!! Theme::partial('header') !!}

<main class="main page-404">
    <div class="page-content pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto text-center">
                    <p class="mb-20">
                        <img src="{{ Theme::asset()->url('imgs/page/page-404.png') }}" alt="{{ theme_option('site_title') }}" class="hover-up">
                    </p>
                    <h2 class="display-2 mb-30">{{ __('Page Not Found') }}</h2>
                    <p class="font-lg text-grey-700 mb-30">
                        {!! BaseHelper::clean(__('The link you clicked may be broken or the page may have been removed.<br> visit the <a href=":link"> <span> Homepage</span></a> or <a href=":mail"><span>Contact us</span></a> about the problem.', ['link' => route('public.index'), 'mail' => 'mailto:' . theme_option('email')])) !!}
                    </p>
                    @if (is_plugin_active('ecommerce'))
                        <div class="search-form form-group">
                            <form action="{{ route('public.products') }}" method="GET">
                                <input name="q" placeholder="{{ __('Search...') }}" type="text">
                                <button type="submit"><i class="fi-rs-search"></i></button>
                            </form>
                        </div>
                    @endif
                    <a class="btn btn-default submit-auto-width font-xs hover-up mt-30" href="{{ route('public.index') }}"><i class="fi-rs-home mr-5"></i> {{ __('Back To Home Page') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>

{!! Theme::partial('footer') !!}


