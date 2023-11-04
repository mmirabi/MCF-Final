<?php

namespace Botble\Base\Facades;

use Botble\Base\Supports\DashboardMenu as DashboardMenuSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Botble\Base\Supports\DashboardMenu make()
 * @method static \Botble\Base\Supports\DashboardMenu registerItem(array $options)
 * @method static \Botble\Base\Supports\DashboardMenu removeItem(array|string $id, $parentId = null)
 * @method static bool hasItem(string $id, string|null $parentId = null)
 * @method static \Illuminate\Support\Collection getAll()
 * @method static \Botble\Base\Supports\DashboardMenu when($value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \Botble\Base\Supports\DashboardMenu tap(callable|null $callback = null)
 *
 * @see \Botble\Base\Supports\DashboardMenu
 */
class DashboardMenu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DashboardMenuSupport::class;
    }
}
