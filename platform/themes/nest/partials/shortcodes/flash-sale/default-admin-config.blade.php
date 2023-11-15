<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

@for ($i = 1; $i <= 4; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Flash sale ') . $i }}</label>
        {!! Form::customSelect('flash_sale_' . $i, $flashSales, Arr::get($attributes, 'flash_sale_' . $i)) !!}
    </div>
@endfor

<div class="form-group">
    <label class="control-label">{{ __('Show flash sale popup?') }}</label>
    {!! Form::customSelect('flash_sale_popup_id', $flashSales, Arr::get($attributes, 'flash_sale_popup_id')) !!}
</div>
