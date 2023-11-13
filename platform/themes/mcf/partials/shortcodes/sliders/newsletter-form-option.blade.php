<div class="form-group">
    <label class="control-label">{{ __('Show newsletter form') }}</label>
    {!! Form::customSelect('show_newsletter_form', ['yes' => __('Yes'), 'no' => __('No')], Arr::get($attributes, 'show_newsletter_form')) !!}
</div>
