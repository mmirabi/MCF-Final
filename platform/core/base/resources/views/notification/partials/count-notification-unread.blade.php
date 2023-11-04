<input
    class="number-page"
    type="hidden"
    value="{{ $numberPages ?? 1 }}"
>
<input
    class="current-page"
    type="hidden"
    value="1"
>
<i class="fas fa-bell"></i>
@if ($countNotificationUnread > 0)
    <span class="badge badge-default"> {{ $countNotificationUnread }} </span>
@endif
