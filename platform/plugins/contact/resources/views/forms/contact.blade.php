{!! Form::open(['route' => 'public.send.contact', 'method' => 'POST', 'class' => 'contact-form']) !!}
<div class="contact-form-row">
    {!! apply_filters('pre_contact_form', null) !!}

    <div class="contact-column-6">
        <div class="contact-form-group">
            <label
                class="contact-label required"
                for="contact_name"
            >{{ __('Name') }}</label>
            <input
                class="contact-form-input"
                id="contact_name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                placeholder="{{ __('Name') }}"
            >
        </div>
    </div>
    <div class="contact-column-6">
        <div class="contact-form-group">
            <label
                class="contact-label required"
                for="contact_email"
            >{{ __('Email') }}</label>
            <input
                class="contact-form-input"
                id="contact_email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                placeholder="{{ __('Email') }}"
            >
        </div>
    </div>
</div>
<div class="contact-form-row">
    <div class="contact-column-6">
        <div class="contact-form-group">
            <label
                class="contact-label"
                for="contact_address"
            >{{ __('Address') }}</label>
            <input
                class="contact-form-input"
                id="contact_address"
                name="address"
                type="text"
                value="{{ old('address') }}"
                placeholder="{{ __('Address') }}"
            >
        </div>
    </div>
    <div class="contact-column-6">
        <div class="contact-form-group">
            <label
                class="contact-label"
                for="contact_phone"
            >{{ __('Phone') }}</label>
            <input
                class="contact-form-input"
                id="contact_phone"
                name="phone"
                type="text"
                value="{{ old('phone') }}"
                placeholder="{{ __('Phone') }}"
            >
        </div>
    </div>
</div>
<div class="contact-form-row">
    <div class="contact-column-12">
        <div class="contact-form-group">
            <label
                class="contact-label"
                for="contact_subject"
            >{{ __('Subject') }}</label>
            <input
                class="contact-form-input"
                id="contact_subject"
                name="subject"
                type="text"
                value="{{ old('subject') }}"
                placeholder="{{ __('Subject') }}"
            >
        </div>
    </div>
</div>
<div class="contact-form-row">
    <div class="contact-column-12">
        <div class="contact-form-group">
            <label
                class="contact-label required"
                for="contact_content"
            >{{ __('Message') }}</label>
            <textarea
                class="contact-form-input"
                id="contact_content"
                name="content"
                rows="5"
                placeholder="{{ __('Message') }}"
            >{{ old('content') }}</textarea>
        </div>
    </div>
</div>

@if (is_plugin_active('captcha'))
    @if (Captcha::isEnabled())
        <div class="contact-form-row">
            <div class="contact-column-12">
                <div class="contact-form-group">
                    {!! Captcha::display() !!}
                </div>
            </div>
        </div>
    @endif

    @if (setting('enable_math_captcha_for_contact_form', 0))
        <div class="contact-form-group">
            <label
                class="contact-label required"
                for="math-group"
            >{{ app('math-captcha')->label() }}</label>
            {!! app('math-captcha')->input(['class' => 'contact-form-input', 'id' => 'math-group']) !!}
        </div>
    @endif
@endif

{!! apply_filters('after_contact_form', null) !!}

<div class="contact-form-group">
    <p>{!! BaseHelper::clean(__('The field with (<span style="color:#FF0000;">*</span>) is required.')) !!}</p>
</div>

<div class="contact-form-group">
    <button
        class="contact-button"
        type="submit"
    >{{ __('Send') }}</button>
</div>

<div class="contact-form-group">
    <div
        class="contact-message contact-success-message"
        style="display: none"
    ></div>
    <div
        class="contact-message contact-error-message"
        style="display: none"
    ></div>
</div>

{!! Form::close() !!}
