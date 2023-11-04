<?php

namespace Botble\BottomBarMenu\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class BottomBarMenuServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->setNamespace('plugins/bottom-bar-menu')
            ->loadAndPublishViews()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            Theme::asset()
                ->usePath(false)
                ->add(
                    'bottom-bar-menu-css',
                    asset('vendor/core/plugins/bottom-bar-menu/css/menu.css'),
                    [],
                    [],
                    '1.0.0'
                );

            Theme::asset()
                ->container('footer')
                ->usePath(false)
                ->add(
                    'bottom-bar-menu-js',
                    asset('vendor/core/plugins/bottom-bar-menu/js/menu.js'),
                    ['jquery'],
                    [],
                    '1.0.0'
                );
        });

        $this->app->booted(function () {
            add_filter(THEME_FRONT_FOOTER, function (string|null $html): string|null {
                if (is_in_admin()) {
                    return $html;
                }

                return $html . view('plugins/bottom-bar-menu::menu')->render();
            }, 16);
        });
    }
}
