<x-core::layouts.base
    body-class="login"
    body-style="background-image: url({{ $backgroundUrl }});"
>
    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-7 col-md-8">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <div class="copy animated fadeIn">
                                <h1>{{ setting('admin_title', config('core.base.general.base_name')) }}</h1>
                                <p>{!! BaseHelper::clean(
                                    trans('core/base::layouts.copyright', [
                                        'year' => Carbon\Carbon::now()->format('Y'),
                                        'company' => setting('admin_title', config('core.base.general.base_name')),
                                        'version' => get_cms_version(),
                                    ]),
                                    // Mehdi Mirabi add copyright in admin login page
                                ) !!} Powered By: <a href="https://MedyaNossa.com" target="-blank">Medya Nossa</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">
                <div class="login-container">

                    @yield('content')

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</x-core::layouts.base>
