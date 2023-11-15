<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('font_text', 'Lato')) . ':ital,wght@0,400;0,700;1,400;1,700&family=' . urlencode(theme_option('font_heading', 'Quicksand')) . ':wght@400;500;600;700&display=swap') !!}

    <style>
        :root {
            --font-text: {{ theme_option('font_text', 'Lato') }}, sans-serif;
            --font-heading: {{ theme_option('font_heading', 'Quicksand') }}, sans-serif;
            --color-brand: {{ theme_option('color_brand', '#3BB77E') }};
            --color-brand-rgb: {{ implode(',', BaseHelper::hexToRgb(theme_option('color_brand', '#3BB77E'))) }};
            --color-brand-dark: {{ theme_option('color_brand_dark', '#29A56C') }};
            --color-brand-2: {{ theme_option('color_brand_2', '#FDC040') }};
            --color-primary: {{ theme_option('color_primary', '#5a97fa') }};
            --color-secondary: {{ theme_option('color_secondary', '#3e5379') }};
            --color-warning: {{ theme_option('color_warning', '#ff9900') }};
            --color-danger: {{ theme_option('color_danger', '#FD6E6E') }};
            --color-success: {{ theme_option('color_success', '#81B13D') }};
            --color-info: {{ theme_option('color_info', '#2cc1d8') }};
            --color-text: {{ theme_option('color_text', '#7E7E7E') }};
            --color-heading: {{ theme_option('color_heading', '#253D4E') }};
            --color-grey-1: {{ theme_option('color_grey_1', '#253D4E') }};
            --color-grey-2: {{ theme_option('color_grey_2', '#242424') }};
            --color-grey-4: {{ theme_option('color_grey_4', '#adadad') }};
            --color-grey-9: {{ theme_option('color_grey_9', '#f4f5f9') }};
            --color-muted: {{ theme_option('color_muted', '#B6B6B6') }};
            --color-body: {{ theme_option('color_body', '#7E7E7E') }};
        }
    </style>

    @php
        Theme::asset()->remove('language-css');
        Theme::asset()->container('footer')->remove('language-public-js');
        Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-css');
        Theme::asset()->container('footer')->remove('simple-slider-owl-carousel-js');
        Theme::asset()->container('footer')->remove('simple-slider-css');
        Theme::asset()->container('footer')->remove('simple-slider-js');
    @endphp

    {!! Theme::header() !!}

    @php
        $headerStyle = theme_option('header_style') ?: '';
        $page = Theme::get('page');
        if ($page) {
            $headerStyle = $page->getMetaData('header_style', true) ?: $headerStyle;
        }
        $headerStyle = ($headerStyle && in_array($headerStyle, array_keys(get_layout_header_styles()))) ? $headerStyle : '';
    @endphp
</head>
<body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif @if (Theme::get('bodyClass')) class="{{ Theme::get('bodyClass') }}" @endif>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}
    <div id="alert-container"></div>

    {!! Theme::partial('preloader') !!}

<header class="header-area header-style-1 header-height-2 {{ $headerStyle }}">
@if (theme_option('mobile-header-message'))
    <div class="mobile-promotion">
        {!! BaseHelper::clean(theme_option('mobile-header-message')) !!}
    </div>
