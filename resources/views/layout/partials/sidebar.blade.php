<!--<div class="site-menubar">
  <ul class="site-menu">
    <li class="site-menu-item has-sub {{ (request()->is('purchase-order-listing')) ? 'active' : (request()->is('edit-purchase-order*')) ? 'active' : '' }}"> <a href="{{ url('dashboard') }}"> <i class="site-menu-icon md-home" aria-hidden="true"></i> <span class="site-menu-title">Dashboard</span> </a> </li>
    <li class="site-menu-item has-sub"> <a href="{{ url('purchaseorder') }}" target="_blank"> <i class="site-menu-icon md-playlist-plus" aria-hidden="true"></i> <span class="site-menu-title">Purchase Order</span> </a> </li>
    <li class="site-menu-item has-sub"> <a class="" href="{{ url('financialsummary') }}" target="_blank"> <i class="site-menu-icon md-accounts-alt" aria-hidden="true"></i> <span class="site-menu-title">Financial Summary</span> </a> </li>
    <li class="site-menu-item has-sub"> <a class="" href="{{ url('document') }}" target="_blank"> <i class="site-menu-icon md-account-add" aria-hidden="true"></i> <span class="site-menu-title">DocX</span> </a> </li>
    <li class="site-menu-item has-sub"> <a class="" href="{{ url('whatsapp') }}" target="_blank"> <i class="site-menu-icon fa fa-whatsapp" aria-hidden="true"></i> <span class="site-menu-title">WhatsappX</span> </a> </li>
    <div class="dropdown-divider"></div>
    <li class="site-menu-item has-sub"> <a href="{{ url('logout') }}" onClick="handleSignoutClick()"> <i class="site-menu-icon md-power" aria-hidden="true"></i> <span class="site-menu-title">Logout</span> </a> </li>
  </ul>
</div>
<div class="site-gridmenu">
  <div>
    <div>
      <ul>
        <li> <a href="{{ url('dashboard') }}"> <i class="icon md-view-dashboard"></i> <span>Dashboard</span> </a> </li>
      </ul>
    </div>
  </div>
</div>-->

<div class="top-bar">
  <div class="container">
    <div class="logo-box"><a href="#"><img src="https://themesofwp.com/wpxproduct/assets/images/logo.png" alt="" /></a></div>
    <div class="burger-icon"><a href="javascript:void(0);"><img src="https://themesofwp.com/wpxproduct/assets/images/burger-icon.png" alt="" /></a></div>
    <div class="top-nav">
      <ul>
        <li class="{{ (request()->is('purchase-order-listing')) ? 'active' : (request()->is('edit-purchase-order*')) ? 'active' : '' }}"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <!--<li><a href="{{ url('purchaseorder') }}" target="_blank">Purchase Order</a></li>-->
        <!--<li><a href="{{ url('financialsummary') }}" target="_blank">Financial Summary</a></li>-->
        <!--<li><a href="{{ url('document') }}" target="_blank">DocX</a></li>-->
        <li><a href="{{ url('whatsapp') }}" target="_blank">WhatsappX</a></li>
        <li><a href="{{ url('logout') }}" onClick="handleSignoutClick()">Logout</a></li>
      </ul>
    </div>
  </div>
</div>