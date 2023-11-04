@if ($update)
    <a
        class="btn btn-info btn-trigger-edit-product-version"
        data-target="{{ $update }}"
        data-load-form="{{ $loadForm }}"
        data-bs-toggle="tooltip"
        href="#"
        title="{{ trans('plugins/ecommerce::products.edit_variation_item') }}"
    >
        <i class="fa fa-edit"></i>
    </a>
@endif
@if ($delete)
    <a
        class="btn-trigger-delete-version btn btn-danger"
        data-target="{{ $delete }}"
        data-id="{{ $item->id }}"
        data-bs-toggle="tooltip"
        href="#"
        title="{{ trans('plugins/ecommerce::products.delete') }}"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
