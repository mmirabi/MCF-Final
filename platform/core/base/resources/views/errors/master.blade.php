<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta
        name="robots"
        content="noindex,nofollow,noarchive"
    />
    <title>@yield('title')</title>
    <link
        href="{{ asset('vendor/core/core/base/css/error-pages.css') }}"
        rel="stylesheet"
    >
</head>

<body>
    <div class="container">
        @yield('message')
    </div>
</body>

</html>
