<?php

namespace Botble\Table\Abstracts\Concerns;

use Closure;

trait Renderable
{
    protected string $view = 'core/table::actions.action';

    protected Closure $renderUsing;

    protected array $beforeRenders = [];

    protected array $afterRenders = [];

    protected array $mergeData = [];

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

    public function renderUsing(Closure $renderUsingCallback): static
    {
        $this->renderUsing = $renderUsingCallback;

        return $this;
    }

    public function beforeRender(Closure $beforeRenderCallback): static
    {
        $this->beforeRenders[] = $beforeRenderCallback;

        return $this;
    }

    protected function dispatchBeforeRenders(): void
    {
        foreach ($this->beforeRenders as $beforeRender) {
            call_user_func($beforeRender, $this);
        }
    }

    public function afterRender(Closure $afterRenderCallback): static
    {
        $this->afterRenders[] = $afterRenderCallback;

        return $this;
    }

    protected function dispatchAfterRenders(string $rendered): void
    {
        foreach ($this->afterRenders as $after) {
            call_user_func($after, $this, $rendered);
        }
    }

    public function render(): string
    {
        $this->dispatchBeforeRenders();

        $rendered = null;

        if (isset($this->renderUsing)) {
            $rendered = call_user_func($this->renderUsing, $this);
        }

        $rendered = $rendered === null
            ? view($this->getView(), $this->getDataForView())->render()
            : $rendered;

        return tap($rendered, fn (string $rendered) => $this->dispatchAfterRenders($rendered));
    }
}
