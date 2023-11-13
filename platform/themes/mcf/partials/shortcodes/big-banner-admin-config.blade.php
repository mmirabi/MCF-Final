<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="Title">
</div>
<div class="form-group">
    <label class="control-label">{{ __('Cover image') }}</label>
    {!! Form::mediaImage('cover_image', Arr::get($attributes, 'cover_image')) !!}
</div>

@if (is_plugin_active('newsletter'))
    <div class="form-group">
        <label class="control-label">{{ __('Show newsletter form') }}</label>
        {!! Form::customSelect('show_newsletter_form', ['yes' => __('Yes'), 'no' => __('No')], Arr::get($attributes, 'show_newsletter_form')) !!}
    </div>
@endif
@if (is_plugin_active('ecommerce'))
    <div class="form-group">
        <label class="control-label">{{ __('Number of featured categories to display') }}</label>
        <input type="number" name="number_display_featured_categories" value="{{ Arr::get($attributes, 'number_display_featured_categories') }}" class="form-control" placeholder="Ex: 4">
    </div>
@endif
