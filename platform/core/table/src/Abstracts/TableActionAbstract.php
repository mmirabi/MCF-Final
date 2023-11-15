<?php

namespace Botble\Table\Abstracts;

use Botble\Base\Contracts\BaseModel;
use Botble\Base\Supports\Renderable;
use Botble\Table\Abstracts\Concerns\HasConfirmation;
use Botble\Table\Abstracts\Concerns\HasLabel;
use Botble\Table\Abstracts\Concerns\HasPermissions;
use Botble\Table\Abstracts\Concerns\HasPriority;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Traits\Conditionable;
use Stringable;

abstract class TableActionAbstract implements Htmlable, Stringable
{
    use Conditionable;
    use HasConfirmation;
    use HasLabel;
    use HasPermissions;
    use HasPriority;
    use Renderable;

    protected BaseModel $model;

    protected string $view = 'core/table::actions.action';

    protected array $mergeData = [];

    public function __construct(protected string $name)
    {
    }

    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function model(BaseModel $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): BaseModel
    {
        return $this->model;
    }

    public function view(string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function dataForView(array $mergeData): static
    {
        $this->mergeData = $mergeData;

        return $this;
    }

    public function getDataForView(): array
    {
        return array_merge([
            'action' => $this,
        ], $this->mergeData);
    }

    public function render(): string
    {
        return $this->rendering(
            fn () => view($this->getView(), $this->getDataForView())->render()
        );
    }

    public function toHtml(): string
    {
        return $this->render();
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
