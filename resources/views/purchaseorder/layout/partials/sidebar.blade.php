<div class="top-bar">
<div class="container">
<div class="logo-box"><a href="#"><img src="https://themesofwp.com/wpxproduct/assets/images/logo.png" alt="" /></a></div>
<div class="burger-icon"><a href="javascript:void(0);"><img src="https://themesofwp.com/wpxproduct/assets/images/burger-icon.png" alt="" /></a></div>

<div class="top-nav">
  <ul>
    @if(Auth::user()->user_role!=1)
    @if(@in_array('purchaseorders',menuHide()['menus']) && Auth::user()->user_role!=1)
    @if(Auth::user()->role_id!="4")
    <li class="{{ (request()->is('purchaseorder/purchase-order-listing*')) ? 'active' : (request()->is('purchaseorder/edit-purchase-order*')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/purchase-order-listing') }}">Purchase orders</a></li>
    <li class="{{ (request()->is('purchaseorder/add-purchase-order')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/add-purchase-order') }}">Add Purchase order</a></li>
    @endif
    @endif
    <li class="menu-dropdown"><a href="javascript:void(0);"><i class="icon md-settings" aria-hidden="true"></i></a>
   <ul>
    @if(Auth::user()->role_id!="4")
    @if(@in_array('vendor',menuHide()['menus']) && Auth::user()->user_role!=1)
    <li class="{{ (request()->is('purchaseorder/vendor-listing')) ? 'active' : (request()->is('purchaseorder/edit-vendor*')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/vendor-listing') }}">Vendor </a></li>
    <li class="{{ (request()->is('purchaseorder/add-vendor')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/add-vendor') }}">Add Vendor</a></li> 
    @endif
    @if(@in_array('item',menuHide()['menus']) && Auth::user()->user_role!=1)
    <li class="{{ (request()->is('purchaseorder/item-listing')) ? 'active' : (request()->is('purchaseorder/edit-item*')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/item-listing') }}">Items</a></li>
    <li class="{{ (request()->is('purchaseorder/add-item')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/add-item') }}">Add Items</a></li>
    @endif
    @if(@in_array('staff',menuHide()['menus']) && Auth::user()->user_role!=1)
    <li class="{{ (request()->is('purchaseorder/staff-listing')) ? 'active' : (request()->is('purchaseorder/edit-staff*')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/staff-listing') }}">Users</a></li>
    <li class="{{ (request()->is('purchaseorder/add-staff')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/add-staff') }}">Add Users</a></li>
    @endif
    @if(@in_array('address',menuHide()['menus']) && Auth::user()->user_role!=1)
    <li class="{{ (request()->is('purchaseorder/delivery-address')) ? 'active' : (request()->is('purchaseorder/add-address')) ? 'active' : (request()->is('edit-address*')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/delivery-address') }}">Delivery Address</a></li>
    @endif
    @endif
    <li><a href="{{ url('logout') }}" onClick="handleSignoutClick()">Logout</a></li>
   </ul>
   </li>
    @endif
    @if(Auth::user()->user_role==1)
    <li class="{{ (request()->is('purchaseorder/purchase-order-listing*')) ? 'active' : (request()->is('purchaseorder/edit-purchase-order*')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/purchase-order-listing') }}">Purchase Orders</a> </li>
    <li class="{{ (request()->is('purchaseorder/add-purchase-order')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/add-purchase-order') }}">Add Purchase Order</a> </li>
    <li class="menu-dropdown"><a href="javascript:void(0);"><i class="icon md-settings" aria-hidden="true"></i></a>
    <ul>
    <li class="{{ (request()->is('purchaseorder/vendor-listing')) ? 'active' : (request()->is('purchaseorder/edit-vendor*')) ? 'active' : '' }}"> <a class="" href="{{ url('purchaseorder/vendor-listing') }}">Vendor</a> </li>
    <li class="{{ (request()->is('purchaseorder/add-vendor')) ? 'active' : '' }}"> <a class="" href="{{ url('purchaseorder/add-vendor') }}">Add Vendor</a> </li>
    <li class="{{ (request()->is('purchaseorder/item-listing')) ? 'active' : (request()->is('purchaseorder/edit-item*')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/item-listing') }}">Items</a> </li>
    <li class="{{ (request()->is('purchaseorder/add-item')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/add-item') }}">Add Items</a> </li>
    <li class="{{ (request()->is('purchaseorder/staff-listing')) ? 'active' : (request()->is('purchaseorder/edit-staff*')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/staff-listing') }}">Users</a> </li>
    <li class="{{ (request()->is('purchaseorder/add-staff')) ? 'active' : '' }}"> <a href="{{ url('purchaseorder/add-staff') }}">Add Users</a> </li>
    <li class="{{ (request()->is('purchaseorder/delivery-address')) ? 'active' : (request()->is('purchaseorder/add-address')) ? 'active' : (request()->is('edit-address*')) ? 'active' : '' }}"> <a class="" href="{{ url('purchaseorder/delivery-address') }}">Delivery Address</a> </li>
    <li class="{{ (request()->is('purchaseorder/user/setting')) ? 'active' : '' }}"><a href="{{ url('purchaseorder/user/setting') }}">Setting</a></li>
    <li><a href="{{ url('logout') }}" onClick="handleSignoutClick()">Logout</a></li>
    </ul>
    </li>
    @endif
    
  </ul>
</div>
</div></div>