<?php

namespace Botble\Table\Columns;

use Botble\Table\Contracts\FormattedColumn as EditedColumnContract;

class FormattedColumn extends Column implements EditedColumnContract
{
    public function editedFormat($value): string|null
    {
        return $value;
    }
}
