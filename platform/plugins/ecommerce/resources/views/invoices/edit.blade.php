@extends('core/base::layouts.master')

@section('content')
    <div class="max-width-1036">
        <div class="card">
            <div class="card-body">
                <div class="invoice-info">
                    <div class="mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if ($invoice->company_logo)
                                    <img
                                        src="{{ RvMedia::getImageUrl($invoice->company_logo) }}"
                                        alt="{{ $invoice->company_name }}"
                                        style="max-height: 150px;"
                                    >
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                <h2 class="mb-0 uppercase">{{ trans('plugins/ecommerce::invoice.heading') }}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-end">
                                <ul class="mb-0">
                                    @if ($invoice->customer_name)
                                        <li>{{ $invoice->customer_name }}</li>
                                    @endif
                                    @if ($invoice->customer_email)
                                        <li>{{ $invoice->customer_email }}</li>
                                    @endif
                                    @if ($invoice->customer_phone)
                                        <li>{{ $invoice->customer_phone }}</li>
                                    @endif
                                    @if ($invoice->customer_address)
                                        <li>{{ $invoice->customer_address }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-lg-4">
                            <strong class="text-brand">{{ trans('plugins/ecommerce::invoice.detail.code') }}:</strong>
                            {{ $invoice->code }}
                        </div>
                        @if ($invoice->created_at)
                            <div class="col-lg-4">
                                <strong
                                    class="text-brand">{{ trans('plugins/ecommerce::invoice.detail.issue_at') }}:</strong>
                                {{ $invoice->created_at->translatedFormat('j F, Y') }}
                            </div>
                        @endif
                        @if (is_plugin_active('payment') && $invoice->payment->payment_channel->label())
                            <div class="col-lg-4">
                                <strong
                                    class="text-brand">{{ trans('plugins/ecommerce::invoice.payment_method') }}:</strong>
                                {{ $invoice->payment->payment_channel->label() }}
                            </div>
                        @endif
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                    <table class="table table-striped mb-3">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px">#</th>
                                <th class="text-center">{{ __('Image') }}</th>
                                <th>{{ __('Product') }}</th>
                                <th class="text-center">{{ __('Amount') }}</th>
                                <th
                                    class="text-end"
                                    style="width: 100px"
                                >{{ __('Quantity') }}</th>
                                <th class="price text-end">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $invoiceItem)
                                @php
                                    $product = get_products([
                                        'condition' => [
                                            'ec_products.id' => $invoiceItem->reference_id,
                                        ],
                                        'take'   => 1,
                                        'select' => [
                                            'ec_products.id',
                                            'ec_products.images',
                                            'ec_products.name',
                                            'ec_products.price',
                                            'ec_products.sale_price',
                                            'ec_products.sale_type',
                                            'ec_products.start_date',
                                            'ec_products.end_date',
                                            'ec_products.sku',
                                            'ec_products.is_variation',
                                            'ec_products.status',
                                            'ec_products.order',
                                            'ec_products.created_at',
                                        ],
                                    ]);
                                @endphp
                                <tr>
                                    <td class="text-center" style="width: 20px">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <img
                                            src="{{ RvMedia::getImageUrl($invoiceItem->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                            alt="{{ $invoiceItem->name }}"
                                            width="50"
                                        >
                                    </td>
                                    <td>
                                        @if($product && $product->original_product?->url)
                                            <a href="{{ $product->original_product->url }}">{!! BaseHelper::clean($invoiceItem->name) !!}</a>
                                        @else
                                            {!! BaseHelper::clean($invoiceItem->name) !!}
                                        @endif
                                        @if ($sku = Arr::get($invoiceItem->options, 'sku'))
                                            ({{ $sku }})
                                        @endif

                                        @if ($attributes = Arr::get($invoiceItem->options, 'attributes'))
                                            <p class="mb-0">
                                                <small>{{ $attributes }}</small>
                                            </p>
                                        @elseif ($product && $product->is_variation)
                                            <p>
                                                <small>
                                                    @php $attributes = get_product_attributes($product->id) @endphp
                                                    @if (!empty($attributes))
                                                        @foreach ($attributes as $attribute)
                                                            {{ $attribute->attribute_set_title }}: {{ $attribute->title }}@if (!$loop->last), @endif
                                                        @endforeach
                                                    @endif
                                                </small>
                                            </p>
                                        @endif

                                        @include(
                                            'plugins/ecommerce::themes.includes.cart-item-options-extras',
                                            ['options' => $invoiceItem->options]
                                        )

                                        @if (is_plugin_active('marketplace') && ($product = $invoiceItem->reference) && $product->original_product->store->id)
                                            <p class="d-block mb-0 sold-by">
                                                <small>{{ __('Sold by') }}: <a href="{{ $product->original_product->store->url }}" class="text-primary">{{ $product->original_product->store->name }}</a>
                                                </small>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $invoiceItem->amount_format }}</td>
                                    <td class="text-center">{{ $invoiceItem->qty }}</td>
                                    <td class="money text-end">
                                        <strong>
                                            {{ $invoiceItem->total_format }}
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th
                                    class="text-start"
                                >{{ trans('plugins/ecommerce::invoice.detail.quantity') }}:
                                </th>
                                <th class="text-center">{{ number_format($invoice->items->sum('qty')) }}</th>
                            </tr>
                            <tr>
                                <th
                                    class="text-start"
                                >{{ trans('plugins/ecommerce::invoice.detail.sub_total') }}:
                                </th>
                                <th class="text-center">{{ format_price($invoice->sub_total) }}</th>
                            </tr>
                            @if ($invoice->tax_amount > 0)
                                <tr>
                                    <th
                                        class="text-start"
                                    >{{ trans('plugins/ecommerce::invoice.detail.tax') }}:</th>
                                    <th class="text-center">{{ format_price($invoice->tax_amount) }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th
                                    class="text-start"
                                >{{ trans('plugins/ecommerce::invoice.detail.shipping_fee') }}:
                                </th>
                                <th class="text-center">{{ format_price($invoice->shipping_amount) }}</th>
                            </tr>
                            <tr>
                                <th
                                    class="text-start"
                                >{{ trans('plugins/ecommerce::invoice.detail.discount') }}:
                                </th>
                                <th class="text-center">{{ format_price($invoice->discount_amount) }}</th>
                            </tr>
                            <tr>
                                <th
                                    class="text-start"
                                >{{ trans('plugins/ecommerce::invoice.detail.grand_total') }}:
                                </th>
                                <th class="text-center">{{ format_price($invoice->amount) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($invoice->reference && $invoice->reference->id)
                                <h5>{{ trans('plugins/ecommerce::invoice.detail.invoice_for') }}:
                                    {{ Html::link(route('orders.edit', $invoice->reference->id), $invoice->reference->code, ['target' => '_blank']) }}
                                    <small><i class="fa fa-external-link-alt"></i></small>
                                </h5>
                            @endif
                            <p class="font-sm">
                                @if ($invoice->company_name)
                                    <strong>{{ trans('plugins/ecommerce::invoice.detail.invoice_to') }}:</strong>
                                    {{ $invoice->company_name }}<br>
                                @endif

                                @if ($invoice->customer_tax_id)
                                    <strong>{{ trans('plugins/ecommerce::invoice.detail.tax_id') }}:</strong>
                                    {{ $invoice->customer_tax_id }}<br>
                                @endif

                                {!! apply_filters('ecommerce_admin_invoice_extra_info', null, $invoice->reference) !!}
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>{{ trans('plugins/ecommerce::invoice.total_amount') }}</h5>
                            <h3 class="mt-0 mb-0 text-danger">{{ format_price($invoice->amount) }}</h3>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="card-footer text-center">
                <a
                    class="btn btn-danger"
                    href="{{ route('ecommerce.invoice.generate-invoice', ['invoice' => $invoice, 'type' => 'print']) }}"
                    target="_blank"
                >
                    <i class="fas fa-print"></i> {{ trans('plugins/ecommerce::invoice.print') }}
                </a>
                <a
                    class="btn btn-success"
                    href="{{ route('ecommerce.invoice.generate-invoice', ['invoice' => $invoice, 'type' => 'download']) }}"
                    target="_blank"
                >
                    <i class="fas fa-download"></i> {{ trans('plugins/ecommerce::invoice.download') }}
                </a>
            </div>
        </div>
    </div>
@endsection
