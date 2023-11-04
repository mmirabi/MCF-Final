@extends(EcommerceHelper::viewPath('customers.master'))
@section('content')
    <div class="section-header">
        <h3>{{ SeoHelper::getTitle() }}</h3>
    </div>
    <div class="section-content">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Product Name') }}</th>
                        <th class="text-center">{{ __('Times downloaded') }}</th>
                        <th>{{ __('Ordered at') }}</th>
                        <th class="text-right text-end">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($orderProducts) > 0)
                        @foreach ($orderProducts as $orderProduct)
                            @php
                                $product = get_products([
                                    'condition' => [
                                        'ec_products.id' => $orderProduct->product_id,
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
                                <td>
                                    <img
                                        src="{{ RvMedia::getImageUrl($orderProduct->product_image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                        alt="{{ $orderProduct->product_name }}"
                                        width="50"
                                    >
                                </td>
                                <td>
                                    @if($product && $product->original_product?->url)
                                        <a href="{{ $product->original_product->url }}">{!! BaseHelper::clean($orderProduct->product_name) !!}</a>
                                    @else
                                        {!! BaseHelper::clean($orderProduct->product_name) !!}
                                    @endif
                                    @if ($sku = Arr::get($orderProduct->options, 'sku'))
                                        ({{ $sku }})
                                    @endif

                                    @if ($attributes = Arr::get($orderProduct->options, 'attributes'))
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
                                        ['options' => $orderProduct->options]
                                    )

                                    @if (!empty($orderProduct->product_options) && is_array($orderProduct->product_options))
                                        {!! render_product_options_html($orderProduct->product_options, $orderProduct->price) !!}
                                    @endif

                                    @if (is_plugin_active('marketplace') && ($product = $orderProduct->product) && $product->original_product->store->id)
                                        <p class="d-block mb-0 sold-by">
                                            <small>{{ __('Sold by') }}: <a href="{{ $product->original_product->store->url }}" class="text-primary">{{ $product->original_product->store->name }}</a>
                                            </small>
                                        </p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span>{{ $orderProduct->times_downloaded }}</span>
                                </td>
                                <td>{{ $orderProduct->created_at->translatedFormat('M d, Y h:m') }}</td>
                                <td class="text-right text-end">
                                    @if ($orderProduct->product_file_internal_count)
                                        <a
                                            class="btn btn-primary mb-2"
                                            href="{{ route('customer.downloads.product', $orderProduct->id) }}"
                                            style="white-space: nowrap"
                                        >
                                            <i class="icon icon-download mr-1"></i>&nbsp;
                                            <span>{{ __('Download all files') }}</span>
                                        </a>
                                    @endif
                                    @if ($orderProduct->product_file_external_count)
                                        <a
                                            class="btn btn-info mb-2"
                                            href="{{ route('customer.downloads.product', [$orderProduct->id, 'external' => true]) }}"
                                            style="white-space: nowrap"
                                        >
                                            <i class="icon icon-link2"></i>&nbsp;
                                            <span>{{ __('External link downloads') }}</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td
                                class="text-center"
                                colspan="5"
                            >{{ __('No digital products!') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {!! $orderProducts->links() !!}
        </div>
    </div>
@endsection
