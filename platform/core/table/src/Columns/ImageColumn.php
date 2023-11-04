<?php

namespace Botble\Table\Columns;

class ImageColumn extends Column
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'image', $name)
            ->title(trans('core/base::tables.image'))
            ->orderable(false)
            ->searchable(false)
            ->width(70);
    }
}
