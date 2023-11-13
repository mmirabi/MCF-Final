<?php

use Botble\Widget\AbstractWidget;

class PriceFilterWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Filter by price'),
            'description' => __('Filter products by price on sidebar'),
        ]);
    }
}
