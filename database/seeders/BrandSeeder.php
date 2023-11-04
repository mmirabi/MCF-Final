<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\Brand;
use Botble\Slug\Facades\SlugHelper;

class BrandSeeder extends BaseSeeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Perxsion',
            ],
            [
                'name' => 'Hiching',
            ],
            [
                'name' => 'Kepslo',
            ],
            [
                'name' => 'Groneba',
            ],
            [
                'name' => 'Babian',
            ],
            [
                'name' => 'Valorant',
            ],
            [
                'name' => 'Pure',
            ],
        ];

        Brand::query()->truncate();

        foreach ($brands as $key => $item) {
            $item['order'] = $key;
            $item['is_featured'] = true;
            $brand = Brand::query()->create($item);

            SlugHelper::createSlug($brand);
        }
    }
}
