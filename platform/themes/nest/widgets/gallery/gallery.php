<?php

use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\Widget\AbstractWidget;
use Illuminate\Support\Collection;

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

    protected function data(): array|Collection
    {
        if (! is_plugin_active('simple-slider')) {
            return [];
        }

        return [
            'slider' => SimpleSlider::query()->where('key', $this->getConfig('slider_key'))->first(),
        ];
    }

    protected function adminConfig(): array
    {
        if (! is_plugin_active('simple-slider')) {
            return [];
        }

        return [
            'sliders' => SimpleSlider::query()->wherePublished()->pluck('name', 'id')->all(),
        ];
    }
}
