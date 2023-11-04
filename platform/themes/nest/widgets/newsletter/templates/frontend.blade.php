@if (is_plugin_active('newsletter'))
    <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner" @if ($config['background_image']) style="background-image: url({{ RvMedia::getImageUrl($config['background_image']) }}) !important;" @endif>
                        <div class="newsletter-content">
                            @if($config['title'])
                                <h2 class="mb-20">
                                    {!! BaseHelper::clean($config['title']) !!}
                                </h2>
                            @endif
                            @if($config['subtitle'])
                                <p class="mb-45">{!! BaseHelper::clean($config['subtitle']) !!}</p>
                            @endif
                            {!! Theme::partial('newsletter-form') !!}
                        </div>
                        @if ($config['image'])
                            <img src="{{ RvMedia::getImageUrl($config['image']) }}" alt="newsletter" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
