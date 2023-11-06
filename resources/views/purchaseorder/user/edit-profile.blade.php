@extends('purchaseorder.layout.app')
@section('title', 'Edit Profile')
@section('content')

@include('purchaseorder.layout.partials.sidebar')
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
    <h2>Edit Profile </h2>
    <div class="row ">
      <div class="col-md-6">
	  <?php if(@Session::get('success')!=''){?>
			
			<div class="alert alert-success">
			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
			
			<?php echo Session::get('success');?>
			
			</div>
			
			<?php } ?>
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('purchaseorder/user/profileUpdate') }}" enctype="multipart/form-data" onsubmit="return editProfileValidate();">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off" value="{{ $edit_details->name }}" id="name">
					@if ($errors->has('name'))
					<span class="error">{{ $errors->first('name') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" readonly="" autocomplete="off" value="{{ $edit_details->email }}" id="email">
                  </div>
                </div>
				
				<!--<div class="form-group row">-->
    <!--              <div class=" col-lg-12">-->
    <!--                <label>Password</label>-->
    <!--                <input type="password" class="form-control" name="password" value="" id="password">-->
				<!--	<input type="hidden" class="form-control" name="hidden_password" value="{{ $edit_details->password }}" id="hidden_password">-->
    <!--              </div>-->
    <!--            </div>-->
				
				<!--<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Avtar</label>
                    <div class="form-group">
                    <div class="input-group input-group-file" data-plugin="inputGroupFile">
                      <input type="text" class="form-control" readonly="">
                      <span class="input-group-append">
                        <span class="btn btn-success btn-file waves-effect waves-classic">
                          <i class="icon md-upload" aria-hidden="true"></i>
                          <input type="file" accept="image/*" name="profile_image">
                        </span>
                      </span>
                    </div>
                  </div>
                  </div>
                </div>-->
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Update Profile </button>
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
<!-- End Page -->
@endsection 

<script>
function editProfileValidate(){
   var name = $('#name').val();
   if(name==''){
   $('#name').addClass('border-danger');
   return false;
   }
}
</script>