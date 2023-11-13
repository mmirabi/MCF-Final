@if ($keys->count())
    @if ($style == 'style-5')
        <section class="section-padding">
            <div class="container">
                <div class="row">
                    @foreach ($keys as $key)
                        <div class="col-lg-3 col-md-6">
                            {!! display_ad($key, '', $loop) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="banners pt-60">
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($keys as $key)
                        <div class="col-lg-4 col-md-6">
                            {!! display_ad($key, '', $loop) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endif
