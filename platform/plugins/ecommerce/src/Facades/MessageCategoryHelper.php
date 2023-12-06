<?php

namespace Botble\Ecommerce\Facades;

use Botble\Ecommerce\Supports\MessageCategoryHelper as BaseMessageCategoryHelper;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAllMessageCategories(array $params = [], bool $onlyParent = false)
 * @method static \Illuminate\Support\Collection getActiveTreeCategories()
 * @method static \Illuminate\Support\Collection getTreeCategories(bool $activeOnly = false)
 * @method static array getTreeCategoriesOptions(\Illuminate\Support\Collection|array $categories, array $options = [], string|null $indent = null)
 * @method static string renderMessageCategoriesSelect(string|int|null $selected = null)
 * @method static \Illuminate\Support\Collection getMessageCategoriesWithUrl(array $categoryIds = [])
 * @method static \Illuminate\Database\Query\Builder applyQuery(\Illuminate\Database\Query\Builder $query)
 *
 * @see \Botble\Ecommerce\Supports\MessageCategoryHelper
 */
class MessageCategoryHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseMessageCategoryHelper::class;
    }
}
