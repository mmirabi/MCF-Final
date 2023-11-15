@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <div id="dashboard-alerts">
        <verify-license-component
            verify-url="{{ route('settings.license.verify') }}"
            setting-url="{{ route('settings.options') }}"
        ></verify-license-component>
        @if (config('core.base.general.enable_system_updater') && Auth::guard()->user()->isSuperUser())
            <check-update-component
                check-update-url="{{ route('system.check-update') }}"
                setting-url="{{ route('system.updater') }}"
            ></check-update-component>
        @endif
    </div>
    {!! apply_filters(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, null) !!}
    <div class="row">
        {!! apply_filters(DASHBOARD_FILTER_TOP_BLOCKS, null) !!}
    </div>
    <div class="row">
        @foreach ($statWidgets as $widget)
            {!! $widget !!}
        @endforeach
    </div>
    <div
        class="row"
        id="list_widgets"
    >
        @foreach ($userWidgets as $widget)
            {!! $widget !!}
        @endforeach
    </div>

    @if (count($widgets) > 0)
        <a
            class="manage-widget"
            href="#"
        >
            <i class="fa fa-plus"></i>
            {{ trans('core/dashboard::dashboard.manage_widgets') }}
        </a>
        @include('core/dashboard::partials.modals', compact('widgets'))
    @endif
@stop
