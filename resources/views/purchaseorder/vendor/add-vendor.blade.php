@extends('purchaseorder.layout.app')
@section('title', 'Add Vendor')
@section('content')

@include('purchaseorder.layout.partials.sidebar')
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
      <div class="new-form">
    <h2>Add Vendor </h2>
    <div class="row ">
      <div class="col-md-6 col-lg-6">
	  <?php if(@Session::get('success')!=''){?>
			
			<div class="alert alert-success">
			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
			
			<?php echo Session::get('success');?>
			
			</div>
			
			<?php } ?>
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('purchaseorder/vendorDataPost') }}" enctype="multipart/form-data" onsubmit="return vendorDataPostValidate();">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Vendor Name</label>
                    <input type="text" class="form-control" name="vendor_name" autocomplete="off" value="{{ old('vendor_name') }}" id="vendor_name">
					@if ($errors->has('vendor_name'))
					<span class="error">{{ $errors->first('vendor_name') }}</span>
					@endif
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Vendor Code</label>
                    <input type="text" class="form-control" name="vendor_code" autocomplete="off" value="{{ old('vendor_code') }}" id="vendor_code">
					@if ($errors->has('vendor_code'))
					<span class="error">{{ $errors->first('vendor_code') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Address</label>
                    <textarea class="form-control" name="address" autocomplete="off" value="" id="address">{{ old('address') }}</textarea>
					@if ($errors->has('address'))
					<span class="error">{{ $errors->first('address') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Contact Person</label>
                    <input type="contact_person" class="form-control" name="contact_person" autocomplete="off" value="{{ old('contact_person') }}" id="contact_person">
					@if ($errors->has('contact_person'))
					<span class="error">{{ $errors->first('contact_person') }}</span>
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
                    <label>Whatsapp Number</label>
                    <input type="text" class="form-control" maxlength="10" name="whatsapp_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ old('whatsapp_number') }}" id="whatsapp_number">
					@if ($errors->has('whatsapp_number'))
					<span class="error">{{ $errors->first('whatsapp_number') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Mobile Number</label>
                    <input type="text" class="form-control" maxlength="10" name="mobile_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ old('mobile_number') }}" id="mobile_number">
					@if ($errors->has('mobile_number'))
					<span class="error">{{ $errors->first('mobile_number') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Notification</label>
					<div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
					<input type="checkbox" class="checkBoxClass" id="inputCheckboxsms" value="sms" name="notification[sms]">
					<label for="inputCheckboxsms">SMS (Text Message)</label>
					</div>
					
					<div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
					<input type="checkbox" class="checkBoxClass" id="inputCheckboxwhatsup" value="whatsup" name="notification[whatsup]">
					<label for="inputCheckboxwhatsup">Whatsapp</label>
					</div>
					
					<div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
					<input type="checkbox" class="checkBoxClass" id="inputCheckboxmail" value="mail" name="notification[mail]">
					<label for="inputCheckboxmail">Mail</label>
					</div>
					
					
					<!--<div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
					<input type="checkbox" class="ckbCheckAll" id="inputCheckboxall" value="all" name="notification[all]">
					<label for="inputCheckboxall">All</label>
					</div>-->
					
                  </div>
                </div>
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Add Vendor</button>
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
function vendorDataPostValidate(){
   var name = $('#name').val();
   if(name==''){
   $('#name').addClass('border-danger');
   return false;
   }
}
</script>