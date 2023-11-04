<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Theme\Facades\Theme;
use Botble\Widget\Models\Widget as WidgetModel;

class WidgetSeeder extends BaseSeeder
{
    public function run(): void
    {
        WidgetModel::query()->truncate();

        $data = [
            [
                'widget_id' => 'SiteInfoWidget',
                'sidebar_id' => 'footer_sidebar',
                'position' => 0,
                'data' => [
                    'id' => 'SiteInfoWidget',
                    'name' => 'Site information',
                    'about' => 'Awesome grocery store website template',
                    'phone' => '(+91) - 540-025-124553',
                    'address' => '5171 W Campbell Ave undefined Kent, Utah 53127 United States',
                    'email' => 'sale@Nest.com',
                    'working_hours' => '10:00 - 18:00, Mon - Sat',
                ],
            ],
            [
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'position' => 1,
                'data' => [
                    'id' => 'CustomMenuWidget',
                    'name' => 'Company',
                    'menu_id' => 'company',
                ],
            ],
            [
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'position' => 2,
                'data' => [
                    'id' => 'CustomMenuWidget',
                    'name' => 'Categories',
                    'menu_id' => 'product-categories',
                ],
            ],
            [
                'widget_id' => 'CustomMenuWidget',
                'sidebar_id' => 'footer_sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'CustomMenuWidget',
                    'name' => 'Information',
                    'menu_id' => 'information',
                ],
            ],
            [
                'widget_id' => 'InstallAppWidget',
                'sidebar_id' => 'footer_sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'InstallAppWidget',
                    'name' => 'Install App',
                    'apps_description' => 'From App Store or Google Play',
                    'ios_app_url' => '#',
                    'ios_app_image' => 'general/app-store.jpg',
                    'android_app_url' => '#',
                    'android_app_image' => 'general/google-play.jpg',
                    'payment_gateway_description' => 'Secured Payment Gateways',
                    'payment_gateway_image' => 'general/payment-methods.png',
                ],
            ],

            [
                'widget_id' => 'BlogSearchWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 0,
                'data' => [
                    'id' => 'BlogSearchWidget',
                    'name' => 'Search',
                ],
            ],
            [
                'widget_id' => 'ProductCategoriesWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 1,
                'data' => [
                    'id' => 'ProductCategoriesWidget',
                    'name' => 'Categories',
                ],
            ],
            [
                'widget_id' => 'TrendingProductsWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 2,
                'data' => [
                    'id' => 'TrendingProductsWidget',
                    'name' => 'Trending Now',
                    'number_display' => 4,
                ],
            ],
            [
                'widget_id' => 'GalleryWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'GalleryWidget',
                    'name' => 'Gallery',
                    'slider_key' => 'slider-blog-1',
                ],
            ],
            [
                'widget_id' => 'TagsWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 4,
                'data' => [
                    'id' => 'TagsWidget',
                    'name' => 'Popular Tags',
                ],
            ],
            [
                'widget_id' => 'AdsWidget',
                'sidebar_id' => 'primary_sidebar',
                'position' => 5,
                'data' => [
                    'id' => 'AdsWidget',
                    'name' => 'Oganic',
                    'ads_key' => 'IZ6WU8KUALYI',
                ],
            ],

            [
                'widget_id' => 'ProductCategoriesWidget',
                'sidebar_id' => 'product_sidebar',
                'position' => 1,
                'data' => [
                    'id' => 'ProductCategoriesWidget',
                    'name' => 'Categories',
                ],
            ],
            [
                'widget_id' => 'NewProductsWidget',
                'sidebar_id' => 'product_sidebar',
                'position' => 3,
                'data' => [
                    'id' => 'NewProductsWidget',
                    'name' => 'New products',
                ],
            ],
            [
                'widget_id' => 'AdsWidget',
                'sidebar_id' => 'product_sidebar',
                'position' => 4,
                'data' => [
                    'id' => 'AdsWidget',
                    'name' => 'Oganic',
                    'ads_key' => 'IZ6WU8KUALYI',
                ],
            ],

            [
                'widget_id' => 'NewsletterWidget',
                'sidebar_id' => 'pre_footer_sidebar',
                'position' => 0,
                'data' => [
                    'id' => 'NewsletterWidget',
                    'title' => 'Stay home & get your daily <br />needs from our shop',
                    'subtitle' => 'Start Your Daily Shopping with <span>Nest Mart</span>',
                    'image' => 'general/newsletter-image.png',
                    'background_image' => 'general/newsletter-background-image.png',
                ],
            ],
            [
                'widget_id' => 'SiteFeaturesWidget',
                'sidebar_id' => 'pre_footer_sidebar',
                'position' => 1,
                'data' => [
                    'id' => 'SiteFeaturesWidget',
                    'title' => 'Site Features',
                    'data' => [
                        1 => [
                            'icon' => 'general/icon-1.png',
                            'title' => 'Best prices & offers',
                            'subtitle' => 'Orders $50 or more',
                        ],
                        2 => [
                            'icon' => 'general/icon-2.png',
                            'title' => 'Free delivery',
                            'subtitle' => '24/7 amazing services',
                        ],
                        3 => [
                            'icon' => 'general/icon-3.png',
                            'title' => 'Great daily deal',
                            'subtitle' => 'When you sign up',
                        ],
                        4 => [
                            'icon' => 'general/icon-4.png',
                            'title' => 'Wide assortment',
                            'subtitle' => 'Mega Discounts',
                        ],
                        5 => [
                            'icon' => 'general/icon-5.png',
                            'title' => 'Easy returns',
                            'subtitle' => 'Within 30 days',
                        ],
                    ],
                ],
            ],
        ];

        $theme = Theme::getThemeName();

        foreach ($data as $item) {
            $item['theme'] = $theme;
            WidgetModel::query()->create($item);
        }
    }
}
