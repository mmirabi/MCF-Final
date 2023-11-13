<section class="mt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-10 m-auto">
                <div class="contact-from-area  padding-20-row-col wow tmFadeInUp animated" style="visibility: visible;">
                    <h3 class="mb-10 text-center">{{ __('Drop Us a Line') }}</h3>
                    <p class="text-muted mb-30 text-center font-sm">{{ __('Contact Us For Any Questions') }}</p>
                    {!! Form::open(['route' => 'public.send.contact', 'class' => 'contact-form-style text-center contact-form', 'method' => 'POST']) !!}
                        <div class="row">
                            {!! apply_filters('pre_contact_form', null) !!}
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-20">
                                    <input name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-20">
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Email') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-20">
                                    <input name="address" value="{{ old('address') }}" placeholder="{{ __('Address') }}" type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-20">
                                    <input name="phone" value="{{ old('phone') }}" placeholder="{{ __('Phone') }}" type="tel">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-20">
                                    <input name="subject" value="{{ old('subject') }}" placeholder="{{ __('Subject') }}" type="text">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="textarea-style mb-20">
                                    <textarea name="content" placeholder="{{ __('Message') }}">{{ old('content') }}</textarea>
                                </div>
                            </div>

                            @if (is_plugin_active('captcha'))
                                @if (setting('enable_math_captcha_for_contact_form', 0))
                                    <div class="col-md-12 mb-20">
                                        <div class="form-group">
                                            {!! app('math-captcha')->input(['id' => 'math-group', 'placeholder' => app('math-captcha')->label()]) !!}
                                        </div>
                                    </div>
                                @endif

                                @if (setting('enable_captcha'))
                                    <div class="col-12">
                                        {!! Captcha::display() !!}
                                    </div>
                                @endif
                            @endif

                            {!! apply_filters('after_contact_form', null) !!}

                            <div class="col-12">
                                <button class="submit submit-auto-width mt-30" type="submit">{{ __('Send message') }}</button>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <div class="contact-message contact-success-message mt-30" style="display: none"></div>
                            <div class="contact-message contact-error-message mt-30" style="display: none"></div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
