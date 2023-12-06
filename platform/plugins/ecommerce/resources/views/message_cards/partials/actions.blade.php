<a
    class="btn btn-icon btn-primary"
    data-bs-toggle="tooltip"
    data-bs-original-title="{{ trans('core/base::tables.edit') }}"
    href="{{ route('message_cards.edit', $item->id) }}"
><i class="fa fa-edit"></i></a>
@if (!$item->is_default)
    <a
        class="btn btn-icon btn-danger deleteDialog"
        data-bs-toggle="tooltip"
        data-section="{{ route('message_cards.destroy', $item->id) }}"
        data-bs-original-title="{{ trans('core/base::tables.delete_entry') }}"
        href="#"
        role="button"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
