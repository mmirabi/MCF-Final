{!! BaseHelper::googleFonts(
    'https://fonts.googleapis.com/css2?family=' .
        urlencode(theme_option('primary_font', 'Muli')) .
        ':wght@400;600;700&display=swap',
) !!}

{!! Assets::renderHeader(['core']) !!}

<link
    href="{{ asset('vendor/core/core/base/css/themes/default.css') }}?v={{ get_cms_version() }}"
    rel="stylesheet"
>

<link
    href="{{ asset('vendor/core/plugins/marketplace/fonts/linearicons/linearicons.css') }}?v={{ MarketplaceHelper::getAssetVersion() }}"
    rel="stylesheet"
>
<link
    href="{{ asset('vendor/core/plugins/marketplace/css/marketplace.css') }}?v={{ MarketplaceHelper::getAssetVersion() }}"
    rel="stylesheet"
>

@if (BaseHelper::siteLanguageDirection() == 'rtl')
    <link
        href="{{ asset('vendor/core/core/base/css/rtl.css') }}?v={{ get_cms_version() }}"
        rel="stylesheet"
    >
    <link
        href="{{ asset('vendor/core/plugins/marketplace/css/marketplace-rtl.css') }}?v={{ MarketplaceHelper::getAssetVersion() }}"
        rel="stylesheet"
    >
@endif

@if (File::exists($styleIntegration = Theme::getStyleIntegrationPath()))
    {!! Html::style(Theme::asset()->url('css/style.integration.css?v=' . filectime($styleIntegration))) !!}
@endif
