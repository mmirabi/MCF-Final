<?php

namespace Botble\Base\Supports;

use Closure;

trait Renderable
{
    protected Closure $renderUsing;

    protected array $beforeRenders = [];

    protected array $afterRenders = [];

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

    protected function dispatchAfterRenders(mixed $rendered): void
    {
        foreach ($this->afterRenders as $after) {
            call_user_func($after, $this, $rendered);
        }
    }

    public function rendering(Closure|string $content): mixed
    {
        $this->dispatchBeforeRenders();

        $content = value($content);

        $rendered = null;

        if (isset($this->renderUsing)) {
            $rendered = call_user_func($this->renderUsing, $this, $content);
        }

        $rendered = $rendered === null ? $content : $rendered;

        return tap($rendered, fn (mixed $rendered) => $this->dispatchAfterRenders($rendered));
    }
}
