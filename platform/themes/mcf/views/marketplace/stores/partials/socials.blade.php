@php
    $storeSocialLinks = get_store_social_links();
    $socialLinks = [];
    if ($storeSocialLinks) {
        $socialLinks = $store->getMetaData('social_links', true);
    }
@endphp
@if ($socialLinks)
    <div class="follow-social mb-20">
        <p class="mb-15 font-heading h6 {{ $headerClass ?? '' }}">{{ __('Follow Us') }}</p>
        <ul class="social-network">
            @foreach ($storeSocialLinks as $key => $item)
                @if (Arr::get($socialLinks, $key))
                    <li class="hover-up pe-1 mt-1">
                        <a href="{{ Arr::get($item, 'domain') . Arr::get($socialLinks, $key) }}" target="_blank" rel="nofollow noopener">
                            <img src="{{ Theme::asset()->url(Arr::get($item, 'logo')) }}" alt="{{ Arr::get($item, 'title') }}" />
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
