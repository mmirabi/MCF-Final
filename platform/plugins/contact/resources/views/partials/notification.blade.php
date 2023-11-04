<li class="dropdown dropdown-extended dropdown-inbox">
    <a
        class="dropdown-toggle dropdown-header-name"
        data-bs-toggle="dropdown"
        href="javascript:;"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="icon-envelope-open"></i>
        <span class="badge badge-default"> {{ $contacts->total() }} </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li class="external">
            <h3>{!! BaseHelper::clean(trans('plugins/contact::contact.new_msg_notice', ['count' => $contacts->total()])) !!}</h3>
            <a href="{{ route('contacts.index') }}">{{ trans('plugins/contact::contact.view_all') }}</a>
        </li>
        <li>
            <ul
                class="dropdown-menu-list scroller"
                data-handle-color="#637283"
                style="height: {{ $contacts->total() * 70 }}px;"
            >
                @foreach ($contacts as $contact)
                    <li>
                        <a href="{{ route('contacts.edit', $contact->id) }}">
                            <span class="photo">
                                <img
                                    class="rounded-circle"
                                    src="{{ $contact->avatar_url }}"
                                    alt="{{ $contact->name }}"
                                >
                            </span>
                            <span class="subject"><span class="from"> {{ $contact->name }} </span><span
                                    class="time">{{ BaseHelper::formatDateTime($contact->created_at) }} </span></span>
                            <span class="message"> {{ $contact->phone }} - {{ $contact->email }} </span>
                        </a>
                    </li>
                @endforeach

                @if ($contacts->total() > 10)
                    <li class="text-center"><a
                            href="{{ route('contacts.index') }}">{{ trans('plugins/contact::contact.view_all') }}</a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>
</li>
