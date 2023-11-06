<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('seo_title') </title>
    
	
	<link rel="apple-touch-icon" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assetsassets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assetsassets/images/favicon.ico">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/css/bootstrap-extend.min.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/css/site.min.css">
    
    <!-- Plugins -->
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asscrollable/asScrollable.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/switchery/switchery.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/intro-js/introjs.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/slidepanel/slidePanel.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-mmenu/jquery-mmenu.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/flag-icon-css/flag-icon.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/waves/waves.css">
        <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/examples/css/pages/errors.css">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    
    <!--[if lt IE 9]>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    
    <!--[if lt IE 10]>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/media-match/media.match.min.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    
    <!-- Scripts -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
	   
</head>
<body  class="animsition page-error page-error-404 layout-full">
 <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


    <!-- Page -->
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
      <div class="page-content vertical-align-middle">
        <header>
          <h1 class="animation-slide-top">@yield('page_title')</h1>
          <p>Page Not Found !</p>
        </header>
        <p class="error-advise">@yield('message')</p>
        <a class="btn btn-primary btn-round" href="{{ route('login') }}">GO TO HOME PAGE</a>

        <footer class="page-copyright">
          <p>© {{ date('Y')}}. All RIGHT RESERVED.</p>
        </footer>
      </div>
    </div>
    <!-- End Page -->
	<!-- Core  -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery/jquery.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/popper-js/umd/popper.min.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/animsition/animsition.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/asscrollable/jquery-asScrollable.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/waves/waves.js"></script>
    
    <!-- Plugins -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-mmenu/jquery.mmenu.min.all.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/switchery/switchery.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/intro-js/intro.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/screenfull/screenfull.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/slidepanel/jquery-slidePanel.js"></script>
    
    <!-- Scripts -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Component.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Base.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Config.js"></script>
    
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/Menubar.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/Sidebar.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/PageAside.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Section/GridMenu.js"></script>
    
    <!-- Config -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/config/colors.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/config/tour.js"></script>
    <script>Config.set('assets', '{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets');</script>
    
    <!-- Page -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Site.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/asscrollable.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/slidepanel.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/switchery.js"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
</body>
</html>
