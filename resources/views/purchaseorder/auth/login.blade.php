@extends('layout.app')
@section('title', 'Login')
@section('content')
@if(@$_COOKIE['session_google_id']=='')
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
	  	<div class="lds-spinner" style="display:none;"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
      <div class="page-content login vertical-align-middle">
	  
        <div class="brand">
          <img class="brand-img" src="{{ url('assets/images/login-logo.png') }}" alt="...">
          <h2 class="brand-text" style="color:#FFFFFF;">Purchase Order</h2>
        </div>
        <p style="color:#FFFFFF">Sign into your account</p>
        
		
		<a href="javascript:void(0);" id="btnLogin" onClick="handleAuthClick()" class="btn btn-lg btn-success btn-block">
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
@endsection

<script src="{{ url('public/gdrive/google-drive-login.js') }}"></script>
<script async defer src="https://apis.google.com/js/api.js" 
      onload="this.onload=function(){};handleClientLoad()" 
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>
<script>
function showUserInfoLogin(){
	var request = gapi.client.drive.about.get();
    var obj = {};
    request.execute(function(resp) { 
       if (!resp.error) {
			/*alert(resp.user.id); return false;
			 console.log(resp);*/
		    /*$("#drive-info").show();
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
            url: "{{ url('ajaxUserlogin')}}/"+name+"/"+email+"/"+permissionId,
            data: {name:name,email:email},
            success: function(msg){
           //alert(msg); return false;
            if(msg=='')
            {
            window.location.href="{{url('dashboard')}}";
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