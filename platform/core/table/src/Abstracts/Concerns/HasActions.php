<?php

namespace Botble\Table\Abstracts\Concerns;

use Botble\Table\Abstracts\TableActionAbstract;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\RowActionsColumn;
use Closure;
use Illuminate\Database\Eloquent\Model;
use LogicException;

trait HasActions
{
    /**
     * @var \Botble\Table\Abstracts\TableActionAbstract[] $actions
     */
    protected array $rowActions = [];

    protected array $rowActionsEditCallbacks = [];

    /**
     * @deprecated since v6.8.0
     */
    protected $hasOperations = true;

    /**
     * @internal
     */
    public function getRowActions(): array
    {
        return collect($this->rowActions)
            ->filter(fn (TableActionAbstract $action) => $action->currentUserHasAnyPermissions())
            ->mapWithKeys(fn (TableActionAbstract $action, string $name) => [$name => $this->getAction($name)])
            ->sortBy(fn (TableActionAbstract $action) => $action->getPriority())
            ->all();
    }

    public function addAction(TableActionAbstract $action): static
    {
        $this->rowActions[$action->getName()] = $action;

        return $this;
    }

    /**
     * @param \Botble\Table\Abstracts\TableActionAbstract[] $actions
     */
    public function addActions(array $actions): static
    {
        $newActions = [];

        foreach ($actions as $action) {
            $newActions[$action->getName()] = $action;
        }

        $this->rowActions = array_merge($this->rowActions, $newActions);

        $this->hasOperations = false;

        return $this;
    }

    public function removeAction(string $name): static
    {
        unset($this->rowActions[$name]);

        return $this;
    }

    public function removeActions(array $name): static
    {
        foreach ($name as $key) {
            $this->removeAction($key);
        }

        return $this;
    }

    public function removeAllActions(): static
    {
        $this->rowActions = [];

        return $this;
    }

    public function hasAction(string $name): bool
    {
        return isset($this->rowActions[$name]);
    }

    public function hasActions(): bool
    {
        return ! empty($this->getRowActions()) || $this->hasOperations;
    }

    /**
     * @param \Closure(\Botble\Table\Abstracts\TableActionAbstract $action): \Botble\Table\Abstracts\TableActionAbstract $callback
     */
    public function editAction(string $name, Closure $callback): static
    {
        if (! $this->hasAction($name)) {
            throw new LogicException('Action not found.');
        }

        $this->rowActionsEditCallbacks[$name][] = $callback;

        return $this;
    }

    public function getAction(string $name): TableActionAbstract
    {
        if (! $this->hasAction($name)) {
            throw new LogicException('Action not found.');
        }

        $action = $this->rowActions[$name];

        if (isset($this->rowActionsEditCallbacks[$name])) {
            foreach ($this->rowActionsEditCallbacks as $callback) {
                $callback($action);
            }
        }

        return $action;
    }

    protected function getRowActionsHeading(): array
    {
        return [
            RowActionsColumn::make()->width(70 * count($this->getRowActions())),
        ];
    }

    /**
     * @deprecated since v6.8.0
     */
    public function getOperationsHeading()
    {
        return [
            Column::make('operations')
                ->title(trans('core/base::tables.operations'))
                ->width(134)
                ->alignCenter()
                ->orderable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->responsivePriority(99),
        ];
    }

    /**
     * @deprecated since v6.8.0
     */
    protected function getOperations(string|null $edit, string|null $delete, Model $item, string|null $extra = null): string
    {
        return apply_filters(
            'table_operation_buttons',
            view('core/table::partials.actions', compact('edit', 'delete', 'item', 'extra'))->render(),
            $item,
            $edit,
            $delete,
            $extra
        );
    }
}
