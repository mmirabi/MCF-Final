<a
    class="btn btn-info"
    data-fancybox
    data-type="ajax"
    data-src="{{ route('simple-slider-item.edit', $item->id) }}"
    href="javascript:;"
><i class="fa fa-edit"></i> {{ trans('core/base::tables.edit') }}</a>
<a
    class="btn btn-danger"
    data-fancybox
    data-type="ajax"
    data-src="{{ route('simple-slider-item.destroy.get', $item->id) }}"
    href="javascript:;"
><i class="fa fa-trash"></i> {{ trans('core/base::tables.delete_entry') }}</a>
