<?php

namespace Botble\Base\Http\Controllers;

use Botble\Base\Models\AdminNotification;
use Botble\Base\Models\AdminNotificationQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class NotificationController extends BaseController
{
    public function getNotification()
    {
        /**
         * @var AdminNotificationQueryBuilder $adminQuery
         */
        $adminQuery = AdminNotification::query();

        $query = $adminQuery->hasPermission();

        $notifications = $query
            ->latest()
            ->paginate(10);

        return view('core/base::notification.partials.notification-item', compact('notifications'));
    }

    public function countNotification()
    {
        $countNotificationUnread = AdminNotification::countUnread();

        return view('core/base::notification.partials.count-notification-unread', compact('countNotificationUnread'));
    }

    public function delete(int|string $id)
    {
        $notificationItem = AdminNotification::query()->findOrFail($id);
        $notificationItem->delete();

        /**
         * @var AdminNotificationQueryBuilder $adminQuery
         */
        $adminQuery = AdminNotification::query();

        /**
         * @var Builder $query
         */
        $query = $adminQuery->hasPermission();

        if (! $query->exists()) {
            return [
                'view' => view('core/base::notification.partials.sidebar-notification')->render(),
            ];
        }

        return [];
    }

    public function deleteAll()
    {
        AdminNotification::query()->delete();

        return view('core/base::notification.partials.sidebar-notification');
    }

    public function read(int|string $id)
    {
        /**
         * @var AdminNotification $notificationItem
         */
        $notificationItem = AdminNotification::query()->findOrFail($id);

        if ($notificationItem->read_at === null) {
            $notificationItem->markAsRead();
        }

        if (! $notificationItem->action_url || $notificationItem->action_url == '#') {
            return redirect()->back();
        }

        return redirect()->to(url($notificationItem->action_url));
    }

    public function readAll()
    {
        AdminNotification::query()
            ->whereNull('read_at')
            ->update([
                'read_at' => Carbon::now(),
            ]);

        return [];
    }
}
