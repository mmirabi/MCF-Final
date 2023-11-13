<?php

use Botble\Widget\AbstractWidget;

class GalleryWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Gallery'),
            'description' => __('Gallery of images'),
            'slider_key' => null,
        ]);
    }
}
