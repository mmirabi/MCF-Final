{!! Form::open(['url' => $url]) !!}

<div class="form-group">
    <label
        class="control-label"
        for="shipment-status"
    >{{ trans('plugins/ecommerce::shipping.status') }}</label>
    {!! Form::customSelect('status', \Botble\Ecommerce\Enums\ShippingStatusEnum::labels(), $shipment->status) !!}
</div>

{!! Form::close() !!}
