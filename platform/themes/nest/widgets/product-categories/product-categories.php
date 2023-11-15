<?php

use Botble\Ecommerce\Facades\ProductCategoryHelper;
use Botble\Ecommerce\Models\ProductCategory;
use Botble\Widget\AbstractWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Product Categories'),
            'description' => __('Widget display product categories'),
            'number_display' => 10,
            'categories' => [],
        ]);
    }

    public function data(): array|Collection
    {
        if (! is_plugin_active('ecommerce')) {
            return [
                'categories' => collect(),
            ];
        }

        $categoryIds = $this->getConfig('categories');

        $categories = ProductCategory::query()
            ->where('is_featured', true)
            ->wherePublished()
            ->when($categoryIds, fn (Builder $query) => $query->whereIn('id', $categoryIds))
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->with(['slugable'])
            ->withCount('products')
            ->limit((int)$this->getConfig('number_display', 10) ?: 10)
            ->get();

        return compact('categories');
    }

    public function adminConfig(): array
    {
        if (! is_plugin_active('ecommerce')) {
            return [
                'categories' => collect(),
            ];
        }

        return [
            'categories' => ProductCategoryHelper::getActiveTreeCategories(),
        ];
    }
}
