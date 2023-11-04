<?php

namespace Botble\Table\Columns;

class LinkableColumn extends Column
{
    protected array $route = [];

    protected string|null $permission = null;

    protected int $limit = 0;

    public function route(string $route, array $parameters = [], bool $absolute = true): static
    {
        $this->route = [$route, $parameters, $absolute];

        return $this;
    }

    public function getRoute(): array
    {
        return $this->route;
    }

    public function permission(string $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    public function getPermission(): string|null
    {
        return $this->permission;
    }

    public function limit(int $words): static
    {
        $this->limit = $words;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
