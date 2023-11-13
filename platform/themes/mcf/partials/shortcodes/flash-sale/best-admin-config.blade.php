<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Flash sale') }}</label>
    {!! Form::customSelect('flash_sale_id', $flashSales, Arr::get($attributes, 'flash_sale_id')) !!}
</div>

@if (is_plugin_active('ads'))
    <div class="form-group">
        <label class="control-label">{{ __('Ads') }}</label>
        {!! Form::customSelect('ads', AdsManager::getData()->pluck('name', 'key'), Arr::get($attributes, 'ads')) !!}
    </div>
@endif
