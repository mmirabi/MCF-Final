@if (Auth::guard()->user()->hasPermission('users.edit'))
    <a
        class="btn btn-icon btn-primary"
        data-bs-toggle="tooltip"
        data-bs-original-title="{{ trans('core/acl::users.view_user_profile') }}"
        href="{{ route('users.profile.view', $item->getKey()) }}"
    ><i class="fa fa-eye"></i></a>
@endif

@if (Auth::guard()->user()->hasPermission('users.destroy'))
    <a
        class="btn btn-icon btn-danger deleteDialog"
        data-bs-toggle="tooltip"
        data-section="{{ route('users.destroy', $item->id) }}"
        data-bs-original-title="{{ trans('core/base::tables.delete_entry') }}"
        href="#"
        role="button"
    >
        <i class="fa fa-trash"></i>
    </a>
@endif
