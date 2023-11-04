<div class="form-group">
    <label for="widget-name">{{ __('Name') }}</label>
    <input type="text" id="widget-name" class="form-control" name="name" value="{{ $config['name'] }}">
</div>
<div class="form-group">
    <label for="widget_slider_id">{{ __('Select simple slider') }}</label>
    {!! Form::customSelect('slider_key', get_all_simple_sliders()->pluck('name', 'key'), $config['slider_key']) !!}
</div>
