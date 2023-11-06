<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
@include('purchaseorder.layout.partials.head')
</head>
<body class="@if (Auth::check())site-navbar-small dashboard @else page-login-v3 layout-full @endif">
@auth
@include('purchaseorder.layout.partials.nav')
@endauth
@yield('content')
@include('purchaseorder.layout.partials.footer-scripts')
@auth
@include('purchaseorder.layout.partials.footer')
@endauth
@yield('pagescript')
</body>
</html>