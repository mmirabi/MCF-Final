<div class="top-menu">
    <ul class="nav navbar-nav float-end">
        @auth
            @if (BaseHelper::getAdminPrefix() != '')
                <li class="dropdown">
                    <a
                        class="dropdown-toggle dropdown-header-name pe-2"
                        href="{{ route('public.index') }}"
                        target="_blank"
                    >
                        <i class="fa fa-globe"></i>
                        <span class="d-none d-sm-inline">
                            {{ trans('core/base::layouts.view_website') }}
                        </span>
                    </a>
                </li>
            @endif
            @if (Auth::guard()->check())
                {!! apply_filters(BASE_FILTER_TOP_HEADER_LAYOUT, null) !!}
            @endif

            @if (isset($themes) && is_array($themes) && count($themes) > 1 && setting('enable_change_admin_theme'))
                <li class="dropdown">
                    <a
                        class="dropdown-toggle dropdown-header-name"
                        data-bs-toggle="dropdown"
                        href="javascript:;"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <span class="d-inline d-sm-none"><i class="fas fa-palette"></i></span>
                        <span class="d-none d-sm-inline">{{ trans('core/base::layouts.theme') }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right icons-right">

                        @foreach ($themes as $name => $file)
                            @if ($activeTheme === $name)
                                <li class="active"><a
                                        href="{{ route('admin.theme', [$name]) }}">{{ Str::studly($name) }}</a></li>
                            @else
                                <li><a href="{{ route('admin.theme', [$name]) }}">{{ Str::studly($name) }}</a></li>
                            @endif
                        @endforeach

                    </ul>
                </li>
            @endif

            <li class="dropdown dropdown-user">
                <a
                    class="dropdown-toggle dropdown-header-name"
                    data-bs-toggle="dropdown"
                    href="javascript:void(0)"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <img
                        class="rounded-circle"
                        src="{{ Auth::guard()->user()->avatar_url }}"
                        alt="{{ Auth::guard()->user()->name }}"
                    />
                    <span class="username d-none d-sm-inline"> {{ Auth::guard()->user()->name }} </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('users.profile.view', Auth::guard()->id()) }}"><i class="icon-user"></i>
                            {{ trans('core/base::layouts.profile') }}</a></li>
                    <li><a
                            class="btn-logout"
                            href="{{ route('access.logout') }}"
                        ><i class="icon-key"></i> {{ trans('core/base::layouts.logout') }}</a></li>
                </ul>
            </li>
        @endauth
    </ul>
</div>
