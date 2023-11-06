<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="TechVoi.com">
	<meta name="_base_url" content="{{ url('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Sanjeev">    
    <title>{{ __('Login') }}</title>
    
    <link rel="apple-touch-icon" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/images/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/images/favicon.ico">
    
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
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/examples/css/pages/login.css">
    
    
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/fonts/material-design/material-design.min.css">
    <link rel="stylesheet" href="{{asset(PUBLIC_FOLDER.'theme')}}/global/fonts/brand-icons/brand-icons.min.css">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
   
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
      Breakpoints();
    </script>
  </head>
  
  <body class="animsition page-login layout-full page-dark">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please upgrade your browser to improve your experience.</p>
    <![endif]-->
	
    <!-- Page -->
	@if(@$_COOKIE['session_google_id']=='')
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
	  	<div class="lds-spinner" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      <div class="page-content login vertical-align-middle">
	  
        <div class="brand">
          <img class="brand-img" src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/images/logo.png" alt="...">
          <h2 class="brand-text">{{WEBSITE_NAME}}</h2>
        </div>
        <p>Sign into your account</p>
        
		
		<a href="javascript:void(0);" id="btnLogin" onClick="handleAuthClick()" class="btn btn-lg btn-primary btn-block">
          <strong>Login With Google</strong>
          </a>
		  
        <!--<p>Still no account? Please go to <a href="{{ route('register') }}">Register</a></p>-->

        <footer class="page-copyright page-copyright-inverse">
          <p>&copy; {{ date('Y') }}. All RIGHT RESERVED.</p>
          
        </footer>
      </div>
    </div>
	
    <!-- End Page -->
	
	
    @endif
	
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
        <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    
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
    <script>Config.set("assets", "{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets");</script>
    
    <!-- Page -->
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/mmenu/assets/js/Site.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/asscrollable.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/slidepanel.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/switchery.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/jquery-placeholder.js"></script>
    <script src="{{asset(PUBLIC_FOLDER.'theme')}}/global/js/Plugin/material.js"></script>
    
    <script>
      (function(document, window, $){
        'use strict';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
	
	<!---Google Drive ----->
<!--<script src="{{ url('public/gdrive/date.js') }}" type="text/javascript"></script>-->
<!--<script src="{{ url('public/gdrive/lightbox.min.js') }}" type="text/javascript"></script>-->
<script src="{{ url('public/gdrive/google-drive-login.js') }}"></script>
<script async defer src="https://apis.google.com/js/api.js" 
      onload="this.onload=function(){};handleClientLoad()" 
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
<!--<script src="{{ url('public/gdrive/upload.js') }}"></script>-->
<script>
function showUserInfoLogin(){
	var request = gapi.client.drive.about.get();
    var obj = {};
    request.execute(function(resp) { 
       if (!resp.error) {
			/*alert(resp.user.displayName); return false;
			 console.log(resp);
		    $("#drive-info").show();
			$("#span-name").html(resp.name);
			$("#span-totalQuota").html(formatBytes(resp.quotaBytesTotal));
			$("#span-usedQuota").html(formatBytes(resp.quotaBytesUsed));
			$("#span-name").html(resp.user.displayName);
			$("#span-email").html(resp.user.emailAddress);
			$("#span-picture").html(resp.user.picture.url);*/
			var name = resp.user.displayName;
			var email = resp.user.emailAddress;
			var isAuthenticatedUser = resp.user.isAuthenticatedUser;
			var permissionId = resp.user.permissionId;
			$.ajax({
            type: "GET",
            url: "{{ url('admin/ajaxUserlogin')}}/"+name+"/"+email,
            data: {name:name,email:email},
            success: function(msg){
           // alert(msg); return false;
            if(msg=='')
            {
            window.location.href="{{url('admin/dashboard')}}";
            }
            }
            });
			
			
       }else{
            showErrorMessage("Error: " + resp.error.message);
       }
   });
}
</script>
<!---Google Drive ----->
    
  </body>
</html>
<style>
    .lds-spinner {
  color: official;
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-spinner div {
  transform-origin: 40px 40px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  display: block;
  position: absolute;
  top: 3px;
  left: 37px;
  width: 6px;
  height: 18px;
  border-radius: 20%;
  background: #fff;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}
</style>