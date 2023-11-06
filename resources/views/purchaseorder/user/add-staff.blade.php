@extends('purchaseorder.layout.app')
@section('title', 'Add User')
@section('content')
@include('purchaseorder.layout.partials.sidebar')
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
  <div class="new-form">
    <h2>Add User </h2>
    <div class="row">
      <div class="col-md-6 col-lg-6">
	<?php if(@Session::get('success')!=''){?>			
			<div class="alert alert-success">			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>			
			<?php echo Session::get('success');?>			
			</div>			
	<?php } ?>
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('purchaseorder/staffDataPost') }}" enctype="multipart/form-data" onsubmit="return vendorDataPostValidate();">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name') }}" id="name">
					@if ($errors->has('name'))
					<span class="error">{{ $errors->first('name') }}</span>
					@endif
                  </div>
                </div>
                
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="off" id="email">
					@if ($errors->has('email'))
					<span class="error">{{ $errors->first('email') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" maxlength="10" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ old('phone') }}" id="phone">
					@if ($errors->has('phone'))
					<span class="error">{{ $errors->first('phone') }}</span>
					@endif
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Role</label>
                    <select class="form-control" name="role" id="role">
                    <option value="">-- Select Role --</option>
                    <option value="2">Admin</option>
                    <option value="3">Staff</option>
                    <option value="4">Approver</option>
                    </select>
					@if ($errors->has('role'))
					<span class="error">{{ $errors->first('role') }}</span>
					@endif
                  </div>
                </div>
				
				
              <div class="form-group row creat-fms-btn">
                <div class=" col-lg-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Add User</button>
				  <!--<a href="{{ url('purchaseorder/staff-listing') }}" title="Back"><button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic"> Back</button></a>-->
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
<!-- End Page -->
@endsection 
<script>
function vendorDataPostValidate1(){
   var name = $('#name').val();
   if(name==''){
   $('#name').addClass('border-danger');
   return false;
   }
}
</script>