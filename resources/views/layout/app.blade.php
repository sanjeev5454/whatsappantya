<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
@include('layout.partials.head')
</head>
<body class="animsition @if (Auth::check())site-navbar-small dashboard @else page-login-v3 layout-full @endif">
@auth
@include('layout.partials.nav')
@endauth
@yield('content')
@include('layout.partials.footer-scripts')
@auth
@include('layout.partials.footer')
@endauth
@yield('pagescript')
</body>
</html>