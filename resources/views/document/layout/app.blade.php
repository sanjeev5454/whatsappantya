<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
@include('document.layout.partials.head')
</head>
<body class="animsition">
@auth
@include('document.layout.partials.nav')
@endauth
@yield('content')
@include('document.layout.partials.footer-scripts')
@auth
@include('document.layout.partials.footer')
@endauth
@yield('pagescript')
</body>
</html>