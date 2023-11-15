<?php

namespace Botble\Table\Columns;

use Botble\Base\Facades\Html;
use Botble\Table\Contracts\FormattedColumn;

class YesNoColumn extends Column implements FormattedColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data, $name)
            ->width(100);
    }

    public function editedFormat($value): string
    {
        return Html::tag('span', $value ? trans('core/base::base.yes') : trans('core/base::base.no'), [
            'class' => sprintf('badge badge-%s', $value ? 'success' : 'danger'),
        ]);
    }
}
