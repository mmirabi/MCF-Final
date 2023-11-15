    <footer class="main">
        {!! dynamic_sidebar('pre_footer_sidebar') !!}

        @if($footerSidebar = dynamic_sidebar('footer_sidebar'))
            <section class="section-padding footer-mid">
                <div class="container pt-15 pb-20">
                    <div class="row">
                        {!! $footerSidebar !!}
                    </div>
                </div>
            </section>
        @endif
        <div class="container pb-30  wow animate__animated animate__fadeInUp"  data-wow-delay="0">
            <div class="row align-items-center">
                <div class="col-12 mb-30">
                    <div class="footer-bottom"></div>
                </div>
                @if($copyright = theme_option('copyright'))
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <p class="font-sm mb-0">{!! BaseHelper::clean($copyright) !!}</p>
                    </div>
                @endif
                @if ($hotline = theme_option('hotline'))
                    <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                        <div class="hotline d-lg-inline-flex w-full align-items-center justify-content-center">
                            <img src="{{ Theme::asset()->url('imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                            <p>{{ $hotline }} <span>{{ __('24/7 Support Center') }}</span></p>
                        </div>
                    </div>
                @endif
                @if ($socialLinks = theme_option('social_links'))
                    @if($socialLinks = json_decode($socialLinks, true))
                        <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                            <div class="mobile-social-icon">
                                <p class="font-heading h6 me-2">{{ __('Follow Us') }}</p>
                                @foreach($socialLinks as $socialLink)
                                    @if (count($socialLink) == 3)
                                        <a href="{{ $socialLink[2]['value'] }}"
                                           title="{{ $socialLink[0]['value'] }}">
                                            {{ RvMedia::image($socialLink[1]['value'], $socialLink[0]['value']) }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            <p class="font-sm">{{ __('Up to 15% discount on your first subscribe') }}</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </footer>

    <div class="modal fade custom-modal" id="quick-view-modal" tabindex="-1" aria-labelledby="quick-view-modal-label" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="half-circle-spinner loading-spinner">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                    <div class="quick-view-content"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.trans = {
            "Views": "{{ __('Views') }}",
            "Read more": "{{ __('Read more') }}",
            "days": "{{ __('days') }}",
            "hours": "{{ __('hours') }}",
            "mins": "{{ __('mins') }}",
            "sec": "{{ __('sec') }}",
            "No reviews!": "{{ __('No reviews!') }}",
            "Sold By": "{{ __('Sold By') }}",
            "Quick View": "{{ __('Quick View') }}",
            "Add To Wishlist": "{{ __('Add To Wishlist') }}",
            "Add To Compare": "{{ __('Add To Compare') }}",
            "Out Of Stock": "{{ __('Out Of Stock') }}",
            "Add To Cart": "{{ __('Add To Cart') }}",
            "Add": "{{ __('Add') }}",
        };

        window.siteUrl = "{{ route('public.index') }}";

        @if (is_plugin_active('ecommerce'))
            window.currencies = {!! json_encode(get_currencies_json()) !!};
        @endif
    </script>

    {!! Theme::footer() !!}

    @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
        <script type="text/javascript">
            window.onload = function () {
                @if (session()->has('success_msg'))
                    window.showAlert('alert-success', '{{ session('success_msg') }}');
                @endif

                @if (session()->has('error_msg'))
                    window.showAlert('alert-danger', '{{ session('error_msg') }}');
                @endif

                @if (isset($error_msg))
                    window.showAlert('alert-danger', '{{ $error_msg }}');
                @endif

                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        window.showAlert('alert-danger', '{!! BaseHelper::clean($error) !!}');
                    @endforeach
                @endif
            };
        </script>
    @endif
    </body>
</html>
