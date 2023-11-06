<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
@include('whatsapp.layout.partials.head')
</head>
<body>
@auth
@include('whatsapp.layout.partials.nav')
@endauth
@yield('content')
@include('whatsapp.layout.partials.footer-scripts')
@auth
@include('whatsapp.layout.partials.footer')
@endauth
@yield('pagescript')
</body>
</html>