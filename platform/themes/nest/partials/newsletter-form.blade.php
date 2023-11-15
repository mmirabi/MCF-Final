@if (is_plugin_active('newsletter'))
    <form class="newsletter-form {{ $className ?? '' }}" method="post" action="{{ route('public.newsletter.subscribe') }}">
        @csrf
        <div class="form-subscribe d-flex">
            <input type="email" name="email" placeholder="{{ __('Your email address') }}" />
            <button class="btn" type="submit">{{ __('Subscribe') }}</button>
        </div>

        @if (setting('enable_captcha') && is_plugin_active('captcha'))
            <div class="form-subscribe d-flex bg-transparent mt-2">
                {!! Captcha::display() !!}
            </div>
        @endif
    </form>
@endif
