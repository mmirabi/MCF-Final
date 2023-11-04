<div class="form-group">
    <label for="header_style" class="control-label">{{ __('Header style') }}</label>
    {!! Form::customSelect('header_style', get_layout_header_styles(), $headerStyle, ['class' => 'form-control', 'id' => 'header_style']) !!}
</div>
