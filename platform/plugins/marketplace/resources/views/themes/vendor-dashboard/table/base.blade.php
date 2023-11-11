@extends(MarketplaceHelper::viewPath('vendor-dashboard.layouts.master'))
@section('content')
    <div
        class="container page-content"
        style="background: none; max-width: none"
    >
        @include('core/table::base-table')
    </div>
@stop
