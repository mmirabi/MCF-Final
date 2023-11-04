<?php

use Botble\Ecommerce\Models\ProductCategory;
use Botble\Widget\AbstractWidget;
use Illuminate\Support\Collection;

class ProductCategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Product Categories'),
            'description' => __('Widget display product categories'),
            'number_display' => 10,
        ]);
    }

    public function data(): array|Collection
    {
        $categories = ProductCategory::query()
            ->where('is_featured', true)
            ->wherePublished()
            ->orderBy('order')
            ->orderByDesc('created_at')
            ->with(['slugable', 'metadata'])
            ->withCount('products')
            ->limit((int)$this->getConfig('number_display', 10) ?: 10)
            ->get();

        return compact('categories');
    }
}
