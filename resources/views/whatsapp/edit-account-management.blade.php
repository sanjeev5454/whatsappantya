@extends('whatsapp.layout.app')
@section('title', 'Edit a Setting')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid">
    <div class="panel">
      <div class="panel-body">
	  <header class="panel-heading">
        <h3 class="panel-title">Edit a Setting</h3>
      </header>
      <div class="new-form">
          <h2>Edit a Setting</h2>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('whatsapp/updateaccountmanagement') }}" enctype="multipart/form-data">
			<input type="hidden" name="id" value="{{ $data['_id'] }}" />
               @csrf        
			   <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" autocomplete="off" value="{{ $data['username'] }}" id="username">
					@if ($errors->has('username'))
					<span class="error">{{ $errors->first('username') }}</span>
					@endif
				</div>
                </div>
                
                
				
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Password</label>
                    <input type="text" class="form-control" name="password" autocomplete="off" value="{{ $data['password'] }}" id="password">
					@if ($errors->has('password'))
					<span class="error">{{ $errors->first('password') }}</span>
					@endif
				</div>
                </div>
                
                
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control mobile_number" name="mobile_number" maxlength="10" autocomplete="off" value="{{ $data['mobile_number'] }}" id="mobile_number">
					@if ($errors->has('mobile_number'))
					<span class="error">{{ $errors->first('mobile_number') }}</span>
					@endif
				</div>
                </div>
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Update Setting</button>
                  </div>
              </div>
			  </div>
            </form>
          </div>
        </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
    $(".mobile_number").keypress(function(event) {
  return /\d/.test(String.fromCharCode(event.keyCode));
});
</script>
@stop 