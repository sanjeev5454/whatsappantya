<div class="top-bar">
  <div class="container">
    <div class="logo-box"><a href="#"><img src="https://themesofwp.com/wpxproduct/assets/images/logo.png" alt=""></a></div>
    <div class="burger-icon"><a href="javascript:void(0);"><img src="https://themesofwp.com/wpxproduct/assets/images/burger-icon.png" alt=""></a></div>
    <div class="top-nav">
      <ul>        
        <li class="menu-dropdown"><a href="javascript:void(0);"><i class="icon md-settings" aria-hidden="true"></i></a>
          <ul>
          <li class="{{ (request()->is('whatsapp')) ? 'active' : (request()->is('whatsapp/templates')) ? 'active' : (request()->is('whatsapp/edit-a-template*')) ? 'active' : (request()->is('whatsapp/view-a-template*')) ? 'active' : '' }}"> <a href="{{ url('whatsapp/templates') }}">Templates</a> </li>
            <!--<li class="{{ (request()->is('whatsapp/add-message')) ? 'active' : '' }}"> <a href="{{ url('whatsapp/add-message') }}">Add a Template</a> </li>-->
            <li class="{{ (request()->is('whatsapp/message-planner')) ? 'active' : (request()->is('whatsapp/edit-message-planner*')) ? 'active' : (request()->is('whatsapp/add-message-planner*')) ? 'active' : '' }}"> <a href="{{ url('whatsapp/message-planner') }}">Message Planner</a> </li>
            <!--<li class="{{ (request()->is('whatsapp/add-recurring-message')) ? 'active' : '' }}"> <a href="{{ url('whatsapp/add-recurring-message') }}">Add a Schedule</a> </li>-->
            <li class="{{ (request()->is('whatsapp/contacts')) ? 'active' : (request()->is('whatsapp/edit-a-contact*')) ? 'active' : (request()->is('whatsapp/add-a-contact')) ? 'active' :'' }}"> <a class="" href="{{ url('whatsapp/contacts') }}">Contacts</a></li>
            <!--<li class="{{ (request()->is('whatsapp/add-contact-details')) ? 'active' : '' }}"> <a class="" href="{{ url('whatsapp/add-contact-details') }}">Add a Contact</a></li>-->
            <li class="{{ (request()->is('whatsapp/groups')) ? 'active' : (request()->is('whatsapp/edit-a-group*')) ? 'active' : (request()->is('whatsapp/create-a-group')) ? 'active' :'' }}"> <a class="" href="{{ url('whatsapp/groups') }}">Groups</a></li>
            <!--<li class="{{ (request()->is('whatsapp/add-contact')) ? 'active' : '' }}"> <a class="" href="{{ url('whatsapp/add-contact') }}">Create a Group</a></li>-->
            
            <!--<li class="{{ (request()->is('whatsapp/send-message-listing')) ? 'active' : (request()->is('whatsapp/edit-send-message*')) ? 'active' : '' }}">--> 
            <!--        <a href="{{ url('whatsapp/send-message-listing') }}">--> 
            <!--                <i class="site-menu-icon md-collection-item" aria-hidden="true"></i>--> 
            <!--                <span class="site-menu-title">Send Message List</span>--> 
            <!--            </a>--> 
            
            <!--      </li>--> 
            
            <!--<li class="{{ (request()->is('whatsapp/add-send-message')) ? 'active' : '' }}">--> 
            <!--        <a href="{{ url('whatsapp/add-send-message') }}">--> 
            <!--                <i class="site-menu-icon md-collection-plus" aria-hidden="true"></i>--> 
            <!--                <span class="site-menu-title">Add Send Message</span>--> 
            <!--            </a>--> 
            
            <!--      </li>-->
            
            <li class="{{ (request()->is('whatsapp/reports')) ? 'active' : (request()->is('whatsapp/report*')) ? 'active' : '' }}"> <a href="{{ url('whatsapp/reports') }}">Reports</a></li>
            @if(Auth::user()->user_role==1)
            <li class="{{ (request()->is('whatsapp/settings')) ? 'active' :  (request()->is('whatsapp/edit-a-setting*')) ? 'active' : (request()->is('whatsapp/add-a-setting')) ? 'active' : '' }}"> <a class="" href="{{ url('whatsapp/settings') }}">Settings</a></li>
            <!--<li class="{{ (request()->is('whatsapp/add-account-management')) ? 'active' : '' }}">--> 
            <!--  <a href="{{ url('whatsapp/add-account-management') }}">--> 
            <!--          <i class="site-menu-icon md-border-inner" aria-hidden="true"></i>--> 
            <!--          <span class="site-menu-title">Add Setting</span>--> 
            <!--      </a>--> 
            
            <!--</li>--> 
            @endif
            <li> <a onClick="handleSignoutClick()" href="{{ url('logout') }}">Logout</a></li>
            <!--<li> <a href="{{ url('document/dashboard') }}">Dashboard</a></li>-->
            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
