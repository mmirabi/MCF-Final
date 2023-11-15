<?php

namespace Botble\Base\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AdminNotificationQueryBuilder extends BaseQueryBuilder
{
    public function hasPermission(): self
    {
        $user = Auth::guard()->user();

        if ($user->isSuperUser()) {
            return $this;
        }

        $this->where(function ($query) use ($user) {
            /**
             * @var Builder $query
             */
            $query
                ->whereNull('permission')
                ->orWhereIn('permission', $user->permissions);
        });

        return $this;
    }
}
