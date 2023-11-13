<?php

use Botble\Widget\AbstractWidget;

class AdsWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Ads'),
            'description' => __('Display ads on sidebar'),
            'ads_key' => 0,
        ]);
    }
}
