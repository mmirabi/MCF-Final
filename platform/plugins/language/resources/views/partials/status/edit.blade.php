@if (!is_in_admin() || (Auth::guard()->check() && Auth::guard()->user()->hasPermission($route['edit'])))
    <a
        data-bs-toggle="tooltip"
        data-bs-original-title="{{ trans('plugins/language::language.edit_related') }}"
        href="{{ Route::has($route['edit']) ? route($route['edit'], $relatedLanguage) : '#' }}"
    ><i class="fa fa-edit"></i></a>
@else
    <i class="fa fa-check text-success"></i>
@endif