@endif
<div class="header-top header-top-ptb-1 d-none d-lg-block">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-6">
                <div class="header-info">
                    {!!
                        Menu::renderMenuLocation('header-navigation', [
                            'view' => 'header-menu',
                        ])
                    !!}
                </div>
            </div>
            <div class="col-xl-5 d-none d-xl-block">
                <div class="text-center">
                    @if (theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                @foreach($headerMessages as $headerMessage)
                                    @if (count($headerMessage) == 4)
                                        <li @if (!$loop->first) style="display: none" @endif>
                                            @if ($headerMessage[0]['value'])
                                                <i class="{{ $headerMessage[0]['value'] }} d-inline-block mr-5"></i>&nbsp;
                                            @endif

                                            @if ($headerMessage[1]['value'])
                                                <span class="d-inline-block">
                                                    {!! BaseHelper::clean($headerMessage[1]['value']) !!}
                                                </span>
                                            @endif
                                            @if ($headerMessage[2]['value'] && $headerMessage[3]['value'])
                                                <a class="active d-inline-block" href="{{ url($headerMessage[2]['value']) }}">&nbsp;{!! BaseHelper::clean($headerMessage[3]['value']) !!}</a>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @php $currencies = is_plugin_active('ecommerce') ? get_all_currencies() : []; @endphp
            <div class="col-xl-4 col-lg-6">
                <div class="header-info header-info-right">
                    <ul>
                        @if (theme_option('hotline'))
                            <li>{{ __('Need help? Call Us:') }} &nbsp;<strong class="text-brand"> {{ theme_option('hotline') }}</strong></li>
                        @endif

                        @if (is_plugin_active('language'))
                            {!! Theme::partial('language-switcher') !!}
                        @endif

                        @if (count($currencies) > 1)
                            <li>
                                <a class="language-dropdown-active" href="#">{{ get_application_currency()->title }} <i class="fi-rs-angle-small-down"></i></a>
                                <ul class="language-dropdown">
                                    @foreach ($currencies as $currency)
                                        <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header-middle header-middle-ptb-1 d-none d-lg-block">
    <div class="container">
        <div class="header-wrap">
            @if (theme_option('logo'))
                <div class="logo logo-width-1">
                    <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}"></a>
                </div>
            @endif

            <div class="header-right">
                @if (is_plugin_active('ecommerce'))
                    <div class="search-style-2">
                        <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="GET">
                            <div class="form-group--icon position-relative">
                                <div class="product-cat-label">{{ __('All Categories') }}</div>
                                <select class="product-category-select" name="categories[]" aria-label="Select category">
                                    <option value="">{{ __('All Categories') }}</option>
                                    {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                                </select>
                            </div>
                            <input type="text" class="input-search-product" name="q" placeholder="{{ __('Search for items...') }}" value="{{ BaseHelper::stringify(request()->input('q')) }}" autocomplete="off">
                            <div class="panel--search-result"></div>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            @if (EcommerceHelper::isCompareEnabled())
                                <div class="header-action-icon-2">
                                    <a href="{{ route('public.compare') }}">
                                        <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-compare.svg') }}" />
                                        <span class="pro-count blue compare-count">{{ Cart::instance('compare')->count() }}</span>
                                    </a>
                                    <a href="{{ route('public.compare') }}"><span class="lable">{{ __('Compare') }}</span></a>
                                </div>
                            @endif
                            @if (EcommerceHelper::isWishlistEnabled())
                                <div class="header-action-icon-2">
                                    <a href="{{ route('public.wishlist') }}">
                                        <img class="svgInject" alt="{{ __('Wishlist') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-heart.svg') }}" />
                                        <span class="pro-count blue wishlist-count">@if (auth('customer')->check()) {{ auth('customer')->user()->wishlist()->count() }} @else {{ Cart::instance('wishlist')->count() }} @endif</span>
                                    </a>
                                    <a href="{{ route('public.wishlist') }}"><span class="lable">{{ __('Wishlist') }}</span></a>
                                </div>
                            @endif
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                    <img alt="{{ __('Cart') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count blue">{{ Cart::instance('cart')->count() }}</span>
                                </a>
                                <a href="{{ route('public.cart') }}"><span class="lable">{{ __('Cart') }}</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-dropdown-panel">
                                    {!! Theme::partial('cart-panel') !!}
                                </div>
                            </div>
                            <div class="header-action-icon-2">
                                <a href="{{ route('customer.overview') }}">
                                    <img class="svgInject rounded-circle"
                                        alt="{{ __('Account') }}"
                                        src="{{ auth('customer')->check() ? auth('customer')->user()->avatar_url : Theme::asset()->url('imgs/theme/icons/icon-user.svg') }}" />
                                </a>
                                <a href="{{ route('customer.overview') }}"><span class="lable me-1">{{ auth('customer')->check() ? Str::limit(auth('customer')->user()->name, 10) : __('Account') }}</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        @if (auth('customer')->check())
                                            <li><a href="{{ route('customer.overview') }}"><i class="fi fi-rs-user mr-10"></i>{{ __('My Account') }}</a></li>
                                            @if (EcommerceHelper::isOrderTrackingEnabled())
                                                <li><a href="{{ route('public.orders.tracking') }}"><i class="fi fi-rs-location-alt mr-10"></i>{{ __('Order Tracking') }}</a></li>
                                            @endif
                                            @if (EcommerceHelper::isWishlistEnabled())
                                                <li><a href="{{ route('public.wishlist') }}"><i class="fi fi-rs-heart mr-10"></i>{{ __('My Wishlist') }}</a></li>
                                            @endif
                                            <li><a href="{{ route('customer.edit-account') }}"><i class="fi fi-rs-settings-sliders mr-10"></i>{{ __('Update profile') }}</a></li>
                                            <li><a href="{{ route('customer.logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>{{ __('Sign out') }}</a></li>
                                        @else
                                            <li><a href="{{ route('customer.login') }}"><i class="fi fi-rs-user mr-10"></i>{{ __('Login') }}</a></li>
                                            <li><a href="{{ route('customer.register') }}"><i class="fi fi-rs-user-add mr-10"></i>{{ __('Register') }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="header-bottom header-bottom-bg-color @if (theme_option('enabled_sticky_header', 'yes') == 'yes') sticky-bar @endif">
    <div class="container">
        <div class="header-wrap header-space-between position-relative">
            @if (theme_option('logo'))
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}"></a>
                </div>
            @endif
            <div class="header-nav d-none d-lg-flex">
                @if (is_plugin_active('ecommerce') && theme_option('enabled_browse_categories_on_header', 'yes') == 'yes')
                    <div class="main-categories-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span> {!! BaseHelper::clean(__('<span class="et">Browse</span> All Categories')) !!}
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            @php
                                $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                            @endphp

                            <div class="d-flex categories-dropdown-inner">
                                {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => false]) !!}
                            </div>
                            @if (count($categories) > 10)
                                <div class="more_slide_open" style="display: none">
                                    <div class="d-flex categories-dropdown-inner">
                                        {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => true]) !!}
                                    </div>
                                </div>
                            @endif
                            @if (count($categories) > 10)
                                <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">{{ __('Show more...') }}</span></div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                    <nav>
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'view' => 'main-menu',
                            ])
                        !!}
                    </nav>
                </div>
            </div>
            @if (theme_option('hotline'))
                <div class="hotline d-none d-lg-flex">
                    <img src="{{ Theme::asset()->url('imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                    <p>{{ theme_option('hotline') }}<span>{{ __('24/7 Support Center') }}</span></p>
                </div>
            @endif
            <div class="header-action-icon-2 d-block d-lg-none">
                <div class="burger-icon burger-icon-white">
                    <span class="burger-icon-top"></span>
                    <span class="burger-icon-mid"></span>
                    <span class="burger-icon-bottom"></span>
                </div>
            </div>
            @if (is_plugin_active('ecommerce'))
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        @if (EcommerceHelper::isCompareEnabled())
                            <div class="header-action-icon-2">
                                <a href="{{ route('public.compare') }}">
                                    <img alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-compare.svg') }}" />
                                    <span class="pro-count white compare-count">{{ Cart::instance('compare')->count() }}</span>
                                </a>
                            </div>
                        @endif
                        @if (EcommerceHelper::isWishlistEnabled())
                            <div class="header-action-icon-2">
                                <a href="{{ route('public.wishlist') }}">
                                    <img alt="{{ __('Wishlist') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count white wishlist-count">@if (auth('customer')->check()) {{ auth('customer')->user()->wishlist()->count() }} @else {{ Cart::instance('wishlist')->count() }} @endif</span>
                                </a>
                            </div>
                        @endif
                        @if (EcommerceHelper::isCartEnabled())
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="{{ __('Cart') }}" src="{{ Theme::asset()->url('imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count white">{{ Cart::instance('cart')->count() }}</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-dropdown-panel">
                                    {!! Theme::partial('cart-panel') !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style">
<div class="mobile-header-wrapper-inner">
    <div class="mobile-header-top">
        @if (theme_option('logo'))
            <div class="mobile-header-logo">
                <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}"></a>
            </div>
        @endif
        <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
            <button class="close-style search-close">
                <i class="icon-top"></i>
                <i class="icon-bottom"></i>
            </button>
        </div>
    </div>
    <div class="mobile-header-content-area">
        @if (is_plugin_active('ecommerce'))
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                    <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search for items...') }}" value="{{ BaseHelper::stringify(request()->input('q')) }}" autocomplete="off">
                    <button type="submit"><i class="fi-rs-search"></i></button>
                    <div class="panel--search-result"></div>
                </form>
            </div>
        @endif
        <div class="mobile-menu-wrap mobile-header-border">
            <!-- mobile menu start -->
            <nav>
                {!!
                    Menu::renderMenuLocation('main-menu', [
                        'options' => ['class' => 'mobile-menu'],
                        'view'    => 'mobile-menu',
                    ])
                !!}
            </nav>
            <!-- mobile menu end -->
        </div>

        <div class="mobile-header-info-wrap">

            @if (is_plugin_active('language'))
                <div class="single-mobile-header-info">
                    <a class="mobile-language-active" href="#"><i class="fi-rs-globe"></i> {{ __('Language') }} <span><i class="fi-rs-angle-down"></i></span></a>
                    <div class="lang-curr-dropdown lang-dropdown-active">
                        <ul>
                            @php
                                $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
                            @endphp

                            @foreach (Language::getSupportedLocales() as $localeCode => $properties)
                                <li><a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!} {{ $properties['lang_name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (count($currencies) > 1)
                <div class="single-mobile-header-info">
                    <a class="mobile-language-active" href="#"><i class="fi-rs-money"></i> {{ __('Currency') }} <span><i class="fi-rs-angle-down"></i></span></a>
                    <div class="lang-curr-dropdown lang-dropdown-active">
                        <ul>
                            @foreach ($currencies as $currency)
                                <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (is_plugin_active('ecommerce'))
                @if (EcommerceHelper::isOrderTrackingEnabled())
                    <div class="single-mobile-header-info">
                        <a href="{{ route('public.orders.tracking') }}"><i class="fi-rs-shopping-cart"></i> {{ __('Order tracking') }}</a>
                    </div>
                @endif

                @if (EcommerceHelper::isCompareEnabled())
                    <div class="single-mobile-header-info">
                        <a href="{{ route('public.compare') }}"><i class="fi-rs-refresh"></i> {{ __('Compare') }}</a>
                    </div>
                @endif
                <div class="single-mobile-header-info">
                    <a href="{{ route('customer.login') }}"><i class="fi-rs-user"></i> {{ __('Log In / Sign Up') }}</a>
                </div>
            @endif
            @if (theme_option('hotline'))
                <div class="single-mobile-header-info">
                    <a href="tel:{{ theme_option('hotline') }}"><i class="fi-rs-headphones"></i> {{ theme_option('hotline') }}</a>
                </div>
            @endif
        </div>
        @if ($socialLinks = theme_option('social_links'))
            <div class="mobile-social-icon mb-50">
                <p class="mb-15 font-heading h6 me-2">{{ __('Follow Us') }}</p>
                @foreach(json_decode($socialLinks, true) as $socialLink)
                    @if (count($socialLink) == 3)
                        <a href="{{ $socialLink[2]['value'] }}"
                        title="{{ $socialLink[0]['value'] }}">
                            <img src="{{ RvMedia::getImageUrl($socialLink[1]['value']) }}" alt="{{ $socialLink[0]['value'] }}" />
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
        <div class="site-copyright">{{ theme_option('copyright') }}</div>
    </div>
</div>
</div>
<!--End header-->
