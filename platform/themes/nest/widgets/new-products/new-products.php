<?php

use Botble\Widget\AbstractWidget;

class NewProductsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('New products'),
            'description' => __('New products of ecommerce'),
            'number_display' => 3,
        ]);
    }
}
