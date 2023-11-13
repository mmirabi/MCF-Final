<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="Title">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Scroll display items') }}</label>
    {!! Form::customSelect('scroll_items', array_combine([6, 7, 8, 9, 10], [6, 7, 8, 9, 10]), Arr::get($attributes, 'scroll_items', 10)) !!}
</div>

{!! Theme::partial('shortcodes.includes.autoplay-settings', compact('attributes')) !!}
