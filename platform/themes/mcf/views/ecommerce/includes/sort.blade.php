@php
    $sorts = EcommerceHelper::getSortParams();
    $shows = EcommerceHelper::getShowParams();
    $sortBy = json_encode(request()->input('sort-by', 'default_sorting'));
    $showing = (int)request()->input('num', (int)theme_option('number_of_products_per_page', 12));
@endphp

<div class="sort-by-product-area">
    <div class="sort-by-cover mr-10 products_sortby">
        {{-- mehdi mirabi sort by product page hidden --}}
        {{-- <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fi-rs-apps"></i>{{ __('Show:') }}</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span> {!! Arr::get($shows, $showing, (int)theme_option('number_of_products_per_page', 12)) !!} <i class="fi-rs-angle-small-down"></i></span>
            </div>
        </div> --}}
        <div class="sort-by-dropdown products_ajaxsortby" data-name="num">
            <ul>
                @foreach ($shows as $key => $label)
                    <li>
                        <a data-label="{{ $label }}"
                            class="@if ($showing == $key) active @endif"
                            href="{{ request()->fullUrlWithQuery(['num' => $key]) }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sort-by-cover products_sortby">
        <div class="sort-by-product-wrap">
            <div class="sort-by">
                <span><i class="fi-rs-apps-sort"></i>{{ __('Sort by:') }}</span>
            </div>
            <div class="sort-by-dropdown-wrap">
                <span><span>{!! Arr::get($sorts, $sortBy) !!}</span> <i class="fi-rs-angle-small-down"></i></span>
            </div>
        </div>
        <div class="sort-by-dropdown products_ajaxsortby" data-name="sort-by">
            <ul>
                @foreach ($sorts as $key => $label)
                    <li>
                        <a data-label="{{ $label }}"
                        class="@if ($sortBy == $key) active @endif"
                        href="{{ request()->fullUrlWithQuery(['sort-by' => $key]) }}">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
