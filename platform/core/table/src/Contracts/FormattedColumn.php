<?php

namespace Botble\Table\Contracts;

interface FormattedColumn
{
    public function editedFormat($value): string|null;
}
