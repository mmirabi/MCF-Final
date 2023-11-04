<ul class="font-sm mb-20">
    @if ($store->address)
        <li>
            <span class="d-inline-block"><img src="{{ Theme::asset()->url('imgs/theme/icons/icon-location.svg') }}" alt="{{ __('Address') }}" /> <strong class="d-inline-block ms-1 me-1">{{ __('Address') }}:</strong> {{ $store->full_address }}</span>
        </li>
    @endif
    @if (!MarketplaceHelper::hideStorePhoneNumber() && $store->phone)
        <li>
            <img src="{{ Theme::asset()->url('imgs/theme/icons/icon-contact.svg') }}" alt="{{ __('Phone') }}" />
            <strong class="d-inline-block ms-1 me-1">{{ __('Call Us') }}:</strong>
            <span class="d-inline-block" dir="ltr">{{ $store->phone }}</span>
        </li>
    @endif
</ul>
