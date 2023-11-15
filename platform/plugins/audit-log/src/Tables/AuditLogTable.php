<?php

namespace Botble\AuditLog\Tables;

use Botble\AuditLog\Models\AuditHistory;
use Botble\Base\Facades\Html;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AuditLogTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(AuditHistory::class)
            ->addActions([
                DeleteAction::make()->route('audit-log.destroy'),
            ])
            ->queryUsing(fn (Builder $query) => $query->with('user'));
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            FormattedColumn::make('action')
                ->title(trans('plugins/audit-log::history.action'))
                ->alignStart()
                ->renderUsing(function (Column $column) {
                    return view('plugins/audit-log::activity-line', ['history' => $column->getItem()])->render();
                }),
        ];
    }

    public function buttons(): array
    {
        return [
            'empty' => [
                'link' => route('audit-log.empty'),
                'text' => Html::tag('i', '', ['class' => 'fa fa-trash'])->toHtml() . ' ' . trans(
                    'plugins/audit-log::history.delete_all'
                ),
            ],
        ];
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('audit-log.destroy'),
        ];
    }
}
