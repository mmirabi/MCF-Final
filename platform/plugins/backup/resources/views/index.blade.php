@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="clearfix"></div>
    @if (!function_exists('proc_open'))
        <div class="note note-warning">
            <p>{!! BaseHelper::clean(trans('plugins/backup::backup.proc_open_disabled_error')) !!}</p>
        </div>
    @endif

    @if ($driver === 'mysql')
        <div class="note note-warning">
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message1')) !!}</p>
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message2')) !!}</p>
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message3')) !!}</p>
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message4')) !!}</p>
        </div>
    @elseif ($driver === 'pgsql')
        <div class="note note-warning">
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message_pgsql1')) !!}</p>
            <p>- {!! BaseHelper::clean(trans('plugins/backup::backup.important_message_pgsql2')) !!}</p>
        </div>
    @endif

    @if (
        $driver === 'mysql' &&
            auth()->user()->hasPermission('backups.create'))
        <p><button
                class="btn btn-primary"
                id="generate_backup"
            >{{ trans('plugins/backup::backup.generate_btn') }}</button></p>
    @endif

    <table
        class="table table-striped"
        id="table-backups"
    >
        <thead>
            <tr>
                <th>{{ trans('core/base::tables.name') }}</th>
                <th>{{ trans('core/base::tables.description') }}</th>
                <th>{{ trans('plugins/backup::backup.size') }}</th>
                <th>{{ trans('core/base::tables.created_at') }}</th>
                <th>{{ trans('core/table::table.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (count($backups) > 0)
                @foreach ($backups as $key => $backup)
                    @include('plugins/backup::partials.backup-item', [
                        'data' => $backup,
                        'backupManager' => $backupManager,
                        'key' => $key,
                        'odd' => $loop->index % 2 == 0,
                    ])
                @endforeach
            @else
                <tr class="text-center no-backup-row">
                    <td colspan="5">{{ trans('plugins/backup::backup.no_backups') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if (auth()->user()->hasPermission('backups.create'))
        <x-core::modal
            id="create-backup-modal"
            type="info"
            :title="trans('plugins/backup::backup.create')"
            button-id="create-backup-button"
            :button-label="trans('plugins/backup::backup.create_btn')"
        >
            <div class="form-group mb-3">
                <label
                    class="control-label required"
                    for="name"
                >{{ trans('core/base::forms.name') }}</label>
                {!! Form::text('name', old('name'), [
                    'class' => 'form-control',
                    'id' => 'name',
                    'placeholder' => trans('core/base::forms.name'),
                    'data-counter' => 120,
                ]) !!}
            </div>

            <div class="form-group mb-3">
                <label
                    class="control-label"
                    for="description"
                >{{ trans('core/base::forms.description') }}</label>
                {!! Form::textarea('description', old('description'), [
                    'class' => 'form-control',
                    'rows' => 4,
                    'id' => 'description',
                    'placeholder' => trans('core/base::forms.description'),
                    'data-counter' => 400,
                ]) !!}
            </div>

        </x-core::modal>
        <div data-route-create="{{ route('backups.create') }}"></div>
    @endif

    @if (auth()->user()->hasPermission('backups.restore'))
        <x-core::modal
            id="restore-backup-modal"
            type="info"
            :title="trans('plugins/backup::backup.restore')"
            button-id="restore-backup-button"
            :button-label="trans('plugins/backup::backup.restore_btn')"
        >
            {!! trans('plugins/backup::backup.restore_confirm_msg') !!}
        </x-core::modal>
    @endif

    @include('core/table::partials.modal-item', [
        'type' => 'danger',
        'name' => 'modal-confirm-delete',
        'title' => trans('core/base::tables.confirm_delete'),
        'content' => trans('core/base::tables.confirm_delete_msg'),
        'action_name' => trans('core/base::tables.delete'),
        'action_button_attributes' => [
            'class' => 'delete-crud-entry',
        ],
    ])
@stop
