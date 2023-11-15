<?php

namespace Botble\Table\Columns;

use Botble\Base\Facades\Html;
use Botble\Table\Contracts\FormattedColumn;

class EmailColumn extends Column implements FormattedColumn
{
    protected bool $linkable = false;

    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'email', $name)
            ->title(trans('core/base::tables.email'))
            ->alignStart();
    }

    public function linkable(bool $linkable = true): static
    {
        $this->linkable = $linkable;

        return $this;
    }

    public function isLinkable(): bool
    {
        return $this->linkable;
    }

    public function editedFormat($value): string|null
    {
        if (! $this->isLinkable()) {
            return null;
        }

        return Html::mailto($value, $value);
    }
}
