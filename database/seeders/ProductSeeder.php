<?php

namespace Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Enums\ProductTypeEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\OrderAddress;
use Botble\Ecommerce\Models\OrderHistory;
use Botble\Ecommerce\Models\OrderProduct;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductFile;
use Botble\Ecommerce\Models\ProductVariation;
use Botble\Ecommerce\Models\ProductVariationItem;
use Botble\Ecommerce\Models\Shipment;
use Botble\Ecommerce\Models\ShipmentHistory;
use Botble\Ecommerce\Models\Wishlist;
use Botble\Ecommerce\Services\Products\StoreProductService;
use Botble\Payment\Models\Payment;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->uploadFiles('products');

        $faker = $this->fake();

        $products = [
            [
                'id' => 1,
                'name' => 'Seeds of Change Organic Quinoe',
                'price' => $faker->numberBetween(200, 500),
                'is_featured' => true,
                'layout' => 'product-right-sidebar',
            ],
            [
                'id' => 2,
                'name' => 'All Natural Italian-Style Chicken Meatballs',
                'price' => $faker->numberBetween(200, 500),
                'sale_price' => $faker->numberBetween(150, 200),
                'is_featured' => true,
                'layout' => 'product-left-sidebar',
            ],
            [
                'id' => 3,
                'name' => 'Angie’s Boomchickapop Sweet & Salty Kettle Corn',
                'price' => $faker->numberBetween(200, 500),
                'sale_price' => $faker->numberBetween(50, 60),
                'is_featured' => true,
                'layout' => 'product-full-width',
            ],
            [
                'id' => 4,
                'name' => 'Foster Farms Takeout Crispy Classic',
                'price' => $faker->numberBetween(70, 90),
                'is_featured' => true,
            ],
            [
                'id' => 5,
                'name' => 'Blue Diamond Almonds Lightly',
                'price' => $faker->numberBetween(40, 50),
                'sale_price' => $faker->numberBetween(50, 60),
                'is_featured' => true,
            ],
            [
                'id' => 6,
                'name' => 'Chobani Complete Vanilla Greek',
                'price' => $faker->numberBetween(50, 60),
                'is_featured' => true,
            ],
            [
                'id' => 7,
                'name' => 'Canada Dry Ginger Ale – 2 L Bottle',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 8,
                'name' => 'Encore Seafoods Stuffed Alaskan',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 9,
                'name' => 'Gorton’s Beer Battered Fish Fillets',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 10,
                'name' => 'Haagen-Dazs Caramel Cone Ice Cream',
                'price' => $faker->numberBetween(200, 500),
                'sale_price' => $faker->numberBetween(150, 200),
                'is_featured' => true,
            ],
            [
                'id' => 11,
                'name' => 'Nestle Original Coffee-Mate Coffee Creamer',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 12,
                'name' => 'Naturally Flavored Cinnamon Vanilla Light Roast Coffee',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 13,
                'name' => 'Pepperidge Farm Farmhouse Hearty White Bread',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 14,
                'name' => 'Organic Frozen Triple Berry Blend',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 15,
                'name' => 'Oroweat Country Buttermilk Bread',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 16,
                'name' => 'Foster Farms Takeout Crispy Classic Buffalo Wings',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 17,
                'name' => 'Angie’s Boomchickapop Sweet & Salty Kettle Corn',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 18,
                'name' => 'All Natural Italian-Style Chicken Meatballs',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 19,
                'name' => 'Simply Lemonade with Raspberry Juice',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 20,
                'name' => 'Perdue Simply Smart Organics Gluten Free',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 21,
                'name' => 'Chen Watermelon',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 22,
                'name' => 'Organic Cage-Free Grade A Large Brown Eggs',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 23,
                'name' => 'Colorful Banana',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
            [
                'id' => 24,
                'name' => 'Signature Wood-Fired Mushroom and Caramelized',
                'price' => $faker->numberBetween(110, 130),
                'sale_price' => $faker->numberBetween(90, 100),
                'is_featured' => true,
            ],
        ];

        Product::query()->truncate();
        DB::table('ec_product_with_attribute_set')->truncate();
        DB::table('ec_product_variations')->truncate();
        DB::table('ec_product_variation_items')->truncate();
        DB::table('ec_product_collection_products')->truncate();
        DB::table('ec_product_label_products')->truncate();
        DB::table('ec_product_category_product')->truncate();
        DB::table('ec_product_related_relations')->truncate();
        Wishlist::query()->truncate();
        Order::query()->truncate();
        OrderAddress::query()->truncate();
        OrderProduct::query()->truncate();
        OrderHistory::query()->truncate();
        Shipment::query()->truncate();
        ShipmentHistory::query()->truncate();
        Payment::query()->truncate();
        ProductFile::query()->truncate();

        foreach ($products as $key => $item) {
            if (! isset($item['description'])) {
                $item['description'] = file_get_contents(__DIR__ . '/contents/product-description.html');
            }

            $item['content'] = file_get_contents(__DIR__ . '/contents/product-content.html');
            $item['status'] = BaseStatusEnum::PUBLISHED;
            $item['sku'] = 'HS-' . $faker->numberBetween(100, 200);
            $item['brand_id'] = $faker->numberBetween(1, 7);
            $item['views'] = $faker->numberBetween(1000, 200000);
            $item['quantity'] = $faker->numberBetween(10, 20);
            $item['length'] = $faker->numberBetween(10, 20);
            $item['wide'] = $faker->numberBetween(10, 20);
            $item['height'] = $faker->numberBetween(10, 20);
            $item['weight'] = $faker->numberBetween(500, 900);
            $item['with_storehouse_management'] = true;

            // Support Digital Product
            $productName = $item['name'];
            if ($key % 4 == 0) {
                $item['product_type'] = ProductTypeEnum::DIGITAL;
                $item['name'] .= ' (' . ProductTypeEnum::DIGITAL()->label() . ')';
            }

            $images = [
                'products/' . ($key + 1) . '.jpg',
            ];

            for ($i = 1; $i <= 10; $i++) {
                if (File::exists(database_path('seeders/files/products/' . ($key + 1) . '-' . $i . '.jpg'))) {
                    $images[] = 'products/' . ($key + 1) . '-' . $i . '.jpg';
                }
            }

            $item['images'] = json_encode($images);

            $product = Product::query()->create(Arr::except($item, ['layout']));

            $layout = $item['layout'] ?? null;
            if ($layout) {
                MetaBox::saveMetaBoxData($product, 'layout', $layout);
            }

            $product->productCollections()->sync([$faker->numberBetween(1, 3)]);

            if ($product->id % 7 == 0) {
                $product->productLabels()->sync([$faker->numberBetween(1, 3)]);
            }

            $product->categories()->sync([
                $faker->numberBetween(1, 14),
            ]);

            $product->tags()->sync([
                $faker->numberBetween(1, 6),
                $faker->numberBetween(1, 6),
                $faker->numberBetween(1, 6),
            ]);

            if ($product->id % 2 == 0) {
                MetaBox::saveMetaBoxData($product, 'is_popular', '1');
            }

            $product->taxes()->sync([1]);

            SlugHelper::createSlug($product);

            MetaBox::saveMetaBoxData(
                $product,
                'faq_schema_config',
                json_decode(
                    '[[{"key":"question","value":"What Shipping Methods Are Available?"},{"key":"answer","value":"Ex Portland Pitchfork irure mustache. Eutra fap before they sold out literally. Aliquip ugh bicycle rights actually mlkshk, seitan squid craft beer tempor."}],[{"key":"question","value":"Do You Ship Internationally?"},{"key":"answer","value":"Hoodie tote bag mixtape tofu. Typewriter jean shorts wolf quinoa, messenger bag organic freegan cray."}],[{"key":"question","value":"How Long Will It Take To Get My Package?"},{"key":"answer","value":"Swag slow-carb quinoa VHS typewriter pork belly brunch, paleo single-origin coffee Wes Anderson. Flexitarian Pitchfork forage, literally paleo fap pour-over. Wes Anderson Pinterest YOLO fanny pack meggings, deep v XOXO chambray sustainable slow-carb raw denim church-key fap chillwave Etsy. +1 typewriter kitsch, American Apparel tofu Banksy Vice."}],[{"key":"question","value":"What Payment Methods Are Accepted?"},{"key":"answer","value":"Fashion axe DIY jean shorts, swag kale chips meh polaroid kogi butcher Wes Anderson chambray next level semiotics gentrify yr. Voluptate photo booth fugiat Vice. Austin sed Williamsburg, ea labore raw denim voluptate cred proident mixtape excepteur mustache. Twee chia photo booth readymade food truck, hoodie roof party swag keytar PBR DIY."}],[{"key":"question","value":"Is Buying On-Line Safe?"},{"key":"answer","value":"Art party authentic freegan semiotics jean shorts chia cred. Neutra Austin roof party Brooklyn, synth Thundercats swag 8-bit photo booth. Plaid letterpress leggings craft beer meh ethical Pinterest."}]]',
                    true
                )
            );
        }

        $countProducts = count($products);

        foreach ($products as $key => $item) {
            $product = Product::query()->find($key + 1);

            if (! $product) {
                continue;
            }

            $product->productAttributeSets()->sync([1, 2]);

            $product->crossSales()->sync([
                $this->random(1, $countProducts, [$product->id]),
                $this->random(1, $countProducts, [$product->id]),
                $this->random(1, $countProducts, [$product->id]),
                $this->random(1, $countProducts, [$product->id]),
            ]);

            for ($j = 0; $j < $faker->numberBetween(1, 5); $j++) {
                $variation = Product::query()->create([
                    'name' => $product->name,
                    'status' => BaseStatusEnum::PUBLISHED,
                    'sku' => $product->sku . '-A' . $j,
                    'quantity' => $product->quantity,
                    'weight' => $product->weight,
                    'height' => $product->height,
                    'wide' => $product->wide,
                    'length' => $product->length,
                    'price' => $product->price,
                    'sale_price' => $product->id % 4 == 0 ? ($product->price - $product->price * $faker->numberBetween(
                        10,
                        30
                    ) / 100) : null,
                    'brand_id' => $product->brand_id,
                    'with_storehouse_management' => $product->with_storehouse_management,
                    'is_variation' => true,
                    'images' => json_encode([$product->images[$j] ?? Arr::first($product->images)]),
                    'product_type' => $product->product_type,
                ]);

                $productVariation = ProductVariation::query()->create([
                    'product_id' => $variation->id,
                    'configurable_product_id' => $product->id,
                    'is_default' => $j == 0,
                ]);

                if ($productVariation->is_default) {
                    $product->update([
                        'sku' => $variation->sku,
                        'sale_price' => $variation->sale_price,
                    ]);
                }

                ProductVariationItem::query()->create([
                    'attribute_id' => $faker->numberBetween(1, 5),
                    'variation_id' => $productVariation->id,
                ]);

                ProductVariationItem::query()->create([
                    'attribute_id' => $faker->numberBetween(6, 10),
                    'variation_id' => $productVariation->id,
                ]);

                if ($product->isTypeDigital()) {
                    foreach ($product->images as $img) {
                        $productFile = database_path('seeders/files/' . $img);

                        if (! File::isFile($productFile)) {
                            continue;
                        }

                        $fileUpload = new UploadedFile(
                            $productFile,
                            Str::replace('products/', '', $img),
                            'image/jpeg',
                            null,
                            true
                        );
                        $productFileData = app(StoreProductService::class)->saveProductFile($fileUpload);
                        $variation->productFiles()->create($productFileData);
                    }
                }
            }
        }
    }
}
