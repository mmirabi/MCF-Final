<div class="form-group mb-3">
    <label class="control-label">{{ __('Media URL') }}</label>
    {!! Form::input('text', 'url', Arr::get($attributes, 'url'), [
        'class' => 'form-control',
        'placeholder' => 'https://www.youtube.com/watch?v=FN7ALfpGxiI',
    ]) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Width') }}</label>
    {!! Form::input('number', 'width', Arr::get($attributes, 'width', 420), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Height') }}</label>
    {!! Form::input('number', 'height', Arr::get($attributes, 'height', 315), ['class' => 'form-control']) !!}
</div>
