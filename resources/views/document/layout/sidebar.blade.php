<div class="site-menubar">
      <ul class="site-menu">
        <li class="site-menu-item has-sub {{ (request()->is('purchase-order-listing')) ? 'active' : (request()->is('edit-purchase-order*')) ? 'active' : '' }}">
          <a href="{{ url('purchase-order-listing') }}">
                  <i class="site-menu-icon md-apps" aria-hidden="true"></i>
                  <span class="site-menu-title">Purchase Orders</span>
                          
              </a>
          
        </li>
		<li class="site-menu-item has-sub {{ (request()->is('add-purchase-order')) ? 'active' : '' }}">
          <a href="{{ url('add-purchase-order') }}">
                  <i class="site-menu-icon md-playlist-plus" aria-hidden="true"></i>
                  <span class="site-menu-title">Add Purchase Order</span>
                          
              </a>
          
        </li>
       
		
		<li class="site-menu-item has-sub {{ (request()->is('vendor-listing')) ? 'active' : (request()->is('edit-vendor*')) ? 'active' : '' }}">
          <a class="" href="{{ url('vendor-listing') }}">
                  <i class="site-menu-icon md-accounts-alt" aria-hidden="true"></i>
                  <span class="site-menu-title">Vendor Management</span>
                          
              </a>
          
        </li>
		
		<li class="site-menu-item has-sub {{ (request()->is('add-vendor')) ? 'active' : '' }}">
          <a class="" href="{{ url('add-vendor') }}">
                  <i class="site-menu-icon md-account-add" aria-hidden="true"></i>
                  <span class="site-menu-title">Add Vendor</span>
                          
              </a>
          
        </li>
		
		<li class="site-menu-item has-sub {{ (request()->is('item-listing')) ? 'active' : (request()->is('edit-item*')) ? 'active' : '' }}">
          <a href="{{ url('item-listing') }}">
                  <i class="site-menu-icon md-collection-item" aria-hidden="true"></i>
                  <span class="site-menu-title">Item Management</span>
              </a>
          
        </li>
		
		<li class="site-menu-item has-sub {{ (request()->is('add-item')) ? 'active' : '' }}">
          <a href="{{ url('add-item') }}">
                  <i class="site-menu-icon md-collection-plus" aria-hidden="true"></i>
                  <span class="site-menu-title">Add Item</span>
              </a>
          
        </li>
		
		<li class="site-menu-item has-sub {{ (request()->is('delivery-address')) ? 'active' : (request()->is('add-address')) ? 'active' : (request()->is('edit-address*')) ? 'active' : '' }}">
          <a class="" href="{{ url('delivery-address') }}">
                  <i class="site-menu-icon md-pin-drop" aria-hidden="true"></i>
                  <span class="site-menu-title">Address Management (New name for Delivery Address)</span>
                          
              </a>
          
        </li>
		
		
		<div class="dropdown-divider"></div>
		<li class="site-menu-item has-sub">
          <a href="{{ url('logout') }}">
                  <i class="site-menu-icon md-power" aria-hidden="true"></i>
                  <span class="site-menu-title">Logout</span>
                  
              </a>
          
        </li>
		
       
      </ul></div>   
	   <div class="site-gridmenu">
      <div>
        <div>
          <ul>
            
            <li>
              <a href="{{ url('dashboard') }}">
                <i class="icon md-view-dashboard"></i>
                <span>Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>