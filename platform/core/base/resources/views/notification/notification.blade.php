@once
    <li class="dropdown dropdown-extended dropdown-inbox">
        <a
            class="dropdown-toggle dropdown-header-name"
            id="open-notification"
            data-href="{{ route('notifications.update-notifications-count') }}"
            href="{{ route('notifications.get-notification') }}"
        >
            <input
                class="current-page"
                type="hidden"
                value="1"
            >
            <i class="fas fa-bell"></i>
            @if ($countNotificationUnread)
                <span class="badge badge-default"> {{ $countNotificationUnread }} </span>
            @endif
        </a>
    </li>
@endonce
