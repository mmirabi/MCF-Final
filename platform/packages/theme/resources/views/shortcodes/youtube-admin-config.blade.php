<div class="form-group mb-3">
    <label class="control-label">{{ __('Youtube URL') }}</label>
    {!! Form::input('text', 'url', $content, [
        'class' => 'form-control',
        'placeholder' => 'https://www.youtube.com/watch?v=FN7ALfpGxiI',
        'data-shortcode-attribute' => 'content',
    ]) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Width') }}</label>
    {!! Form::input('number', 'width', Arr::get($attributes, 'width'), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Height') }}</label>
    {!! Form::input('number', 'height', Arr::get($attributes, 'height'), ['class' => 'form-control']) !!}
</div>
