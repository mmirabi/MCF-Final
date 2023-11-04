@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <div class="container">
        <h1 class="text-center pt-5">{{ trans('core/base::system.cleanup.title') }}</h1><br>
        <div
            class="updater-box"
            dir="ltr"
        >
            <div class="note note-warning">
                <p class="text-danger"><strong>- {{ trans('core/base::system.cleanup.backup_alert') }}</strong></p>
                @if (!config('core.base.general.enabled_cleanup_database', false))
                    <p class="text-danger"><strong>- {!! BaseHelper::clean(trans('core/base::system.cleanup.not_enabled_yet')) !!}</strong></p>
                @endif
            </div>
            <div class="content">
                <p class="fw-bold">{{ trans('core/base::system.cleanup.messenger_choose_without_table') }}:</p>
                <form
                    id="form-cleanup-database"
                    action="{{ route('system.cleanup') }}"
                    method="POST"
                >
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('core/base::system.cleanup.table.name') }}</th>
                                <th>{{ trans('core/base::system.cleanup.table.count') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tables as $table)
                                <tr @class([
                                    'table-secondary' => in_array($table, $disabledTables['disabled']),
                                ])>
                                    <td>
                                        <input
                                            class="form-check-input"
                                            name="tables[]"
                                            type="checkbox"
                                            value="{{ $table }}"
                                            @checked(in_array($table, $disabledTables['disabled']) || in_array($table, $disabledTables['checked']))
                                        >
                                    </td>
                                    <td>{{ $table }}</td>
                                    <td>{{ DB::table($table)->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 mb-4">
                        <button
                            class="btn btn-danger btn-trigger-cleanup"
                            type="button"
                        >{{ trans('core/base::system.cleanup.submit_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-core::modal
        id="cleanup-modal"
        type="danger"
        :title="trans('core/base::system.cleanup.title')"
        button-id="cleanup-submit-action"
        :button-label="trans('core/base::system.cleanup.submit_button')"
    >
        {!! trans('core/base::system.cleanup.messenger_confirm_cleanup') !!}
    </x-core::modal>
@stop
