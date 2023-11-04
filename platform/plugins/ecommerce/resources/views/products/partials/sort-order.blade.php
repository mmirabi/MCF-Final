@if (Auth::user()->hasPermission('products.edit'))
    <a
        class="editable"
        data-type="text"
        data-pk="{{ $item->id }}"
        data-url="{{ route('products.update-order-by') }}"
        data-value="{{ $item->order ?? 0 }}"
        data-title="{{ trans('core/base::tables.order') }}"
        href="#"
    >{{ $item->order ?? 0 }}</a>
@else
    {{ $item->order }}
@endif
