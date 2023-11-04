<?php

namespace Botble\Table\Columns;

class YesNoColumn extends Column
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data, $name)
            ->width(100);
    }
}
