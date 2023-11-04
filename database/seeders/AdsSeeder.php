<?php

namespace Database\Seeders;

use Botble\Ads\Models\Ads;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AdsSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('promotion');

        Ads::query()->truncate();

        $items = [
            [
                'name' => 'Everyday Fresh',
                'key' => 'IZ6WU8KUALYD',
                'subtitle' => "Everyday Fresh & \nClean with Our \nProducts",
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Make your Breakfast',
                'key' => 'ILSFJVYFGCPZ',
                'subtitle' => 'Make your Breakfast Healthy and Easy',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'The best Organic',
                'key' => 'ILSDKVYFGXPH',
                'subtitle' => 'The best Organic Products Online',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Bring nature into your home',
                'key' => 'IZ6WU8KUALYG',
                'subtitle' => 'Bring nature into your home',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Delivered to your home',
                'key' => 'IZ6WU8KUALYH',
                'subtitle' => 'Delivered to your home',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Save 17% on Oganic Juice',
                'key' => 'IZ6WU8KUALYI',
                'subtitle' => 'Save 17% <br />on Oganic <br />Juice',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Everyday Fresh & Clean with Our Products',
                'key' => 'IZ6WU8KUALYJ',
                'subtitle' => 'Everyday Fresh & Clean with Our Products',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'The best Organic Products Online',
                'key' => 'IZ6WU8KUALYK',
                'subtitle' => 'The best Organic Products Online',
                'button_text' => 'Shop now',
                'url' => '/products',
            ],
            [
                'name' => 'Everyday Fresh with Our Products',
                'key' => 'IZ6WU8KUALYL',
                'subtitle' => "Everyday Fresh with\n Our Products",
                'button_text' => 'Go to supplier',
            ],
            [
                'name' => '100% guaranteed all Fresh items',
                'key' => 'IZ6WU8KUALYM',
                'subtitle' => "100% guaranteed all\n Fresh items",
                'button_text' => 'Go to supplier',
            ],
            [
                'name' => 'Special grocery sale off this month',
                'key' => 'IZ6WU8KUALYN',
                'subtitle' => "Special grocery sale\n off this month",
                'button_text' => 'Go to supplier',
            ],
            [
                'name' => 'Enjoy 15% OFF for all vegetable and fruit',
                'key' => 'IZ6WU8KUALYO',
                'subtitle' => "Enjoy 15% OFF for all\n vegetable and fruit",
                'button_text' => 'Go to supplier',
            ],
        ];

        foreach ($items as $index => $item) {
            $item['order'] = $index + 1;
            $item['location'] = 'not_set';

            if (! isset($item['key'])) {
                $item['key'] = strtoupper(Str::random(12));
            }

            $item['expired_at'] = Carbon::now()->addYears(5)->toDateString();
            $item['image'] = 'promotion/' . ($index + 1) . '.png';

            $ad = Ads::query()->create(Arr::except($item, ['subtitle', 'button_text']));

            MetaBox::saveMetaBoxData($ad, 'button_text', $item['button_text']);
            MetaBox::saveMetaBoxData($ad, 'subtitle', $item['subtitle']);
        }
    }
}
