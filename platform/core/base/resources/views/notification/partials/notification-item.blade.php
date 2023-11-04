@forelse ($notifications as $notification)
    <li
        id="notification-{{ $notification->id }}"
        @class(['list-group-item', 'read' => $notification->read_at !== null])
    >
        <div class="notification-info">
            <span class="icon"><i class="fa fa-bell"></i></span>
            <p title="{{ BaseHelper::clean($notification->title) }}">{!! Str::limit(BaseHelper::clean($notification->title), 30) !!}</p>
            <div class="txt-info">
                <p class="time">{{ $notification->created_at->diffForHumans() }}</p>
                <strong class="description-notification-{{ $notification->id }}">{!! Str::limit(BaseHelper::clean($notification->description), 80) !!}</strong>
                <span
                    class="btn-toggle-description"
                    @if (Str::length(BaseHelper::clean($notification->description)) <= 80) style="display: none" @endif
                >
                    <a
                        class="show-more-description show-more-{{ $notification->id }}"
                        data-id="{{ $notification->id }}"
                        data-class="description-notification-{{ $notification->id }}"
                        data-description="{{ BaseHelper::clean($notification->description) }}"
                        href="javascript:void(0)"
                    >{{ trans('core/base::notifications.show_more') }}</a>
                    <a
                        class="show-less-description show-less-{{ $notification->id }}"
                        data-id="{{ $notification->id }}"
                        data-class="description-notification-{{ $notification->id }}"
                        data-description="{{ Str::limit(BaseHelper::clean($notification->description)) }}"
                        href="javascript:void(0)"
                        style="display: none"
                    >{{ trans('core/base::notifications.show_less') }}</a>
                </span>
                <br>
                @if ($notification->action_url && $notification->action_url !== '#')
                    <a
                        class="action-view"
                        href="{{ route('notifications.read-notification', $notification->id) }}"
                    >{{ $notification->action_label ? __($notification->action_label) : trans('core/base::notifications.view') }}</a>
                @endif
            </div>
            <a
                class="close-notification btn-delete-notification text-danger"
                data-href="{{ route('notifications.destroy-notification', $notification->id) }}"
                href="#"
            ><i class="fa fa-times"></i></a>
        </div>
    </li>

@empty
    <div class="text-center no-data-notification">
        <i class="fa fa-bell fa-2xl text-warning mb-4"></i>
        <h5 class="title">{{ trans('core/base::notifications.no_notification_here') }}</h5>
        <p class="text-dark description">{{ trans('core/base::notifications.please_check_again_later') }}</p>
    </div>
@endforelse

@if (!empty($notification) && $notifications->hasMorePages())
    <li style="background-color: unset">
        <div class="text-center mt-2 mb-2 wrap-view-more">
            <a
                class="view-more-notification"
                href="javascript:void(0)"
            >{{ trans('core/base::notifications.view_more') }}</a>
        </div>
    </li>
@endif
