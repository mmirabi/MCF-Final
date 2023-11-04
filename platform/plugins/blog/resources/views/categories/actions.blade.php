<a
    class="btn btn-icon btn-primary"
    data-bs-toggle="tooltip"
    data-bs-original-title="{{ trans('core/base::tables.edit') }}"
    href="{{ route('categories.edit', $item->id) }}"
><i class="fa fa-edit"></i></a>
<a
    class="btn btn-icon btn-danger deleteDialog"
    data-bs-toggle="tooltip"
    data-section="{{ route('categories.destroy', $item->id) }}"
    data-bs-original-title="{{ trans('core/base::tables.delete_entry') }}"
    href="#"
    role="button"
>
    <i class="fa fa-trash"></i>
</a>
