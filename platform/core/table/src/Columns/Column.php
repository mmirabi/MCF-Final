<?php

namespace Botble\Table\Columns;

use Botble\Base\Contracts\BaseModel;
use Botble\Base\Supports\Renderable;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Columns\Concerns\HasEmptyState;
use Botble\Table\Contracts\FormattedColumn;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Yajra\DataTables\Html\Column as BaseColumn;

class Column extends BaseColumn
{
    use HasEmptyState;
    use Renderable;
    use Conditionable;

    protected TableAbstract $table;

    protected int $limit;

    protected Closure $getValueUsingCallback;

    protected object|array $item;

    protected array $appendCallbacks = [];

    protected array $prependCallbacks = [];

    protected array $initialized = [];

    public static function make(array|string $data = [], string $name = ''): static
    {
        $instance = parent::make($data, $name);

        $instance->initialize();

        if ($instance instanceof FormattedColumn) {
            $instance->renderUsing(fn (FormattedColumn $column, $value) => $column->editedFormat($value));
        }

        return $instance;
    }

    public function initialize(): void
    {
        foreach (class_uses_recursive(static::class) as $trait) {
            $method = 'initialize' . class_basename($trait);

            if (method_exists($this, $method) && ! in_array($method, $this->initialized)) {
                call_user_func([$this, $method]);
                $this->initialized[] = $method;
            }
        }
    }

    public function removeClass(string $class): static
    {
        if (isset($this->attributes['className'])) {
            $className = $this->attributes['className'];
            $this->attributes['className'] = trim(str_replace($class, '', $className));
        }

        return $this;
    }

    public function alignLeft(): static
    {
        return $this->alignStart();
    }

    public function alignStart(): static
    {
        return $this->addClass('text-start');
    }

    public function alignCenter(): static
    {
        return $this->addClass('text-center');
    }

    public function alignEnd(): static
    {
        return $this->addClass('text-end');
    }

    public function nowrap(): static
    {
        return $this->addClass('text-nowrap');
    }

    public function fontBold(): static
    {
        return $this->addClass('fw-bold');
    }

    public function fontBolder(): static
    {
        return $this->addClass('fw-bolder');
    }

    public function fontSemibold(): static
    {
        return $this->addClass('fw-semibold');
    }

    public function fontLight(): static
    {
        return $this->addClass('fw-light');
    }

    public function fontLighter(): static
    {
        return $this->addClass('fw-lighter');
    }

    public function fontMono(): static
    {
        return $this->addClass('font-monospace');
    }

    public function underline(): static
    {
        return $this->addClass('text-decoration-underline');
    }

    public function lineThrough(): static
    {
        return $this->addClass('text-decoration-line-through');
    }

    public function limit(int $length = 5): static
    {
        $this->limit = $length;

        return $this;
    }

    public function applyLimitIfAvailable(string|null $text): string
    {
        if (isset($this->limit) && $this->limit > 0) {
            return Str::limit($text, $this->limit);
        }

        return $text ?: '';
    }

    public function columnVisibility(bool $has = false): static
    {
        if ($has) {
            return $this->removeClass('no-column-visibility');
        }

        return $this->addClass('no-column-visibility');
    }

    public function setTable(TableAbstract $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): TableAbstract
    {
        return $this->table;
    }

    public function setItem(object $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getItem(): object|array
    {
        return $this->item;
    }

    public function getValueUsing(Closure $callback): static
    {
        $this->getValueUsingCallback = $callback;

        return $this;
    }

    public function append(Closure $callback): static
    {
        $this->appendCallbacks[] = $callback;

        return $this;
    }

    protected function renderAppends(): string
    {
        $rendered = '';

        foreach ($this->appendCallbacks as $callback) {
            $rendered .= call_user_func($callback, $this);
        }

        return $rendered;
    }

    public function prepend(Closure $callback): static
    {
        $this->prependCallbacks[] = $callback;

        return $this;
    }

    protected function renderPrepends(): string
    {
        $rendered = '';

        foreach ($this->prependCallbacks as $callback) {
            $rendered .= call_user_func($callback, $this);
        }

        return $rendered;
    }

    public function getValue(): mixed
    {
        if (isset($this->getValueUsingCallback)) {
            return call_user_func($this->getValueUsingCallback, $this);
        }

        return $this->getItem()->{$this->name};
    }

    public function renderCell(BaseModel|array $item, TableAbstract $table): string
    {
        $item = $item instanceof BaseModel ? $item : (object) $item;

        $this->setTable($table)->setItem($item);

        $rendered = $this->rendering(fn () => $this->getValue());

        $rendered = $this->renderEmptyStateIfAvailable($rendered);

        return $this->renderPrepends() . $rendered . $this->renderAppends();
    }
}
