<section class="featured section-padding">
    <div class="container">
        <div class="row">
            @for ($i = 1; $i <= 5; $i++)
                @if ($title = Arr::get(Arr::get($config['data'], $i), 'title'))
                    {{-- mehdi mirabi edit footer grid --}}
                    <div class="col-lg-3 col-md-6 col-12 col-sm-6 mt-2">
                        <div class="banner-left-icon d-flex align-items-center  fadeIn  animated"  data-wow-delay="{{ $i * 2 / 10 }}s">
                            <div class="banner-icon">
                                <img src="{{ RvMedia::getImageUrl(Arr::get(Arr::get($config['data'], $i), 'icon'), null, false, RvMedia::getDefaultImage()) }}" alt="icon">
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">{!! BaseHelper::clean($title) !!}</h3>
                                <p>{!! BaseHelper::clean(Arr::get(Arr::get($config['data'], $i), 'subtitle')) !!}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    </div>
</section>
