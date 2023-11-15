<div class="form-group">
    <label class="control-label">{{ __('Cover image') }}</label>
    {!! Form::mediaImage('cover_image', Arr::get($attributes, 'cover_image')) !!}
</div>
