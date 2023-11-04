<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call([
            LanguageSeeder::class,
            BrandSeeder::class,
            CurrencySeeder::class,
            ProductCategorySeeder::class,
            ProductCollectionSeeder::class,
            ProductLabelSeeder::class,
            ProductTagSeeder::class,
            ProductAttributeSeeder::class,
            ProductSeeder::class,
            TaxSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class,
            ShippingSeeder::class,
            StoreLocatorSeeder::class,
            FlashSaleSeeder::class,
            SimpleSliderSeeder::class,
            BlogSeeder::class,
            PageSeeder::class,
            UserSeeder::class,
            SettingSeeder::class,
            AdsSeeder::class,
            FaqSeeder::class,
            WidgetSeeder::class,
            ThemeOptionSeeder::class,
            ProductOptionSeeder::class,
            MarketplaceSeeder::class,
            MenuSeeder::class,
            OrderEcommerceSeeder::class,
        ]);

        $this->finished();
    }
}
