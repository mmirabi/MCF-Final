<div class="form-group">
    <label for="layout" class="control-label">{{ __('Layout') }}</label>
    {!! Form::customSelect('layout', get_product_single_layouts(), $layout, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="is_popular" class="control-label">{{ __('Is Popular?') }}</label>
    {!! Form::onOff('is_popular', $isPopular, ['class' => 'form-control']) !!}
</div>
