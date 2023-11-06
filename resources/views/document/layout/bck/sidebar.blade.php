<div class="burger"><a href="javascript:void(0);"></a></div>
<div class="menu-overlay"></div>
<div class="site-menubar">
  <ul class="site-menu">
    <li class="menu-logo"> <!--<span class="logo-box"> <span class="small-logo"><img src="{{asset(PUBLIC_FOLDER.'theme')}}/assets/images/BIzVoiLogo-small.png" alt="" /></span> <span class="big-logo"><img src="{{asset(PUBLIC_FOLDER.'theme')}}/assets/images/BIzVoiLogo.png" alt="" /></span></span> --> <span class="logobox"><img src="{{asset(PUBLIC_FOLDER.'theme')}}/assets/images/logo.png" alt="" /></span> <!--<span class="logobox-big"><img src="{{asset(PUBLIC_FOLDER.'theme')}}/assets/images/pashupati-logo-big.png" alt="" /></span>--> </li>
    <li class="site-menu-item"> <a class="animsition-link" href="{{route('dashboard')}}"> <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i> <span class="site-menu-title">Dashboard</span> </a> </li>
   

    <li class="site-menu-item"> <a href="{{ route('logout') }}"> <i class="site-menu-icon md-power" aria-hidden="true" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></i> <span class="site-menu-title">Logout</span> </a> </li> 
   
   
  </ul>
</div>

