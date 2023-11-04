<?php

namespace Botble\SimpleSlider\Providers;

use Botble\Base\Supports\ServiceProvider;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\Theme\Facades\Theme;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (function_exists('shortcode')) {
            add_shortcode(
                'simple-slider',
                trans('plugins/simple-slider::simple-slider.simple_slider_shortcode_name'),
                trans('plugins/simple-slider::simple-slider.simple_slider_shortcode_description'),
                [$this, 'render']
            );

            shortcode()->setAdminConfig('simple-slider', function ($attributes) {
                $sliders = SimpleSlider::query()
                    ->wherePublished()
                    ->pluck('name', 'key')
                    ->all();

                return view('plugins/simple-slider::partials.simple-slider-admin-config', compact('sliders', 'attributes'))
                    ->render();
            });
        }

        add_filter(BASE_FILTER_AFTER_SETTING_CONTENT, [$this, 'addSettings'], 301);

        add_filter('cms_settings_validation_rules', [$this, 'addSettingRules'], 301);
    }

    public function addSettingRules(array $rules): array
    {
        return array_merge($rules, [
            'simple_slider_using_assets' => 'nullable|in:0,1',
        ]);
    }

    public function render(Shortcode $shortcode): View|Factory|Application|null
    {
        $slider = SimpleSlider::query()
            ->wherePublished()
            ->where('key', $shortcode->key)
            ->first();

        if (empty($slider)) {
            return null;
        }

        if (setting('simple_slider_using_assets', true) && defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
            $version = '1.0.2';
            $dist = asset('vendor/core/plugins/simple-slider');

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add('simple-slider-owl-carousel-css', $dist . '/libraries/owl-carousel/owl.carousel.css', [], [], $version)
                ->add('simple-slider-css', $dist . '/css/simple-slider.css', [], [], $version)
                ->add('simple-slider-owl-carousel-js', $dist . '/libraries/owl-carousel/owl.carousel.js', ['jquery'], [], $version)
                ->add('simple-slider-js', $dist . '/js/simple-slider.js', ['jquery'], [], $version);
        }

        return view(apply_filters(SIMPLE_SLIDER_VIEW_TEMPLATE, 'plugins/simple-slider::sliders'), [
            'sliders' => $slider->sliderItems,
            'shortcode' => $shortcode,
            'slider' => $slider,
        ]);
    }

    public function addSettings(string|null $data = null): string
    {
        return $data . view('plugins/simple-slider::setting')->render();
    }
}
