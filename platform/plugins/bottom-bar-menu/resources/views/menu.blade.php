<div class="footer-mobile">
    <ul class="menu--footer">
        <li>
            <a href="{{ route('public.index') }}">
                <i class="fi-rs-home"></i>
                <span>{{ __('Home') }}</span>
            </a>
        </li>
        @if (is_plugin_active('ecommerce'))
            <li>
                <a class="toggle--sidebar" href="{{ route('public.products') }}">
                    <i class="fi-rs-apps"></i>
                    <span>{{ __('Shop') }}</span>
                </a>
            </li>
            @if (EcommerceHelper::isCartEnabled())
                <li>
                    <a class="toggle--sidebar" href="{{ route('public.cart') }}">
                        <i class="fi-rs-shopping-cart mini-cart-icon">
                            <span class="cart-counter">{{ Cart::instance('cart')->count() }}</span>
                        </i>
                        <span>{{ __('Cart') }}</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="#" class="trigger-mobile-menu">
                    <i class="fi-rs-search"></i>
                    <span>{{ __('Search') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('customer.overview') }}">
                    <i class="fi-rs-user"></i>
                    <span>{{ __('Account') }}</span>
                </a>
            </li>
        @endif
    </ul>
</div>
