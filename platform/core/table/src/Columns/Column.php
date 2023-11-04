<?php

namespace Botble\Table\Columns;

use Yajra\DataTables\Html\Column as BaseColumn;

class Column extends BaseColumn
{
    public function alignLeft(): static
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

    public function columnVisibility(bool $has = false): static
    {
        if ($has) {
            return $this->removeClass('no-column-visibility');
        }

        return $this->addClass('no-column-visibility');
    }
}
