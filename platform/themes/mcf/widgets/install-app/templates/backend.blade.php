<div class="form-group mb-3">
    <label>{{ trans('core/base::forms.name') }}</label>
    <input type="text" class="form-control" name="name" value="{{ $config['name'] }}">
</div>

<div class="form-group mb-3">
    <label>{{ __('Apps description') }}</label>
    <textarea class="form-control" rows="3" name="apps_description">{{ $config['apps_description'] }}</textarea>
</div>

<div class="form-group mb-3">
    <label>{{ __('iOS app URL') }}</label>
    <input type="text" class="form-control" name="ios_app_url" value="{{ $config['ios_app_url'] }}">
</div>

<div class="form-group mb-3">
    <label>{{ __('iOS app image') }}</label>
    {!! Form::mediaImage('ios_app_image', $config['ios_app_image']) !!}
</div>

<div class="form-group mb-3">
    <label>{{ __('Android app URL') }}</label>
    <input type="text" class="form-control" name="android_app_url" value="{{ $config['android_app_url'] }}">
</div>

<div class="form-group mb-3">
    <label>{{ __('Android app image') }}</label>
    {!! Form::mediaImage('android_app_image', $config['android_app_image']) !!}
</div>

<div class="form-group mb-3">
    <label>{{ __('Payment gateways description') }}</label>
    <textarea class="form-control" rows="3" name="payment_gateway_description">{{ $config['payment_gateway_description'] }}</textarea>
</div>

<div class="form-group mb-3">
    <label>{{ __('Payment gateways image') }}</label>
    {!! Form::mediaImage('payment_gateway_image', $config['payment_gateway_image']) !!}
</div>
