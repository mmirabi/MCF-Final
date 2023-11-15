<div class="form-group">
    <label for="widget-title">{{ __('Title') }}</label>
    <input type="text" id="widget-title" class="form-control" name="title" value="{{ $config['title'] }}">
</div>

<div class="form-group">
    <label for="widget-subtitle">{{ __('Subtitle') }}</label>
    <textarea name="subtitle" id="widget-subtitle" class="form-control" rows="4">{{ $config['subtitle'] }}</textarea>
</div>

<div class="form-group">
    <label for="widget-image">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', $config['image']) !!}
</div>

<div class="form-group">
    <label for="widget-background-image">{{ __('Background Image') }}</label>
    {!! Form::mediaImage('background_image', $config['background_image']) !!}
</div>
