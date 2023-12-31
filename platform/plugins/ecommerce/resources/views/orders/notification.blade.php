<li class="dropdown dropdown-extended dropdown-inbox">
    <a
        class="dropdown-toggle dropdown-header-name"
        data-bs-toggle="dropdown"
        href="javascript:;"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="fas fa-shopping-cart"></i>
        <span class="badge badge-default"> {{ $orders->total() }} </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li class="external">
            <h3>{!! trans('plugins/ecommerce::order.new_order_notice', ['count' => $orders->total()]) !!}</h3>
            <a href="{{ route('orders.index') }}">{{ trans('plugins/ecommerce::order.view_all') }}</a>
        </li>
        <li>
            <ul
                class="dropdown-menu-list scroller"
                data-handle-color="#637283"
                style="height: {{ $orders->total() * 70 }}px;"
            >
                @foreach ($orders as $order)
                    <li>
                        <a href="{{ route('orders.edit', $order->id) }}">
                            <span class="photo">
                                <img
                                    class="rounded-circle"
                                    src="{{ $order->user->id ? $order->user->avatar_url : $order->address->avatar_url }}"
                                    alt="{{ $order->address->name }}"
                                >
                            </span>
                            <span class="subject"><span class="from">
                                    {{ $order->address->name ?: $order->user->name }} </span><span
                                    class="time">{{ BaseHelper::formatDateTime($order->created_at) }} </span></span>
                            <span class="message"> {{ $order->address->phone ? $order->address->phone . ' - ' : null }}
                                {{ $order->address->email ?: $order->user->email }} </span>
                        </a>
                    </li>
                @endforeach

                @if ($orders->total() > 10)
                    <li class="text-center"><a
                            href="{{ route('orders.index') }}">{{ trans('plugins/ecommerce::order.view_all') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
</li>
