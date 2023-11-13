<?php

use Botble\Ads\Facades\AdsManager;
use Botble\Ads\Models\Ads;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Models\FlashSale;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Faq\Models\FaqCategory;
use Botble\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.sliders.main';
        }, 120);
    }

    if (is_plugin_active('ecommerce')) {
        add_shortcode(
            'featured-product-categories',
            __('Featured Product Categories'),
            __('Featured Product Categories'),
            function (Shortcode $shortcode) {
                $categories = get_featured_product_categories();

                $categories->loadMissing('metadata');
                $categories->loadCount('products');

                return Theme::partial('shortcodes.ecommerce.featured-product-categories', compact('shortcode', 'categories'));
            }
        );

        shortcode()->setAdminConfig('featured-product-categories', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-product-categories-admin-config', compact('attributes'));
        });

        add_shortcode('flash-sale', __('Flash sale'), __('Flash sale'), function (Shortcode $shortcode) {
            $with = [
                'products' => function (BelongsToMany $query) {
                    $reviewParams = EcommerceHelper::withReviewsParams();

                    if (EcommerceHelper::isReviewEnabled()) {
                        $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                    }

                    return $query
                        ->wherePublished()
                        ->withCount($reviewParams['withCount'])
                        ->with(EcommerceHelper::withProductEagerLoadingRelations());
                },
                'metadata',
            ];

            $flashSalePopup = null;
            if ($flashSalePopupId = $shortcode->flash_sale_popup_id) {
                $flashSalePopup = FlashSale::query()
                    ->where('id', $flashSalePopupId)
                    ->notExpired()
                    ->with($with)
                    ->first();
            }

            $flashSaleIds = [];
            for ($i = 1; $i <= 4; $i++) {
                if ($shortcode->{'flash_sale_' . $i}) {
                    $flashSaleIds[] = $shortcode->{'flash_sale_' . $i};
                }
            }

            $flashSales = FlashSale::query()
                ->notExpired()
                ->wherePublished()
                ->with($with)
                ->whereIn('id', $flashSaleIds)
                ->get();

            if (! $flashSales->count()) {
                return null;
            }

            return Theme::partial('shortcodes.flash-sale.default', compact('shortcode', 'flashSales', 'flashSalePopup'));
        });

        shortcode()->setAdminConfig('flash-sale', function (array $attributes) {
            $flashSales = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->pluck('name', 'id')
                ->toArray();

            $flashSales = ['' => __('None')] + $flashSales;

            return Theme::partial('shortcodes.flash-sale.default-admin-config', compact('attributes', 'flashSales'));
        });

        add_shortcode('best-flash-sale', __('Best flash sale'), __('Best flash sale'), function (Shortcode $shortcode) {
            $flashSalePopup = null;
            if ($flashSaleId = $shortcode->flash_sale_id) {
                $flashSalePopup = FlashSale::query()
                    ->where(['id' => $flashSaleId])
                    ->notExpired()
                    ->wherePublished()
                    ->with([
                        'products' => function ($query) {
                            $reviewParams = EcommerceHelper::withReviewsParams();

                            if (EcommerceHelper::isReviewEnabled()) {
                                $query->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
                            }

                            return $query
                                ->wherePublished()
                                ->withCount($reviewParams['withCount'])
                                ->with(EcommerceHelper::withProductEagerLoadingRelations());
                        },
                        'metadata',
                    ])
                    ->first();
            }

            if (! $flashSalePopup || ! $flashSalePopup->products->count()) {
                return null;
            }

            return Theme::partial('shortcodes.flash-sale.best', compact('shortcode', 'flashSalePopup'));
        });

        shortcode()->setAdminConfig('best-flash-sale', function (array $attributes) {
            $flashSales = FlashSale::query()
                ->wherePublished()
                ->notExpired()
                ->pluck('name', 'id')
                ->toArray();

            $flashSales = ['' => __('None')] + $flashSales;

            return Theme::partial('shortcodes.flash-sale.best-admin-config', compact('attributes', 'flashSales'));
        });

        add_shortcode(
            'product-collections',
            __('Product Collections'),
            __('Product Collections'),
            function (Shortcode $shortcode) {
                $productCollections = get_product_collections(
                    ['status' => BaseStatusEnum::PUBLISHED],
                    [],
                    ['id', 'name', 'slug']
                );

                if ($productCollections->isEmpty()) {
                    return null;
                }

                $limit = (int)$shortcode->limit ?: 8;

                $products = get_products_by_collections(array_merge([
                    'collections' => [
                        'by' => 'id',
                        'value_in' => [$productCollections->first()->id],
                    ],
                    'take' => $limit,
                    'with' => EcommerceHelper::withProductEagerLoadingRelations(),
                ], EcommerceHelper::withReviewsParams()));

                $perRow = (int)$shortcode->per_row > 0 ? (int)$shortcode->per_row : 4;

                return Theme::partial('shortcodes.ecommerce.product-collections', [
                    'title' => $shortcode->title,
                    'productCollections' => $productCollections,
                    'limit' => $limit,
                    'products' => $products,
                    'perRow' => $perRow,
                ]);
            }
        );

        shortcode()->setAdminConfig('product-collections', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.product-collections-admin-config', compact('attributes'));
        });

        add_shortcode(
            'product-category-products',
            __('Product category products'),
            __('Product category products'),
            function (Shortcode $shortcode) {
                $category = app(ProductCategoryInterface::class)->getFirstBy([
                    'status' => BaseStatusEnum::PUBLISHED,
                    'id' => $shortcode->category_id,
                ], ['*'], [
                    'activeChildren' => function ($query) {
                        $query->limit(3);
                    },
                ]);

                if (! $category) {
                    return null;
                }

                $limit = (int)$shortcode->limit ?: 8;

                $products = app(ProductInterface::class)->getProductsByCategories(array_merge([
                    'categories' => [
                        'by' => 'id',
                        'value_in' => array_merge([$category->id], $category->activeChildren->pluck('id')->all()),
                    ],
                    'take' => $limit,
                ], EcommerceHelper::withReviewsParams()));

                $perRow = (int)$shortcode->per_row > 0 ? (int)$shortcode->per_row : 4;

                return Theme::partial('shortcodes.ecommerce.product-category-products', compact('category', 'products', 'limit', 'perRow'));
            }
        );

        shortcode()->setAdminConfig('product-category-products', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.product-category-products-admin-config', compact('attributes'));
        });

        add_shortcode('featured-brands', __('Featured Brands'), __('Featured Brands'), function (Shortcode $shortcode) {
            $brands = get_featured_brands();

            return Theme::partial('shortcodes.ecommerce.featured-brands', compact('shortcode', 'brands'));
        });

        shortcode()->setAdminConfig('featured-brands', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.featured-brands-admin-config', compact('attributes'));
        });

        add_shortcode('product-categories', __('Product Categories'), __('Product Categories'), function (Shortcode $shortcode) {
            $params = array_merge([
                'condition' => [
                    'ec_product_categories.status' => BaseStatusEnum::PUBLISHED,
                ],
                'take' => null,
                'order_by' => [
                    'ec_product_categories.order' => 'DESC',
                ],
                'select' => ['*'],
                'with' => ['slugable', 'metadata'],
            ]);

            $categoryIds = array_filter(explode(',', $shortcode->categories));

            if (! empty($categoryIds)) {
                $params['condition'][] = ['ec_product_categories.id', 'IN', $categoryIds];
            }

            $categories = app(ProductCategoryInterface::class)->advancedGet($params);

            return Theme::partial('shortcodes.ecommerce.product-categories', compact('shortcode', 'categories'));
        });

        shortcode()->setAdminConfig('product-categories', function (array $attributes) {
            $categoryIds = array_filter(explode(',', Arr::get($attributes, 'categories')));

            return Theme::partial('shortcodes.ecommerce.product-categories-admin-config', compact('attributes', 'categoryIds'));
        });

        add_shortcode('top-products-group', __('Top Products Group'), __('Top Products Group'), function (Shortcode $shortcode) {
            $tabs = array_filter(explode(',', $shortcode->tabs));

            if (empty($tabs)) {
                $tabs = ['top-selling', 'trending-products', 'recent-added', 'top-rated'];
            }

            $limit = 4;

            $with = ['slugable', 'variationInfo', 'productCollections'];

            $data = [];

            if (in_array('top-selling', $tabs)) {
                $endDate = Carbon::now();
                $startDate = Carbon::now()->subDays($shortcode->top_selling_in_days ?: 30);

                $topSellingQuery = Product::query()
                    ->join('ec_order_product', 'ec_products.id', '=', 'ec_order_product.product_id')
                    ->join('ec_orders', 'ec_orders.id', '=', 'ec_order_product.order_id');

                if (is_plugin_active('payment')) {
                    $topSellingQuery = $topSellingQuery
                        ->join('payments', 'payments.order_id', '=', 'ec_orders.id')
                        ->where('payments.status', PaymentStatusEnum::COMPLETED);
                }

                $topSelling = $topSellingQuery
                    ->whereDate('ec_orders.created_at', '>=', $startDate)
                    ->whereDate('ec_orders.created_at', '<=', $endDate)
                    ->select([
                        'ec_products.*',
                        'ec_order_product.qty as qty',
                    ])
                    ->with($with)
                    ->orderByDesc('ec_order_product.qty')
                    ->distinct()
                    ->limit($limit)
                    ->get();

                if ($topSelling->isNotEmpty()) {
                    $data[] = [
                        'title' => __('Top Selling'),
                        'products' => $topSelling,
                    ];
                }
            }

            if (in_array('trending-products', $tabs)) {
                $trendingProducts = get_trending_products([
                        'take' => $limit,
                        'with' => $with,
                    ] + EcommerceHelper::withReviewsParams());

                if ($trendingProducts->isNotEmpty()) {
                    $data[] = [
                        'title' => __('Trending Products'),
                        'products' => $trendingProducts,
                    ];
                }
            }

            if (in_array('recent-added', $tabs)) {
                $recentlyAdded = app(ProductInterface::class)
                    ->advancedGet([
                        'condition' => [
                            'ec_products.status' => BaseStatusEnum::PUBLISHED,
                            'ec_products.is_variation' => 0,
                        ],
                        'order_by' => [
                            'ec_products.order' => 'ASC',
                            'ec_products.created_at' => 'DESC',
                        ],
                        'take' => $limit,
                        'with' => $with,
                    ] + EcommerceHelper::withReviewsParams());

                if ($recentlyAdded->isNotEmpty()) {
                    $data[] = [
                        'title' => __('Recently Added'),
                        'products' => $recentlyAdded,
                    ];
                }
            }

            if (EcommerceHelper::isReviewEnabled() && in_array('top-rated', $tabs)) {
                $topRated = get_top_rated_products($limit, $with);

                if ($topRated->isNotEmpty()) {
                    $data[] = [
                        'title' => __('Top Rated'),
                        'products' => $topRated,
                    ];
                }
            }

            return Theme::partial('shortcodes.ecommerce.top-products-group', compact('shortcode', 'data'));
        });

        shortcode()->setAdminConfig('top-products-group', function (array $attributes) {
            $tabs = array_filter(explode(',', Arr::get($attributes, 'tabs')));

            if (empty($tabs)) {
                $tabs = ['top-selling', 'trending-products', 'recent-added', 'top-rated'];
            }

            return Theme::partial('shortcodes.ecommerce.top-products-group-admin-config', compact('tabs', 'attributes'));
        });

        add_shortcode('popular-products', __('Popular Products'), __('Popular Products'), function (Shortcode $shortcode) {
            $query = Product::query()
                ->join('meta_boxes', function ($join) {
                    $join
                        ->on('ec_products.id', '=', 'meta_boxes.reference_id')
                        ->where('meta_boxes.reference_type', '=', Product::class);
                })
                ->where([
                    'meta_boxes.meta_key' => 'is_popular',
                    'meta_boxes.meta_value' => '["1"]',
                    'ec_products.status' => BaseStatusEnum::PUBLISHED,
                    'ec_products.is_variation' => 0,
                ])
                ->with(array_merge(['metadata'], EcommerceHelper::withProductEagerLoadingRelations()))
                ->orderBy('ec_products.created_at', 'DESC')
                ->orderBy('ec_products.order', 'ASC')
                ->limit((int) $shortcode->limit ?: 8)
                ->select('ec_products.*')
                ->distinct();

            if (EcommerceHelper::isReviewEnabled()) {
                $reviewParams = EcommerceHelper::withReviewsParams();

                $query
                    ->withCount($reviewParams['withCount'])
                    ->withAvg($reviewParams['withAvg'][0], $reviewParams['withAvg'][1]);
            }

            $products = $query->get();

            return Theme::partial('shortcodes.ecommerce.popular-products', compact('shortcode', 'products'));
        });

        shortcode()->setAdminConfig('popular-products', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.popular-products-admin-config', compact('attributes'));
        });

        add_shortcode('trending-products', __('Trending products'), __('Trending products'), function (Shortcode $shortcode) {
            return Theme::partial('shortcodes.ecommerce.trending-products', compact('shortcode'));
        });

        shortcode()->setAdminConfig('trending-products', function (array $attributes) {
            return Theme::partial('shortcodes.ecommerce.trending-products-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('ads')) {
        add_shortcode('theme-ads', __('Theme ads'), __('Theme ads'), function (Shortcode $shortcode) {
            $keys = get_ads_keys_from_shortcode($shortcode);

            return display_ads($keys, $shortcode->style);
        });

        shortcode()->setAdminConfig('theme-ads', function (array $attributes) {
            $ads = Ads::query()
                ->wherePublished()
                ->notExpired()
                ->get();

            return Theme::partial('shortcodes.ads.config-in-admin', compact('ads', 'attributes'));
        });

        AdsManager::load(false, ['metadata']);

        function display_ad(BaseModel|string $ads, string $class = '', $loop = null): ?string
        {
            if (! ($ads instanceof BaseModel)) {
                $ads = AdsManager::getData()
                    ->where('key', $ads)
                    ->first();
            }

            if (! $ads || ! $ads->image) {
                return null;
            }

            if ($ads->location &&
                $ads->location != 'not_set' &&
                view()->exists(Theme::getThemeNamespace() . '::partials.shortcodes.ads.' . $ads->location)) {
                return Theme::partial('shortcodes.ads.' . $ads->location, compact('ads', 'class', 'loop'));
            }

            return Theme::partial('shortcodes.ads.item', compact('ads', 'class', 'loop'));
        }

        function get_ads_keys_from_shortcode($shortcode): array
        {
            $keys = collect($shortcode->toArray())
                ->sortKeys()
                ->filter(function ($value, $key) use ($shortcode) {
                    return Str::startsWith($key, 'ads_') ||
                        ($shortcode->name == 'theme-ads' && Str::startsWith($key, 'key_'));
                });

            return array_filter($keys->toArray() + [$shortcode->ads]);
        }

        function display_ads(array $keys, ?string $style = ''): string
        {
            $keys = collect($keys);

            return Theme::partial('shortcodes.ads.items', compact('keys', 'style'));
        }

        if (is_plugin_active('simple-slider')) {
            add_filter(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, function ($data, $key, $attributes) {
                if ($key != 'simple-slider') {
                    return $data;
                }

                if (is_plugin_active('ads')) {
                    $ads = Ads::query()
                        ->wherePublished()
                        ->notExpired()
                        ->get();
                    $data .= Theme::partial('shortcodes.ads.config-in-admin', compact('ads', 'attributes') + ['total' => 2]);
                }

                if (is_plugin_active('newsletter')) {
                    $data .= Theme::partial('shortcodes.sliders.newsletter-form-option', compact('attributes'));
                }

                return $data . Theme::partial('shortcodes.sliders.config-in-admin', compact('ads', 'attributes'));
            }, 50, 3);
        }
    }

    if (is_plugin_active('blog')) {
        add_shortcode('featured-news', __('Featured News'), __('Featured News'), function (Shortcode $shortcode) {
            $posts = app(PostInterface::class)->getFeatured(4, ['slugable']);

            return Theme::partial('shortcodes.featured-news', ['title' => $shortcode->title, 'posts' => $posts]);
        });

        shortcode()->setAdminConfig('featured-news', function (array $attributes) {
            return Theme::partial('shortcodes.featured-news-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace() . '::partials.shortcodes.contact-form';
        }, 120);
    }

    add_shortcode('our-offices', __('Our offices'), __('Our offices'), function () {
        return Theme::partial('shortcodes.our-offices');
    });

    shortcode()->setAdminConfig('our-offices', function (array $attributes) {
        return Theme::partial('shortcodes.our-offices-admin-config', compact('attributes'));
    });

    add_shortcode('big-banner', __('Big banner'), __('Big banner'), function (Shortcode $shortcode) {
        return Theme::partial('shortcodes.big-banner', compact('shortcode'));
    });

    shortcode()->setAdminConfig('big-banner', function (array $attributes) {
        return Theme::partial('shortcodes.big-banner-admin-config', compact('attributes'));
    });

    if (is_plugin_active('faq')) {
        add_shortcode('faqs', __('FAQs'), __('List of FAQs'), function (Shortcode $shortcode) {
            $params = [
                'condition' => [
                    'status' => BaseStatusEnum::PUBLISHED,
                ],
                'with' => [
                    'faqs' => function ($query) {
                        $query->wherePublished();
                    },
                ],
                'order_by' => [
                    'faq_categories.order' => 'ASC',
                    'faq_categories.created_at' => 'DESC',
                ],
            ];

            if ($shortcode->category_id) {
                $params['condition']['id'] = $shortcode->category_id;
            }

            $categories = app(FaqCategoryInterface::class)->advancedGet($params);

            return Theme::partial('shortcodes.faqs', compact('categories'));
        });

        shortcode()->setAdminConfig('faqs', function (array $attributes) {
            $categories = FaqCategory::query()
                ->wherePublished()
                ->pluck('name', 'id')
                ->all();

            return Theme::partial('shortcodes.faqs-admin-config', compact('attributes', 'categories'));
        });
    }
});
