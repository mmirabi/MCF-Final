<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\Blog\Models\Post;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Language\Models\LanguageMeta;
use Botble\Marketplace\Models\Store;
use Botble\Menu\Facades\Menu;
use Botble\Menu\Models\Menu as MenuModel;
use Botble\Menu\Models\MenuLocation;
use Botble\Menu\Models\MenuNode;
use Botble\Page\Models\Page;
use Illuminate\Support\Arr;

class MenuSeeder extends BaseSeeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Main menu',
                'slug' => 'main-menu',
                'location' => 'main-menu',
                'items' => [
                    [
                        'title' => 'Home',
                        'url' => '/',
                        'icon_font' => 'fi-rs-home',
                        'children' => [
                            [
                                'title' => 'Home 1',
                                'reference_id' => 1,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 2',
                                'reference_id' => 2,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 3',
                                'reference_id' => 3,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 4',
                                'reference_id' => 4,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 5',
                                'reference_id' => 16,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Home 6',
                                'reference_id' => 17,
                                'reference_type' => Page::class,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Shop',
                        'url' => '/products',
                        'children' => [
                            [
                                'title' => 'Shop Grid - Full Width',
                                'url' => '/products',
                            ],
                            [
                                'title' => 'Shop Grid - Right Sidebar',
                                'url' => '/products?layout=product-right-sidebar',
                            ],
                            [
                                'title' => 'Shop Grid - Left Sidebar',
                                'url' => '/products?layout=product-left-sidebar',
                            ],
                            [
                                'title' => 'Products Of Category',
                                'reference_id' => 1,
                                'reference_type' => ProductCategory::class,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Stores',
                        'url' => '/stores',
                        'children' => [
                            [
                                'title' => 'Stores - Grid',
                                'url' => '/stores',
                            ],
                            [
                                'title' => 'Stores - List',
                                'url' => '/stores?layout=stores-list',
                            ],
                            [
                                'title' => 'Store - Detail',
                                'url' => str_replace(url(''), '', Store::query()->find(1)->url),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Product',
                        'url' => str_replace(url(''), '', Product::query()->find(1)->url),
                        'children' => [
                            [
                                'title' => 'Product Right Sidebar',
                                'url' => str_replace(url(''), '', Product::query()->find(1)->url),
                            ],
                            [
                                'title' => 'Product Left Sidebar',
                                'url' => str_replace(url(''), '', Product::query()->find(2)->url),
                            ],
                            [
                                'title' => 'Product Full Width',
                                'url' => str_replace(url(''), '', Product::query()->find(3)->url),
                            ],
                        ],
                    ],
                    [
                        'title' => 'Blog',
                        'reference_id' => 5,
                        'reference_type' => Page::class,
                        'children' => [
                            [
                                'title' => 'Blog Grid',
                                'reference_id' => 5,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Blog List',
                                'reference_id' => 13,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Blog Big',
                                'reference_id' => 14,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Blog Wide',
                                'reference_id' => 15,
                                'reference_type' => Page::class,
                            ],
                            [
                                'title' => 'Single Post',
                                'url' => str_replace(url(''), '', Post::query()->find(1)->url),
                                'children' => [
                                    [
                                        'title' => 'Single Post Right Sidebar',
                                        'url' => str_replace(url(''), '', Post::query()->find(1)->url),
                                    ],
                                    [
                                        'title' => 'Single Post Left Sidebar',
                                        'url' => str_replace(url(''), '', Post::query()->find(2)->url),
                                    ],
                                    [
                                        'title' => 'Single Post Full Width',
                                        'url' => str_replace(url(''), '', Post::query()->find(3)->url),
                                    ],
                                    [
                                        'title' => 'Single Post with Product Listing',
                                        'url' => str_replace(url(''), '', Post::query()->find(4)->url),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'title' => 'FAQ',
                        'reference_id' => 18,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Contact',
                        'reference_id' => 6,
                        'reference_type' => Page::class,
                    ],
                ],
            ],
            [
                'name' => 'Header menu',
                'slug' => 'header-menu',
                'location' => 'header-navigation',
                'items' => [
                    [
                        'title' => 'About Us',
                        'reference_id' => 7,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Order Tracking',
                        'url' => '/orders/tracking',
                    ],
                ],
            ],
            [
                'name' => 'Product categories',
                'slug' => 'product-categories',
                'items' => [
                    [
                        'title' => 'Men',
                        'reference_id' => 1,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title' => 'Women',
                        'reference_id' => 2,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title' => 'Accessories',
                        'reference_id' => 3,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title' => 'Shoes',
                        'reference_id' => 4,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title' => 'Denim',
                        'reference_id' => 5,
                        'reference_type' => ProductCategory::class,
                    ],
                    [
                        'title' => 'Dress',
                        'reference_id' => 6,
                        'reference_type' => ProductCategory::class,
                    ],
                ],
            ],
            [
                'name' => 'Information',
                'slug' => 'information',
                'items' => [
                    [
                        'title' => 'Contact Us',
                        'reference_id' => 6,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'About Us',
                        'reference_id' => 7,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Cookie Policy',
                        'reference_id' => 8,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Terms & Conditions',
                        'reference_id' => 9,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Returns & Exchanges',
                        'reference_id' => 10,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Shipping & Delivery',
                        'reference_id' => 11,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Privacy Policy',
                        'reference_id' => 12,
                        'reference_type' => Page::class,
                    ],
                ],
            ],
            [
                'name' => 'Company',
                'slug' => 'company',
                'items' => [
                    [
                        'title' => 'About us',
                        'reference_id' => 7,
                        'reference_type' => Page::class,
                    ],
                    [
                        'title' => 'Affiliate',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Career',
                        'url' => '#',
                    ],
                    [
                        'title' => 'Contact us',
                        'reference_id' => 6,
                        'reference_type' => Page::class,
                    ],
                ],
            ],
        ];

        MenuModel::query()->truncate();
        MenuLocation::query()->truncate();
        MenuNode::query()->truncate();

        foreach ($data as $index => $item) {
            $menu = MenuModel::query()->create(Arr::except($item, ['items', 'location']));

            if (isset($item['location'])) {
                $menuLocation = MenuLocation::query()->create([
                    'menu_id' => $menu->id,
                    'location' => $item['location'],
                ]);

                LanguageMeta::saveMetaData($menuLocation);
            }

            foreach ($item['items'] as $menuNode) {
                $this->createMenuNode($index, $menuNode, $menu->id);
            }

            LanguageMeta::saveMetaData($menu);
        }

        Menu::clearCacheMenuItems();
    }

    protected function createMenuNode(int $index, array $menuNode, int $menuId, int $parentId = 0): void
    {
        $menuNode['menu_id'] = $menuId;
        $menuNode['parent_id'] = $parentId;

        if (isset($menuNode['url'])) {
            $menuNode['url'] = str_replace(url(''), '', $menuNode['url']);
        }

        if (Arr::has($menuNode, 'children')) {
            $children = $menuNode['children'];
            $menuNode['has_child'] = true;

            unset($menuNode['children']);
        } else {
            $children = [];
            $menuNode['has_child'] = false;
        }

        $createdNode = MenuNode::query()->create($menuNode);

        if ($children) {
            foreach ($children as $child) {
                $this->createMenuNode($index, $child, $menuId, $createdNode->id);
            }
        }
    }
}
