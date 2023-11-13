<?php

use Botble\Widget\AbstractWidget;

class InstallAppWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Install App'),
            'description' => __('Widget display mobile apps links.'),
            'apps_description' => null,
            'ios_app_url' => null,
            'ios_app_image' => null,
            'android_app_url' => null,
            'android_app_image' => null,
            'payment_gateway_description' => null,
            'payment_gateway_image' => null,
        ]);
    }
}
