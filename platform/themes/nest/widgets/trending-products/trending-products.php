<?php

use Botble\Widget\AbstractWidget;

class TrendingProductsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Trending products'),
            'description' => __('Trending products of ecommerce'),
            'number_display' => 4,
        ]);
    }
}
