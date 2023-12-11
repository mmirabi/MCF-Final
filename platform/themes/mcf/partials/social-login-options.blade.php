@if (SocialService::hasAnyProviderEnable())
    <div class="container">
        <div class="row">
            @foreach (SocialService::getProviderKeys() as $item)
                @if (SocialService::getProviderEnabled($item))
                    <div class="col">
                        <div class="card-login">
                            <a href="{{ route('auth.social', array_merge([$item], $params)) }}" class="social-login {{ $item }}-login">
                                <img src="{{ Theme::asset()->url('imgs/theme/icons/logo-' . $item . '.svg') }}" alt="{{ Str::ucfirst($item) }}" />
                                <span>{{ __('Continue with :provider', ['provider' => Str::ucfirst($item)]) }}</span>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
