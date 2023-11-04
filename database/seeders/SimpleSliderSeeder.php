<?php

namespace Database\Seeders;

use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\SimpleSlider\Models\SimpleSlider;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Support\Arr;

class SimpleSliderSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('sliders');

        SimpleSlider::query()->truncate();
        SimpleSliderItem::query()->truncate();

        $sliders = [
            [
                'name' => 'Home slider 1',
                'key' => 'home-slider-1',
                'total' => 2,
                'style' => 'style-4',
            ],
            [
                'name' => 'Home slider 2',
                'key' => 'home-slider-2',
                'total' => 2,
                'style' => 'style-2',
            ],
            [
                'name' => 'Home slider 3',
                'key' => 'home-slider-3',
                'total' => 2,
                'style' => 'style-3',
            ],
            [
                'name' => 'Home slider 4',
                'key' => 'home-slider-4',
                'total' => 2,
                'style' => 'style-1',
            ],
            [
                'name' => 'Home slider 5',
                'key' => 'home-slider-5',
                'total' => 2,
                'style' => 'style-5',
            ],
            [
                'name' => 'Home slider 6',
                'key' => 'home-slider-6',
                'total' => 1,
                'style' => 'style-6',
            ],
            [
                'name' => 'Blog slider 1',
                'key' => 'blog-slider-1',
                'total' => 6,
                'style' => 'style-1',
                'gallery' => true,
            ],
        ];

        $sliderItems = [
            [
                'title' => 'Don’t miss amazing<br /> grocery deals',
                'link' => '/products',
                'description' => 'Sign up for the daily newsletter',
            ],
            [
                'title' => 'Fresh Vegetables<br />
										Big discount',
                'link' => '/products',
                'description' => 'Save up to 50% off on your first order',
            ],
        ];

        foreach ($sliders as $index => $value) {
            $slider = SimpleSlider::query()->create(Arr::only($value, ['name', 'key']));

            LanguageMeta::saveMetaData($slider);

            if (Arr::get($value, 'style')) {
                MetaBox::saveMetaBoxData($slider, 'simple_slider_style', $value['style']);
            }

            if (Arr::get($value, 'gallery')) {
                for ($i = 1; $i <= $value['total']; $i++) {
                    $item = [
                        'image' => 'sliders/thumbnail-' . $i . '.jpg',
                        'order' => $i,
                        'simple_slider_id' => $slider->id,
                    ];

                    SimpleSliderItem::query()->create($item);
                }
            } else {
                foreach (collect($sliderItems)->take($value['total']) as $key => $item) {
                    $item['image'] = 'sliders/' . ($index + 1) . '-' . ($key + 1) . '.png';
                    $item['order'] = $key + 1;
                    $item['simple_slider_id'] = $slider->id;

                    SimpleSliderItem::query()->create($item);
                }
            }
        }
    }
}
