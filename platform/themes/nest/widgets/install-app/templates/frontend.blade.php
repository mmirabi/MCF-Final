<div class="footer-link-widget widget-install-app col  wow animate__animated animate__fadeInUp"  data-wow-delay=".5s">
    <h4 class="widget-title ">{{ $config['name'] }}</h4>
    <p>{!! BaseHelper::clean($config['apps_description']) !!}</p>
    <div class="download-app">
        @if ($config['ios_app_url'] && $config['ios_app_image'])
            <a href="{{ $config['ios_app_url'] }}" class="hover-up mb-sm-2 mb-lg-0">
                <img class="active" src="{{ RvMedia::getImageUrl($config['ios_app_image']) }}" alt="iOS app" />
            </a>
        @endif
        @if ($config['android_app_url'] && $config['android_app_image'])
            <a href="{{ $config['android_app_url'] }}" class="hover-up mb-sm-2">
                <img src="{{ RvMedia::getImageUrl($config['android_app_image']) }}" alt="Android app" />
            </a>
        @endif
    </div>
    @if ($config['payment_gateway_description'] && $config['payment_gateway_image'])
        <p class="mb-20">{{ $config['payment_gateway_description'] }}</p>
        <img src="{{ RvMedia::getImageUrl($config['payment_gateway_image']) }}" alt="Payment gateways" />
    @endif
</div>
