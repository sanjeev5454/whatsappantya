@extends('layout.app')
@section('title', 'Edit Address')
@section('content')

@include('layout.partials.sidebar')
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
    <h2>Edit Address </h2>
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
            <form method="POST" action="{{ url('addressDataUpdate/'.$address_data->id) }}" enctype="multipart/form-data" onsubmit="return addressDataUpdateValidate();">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label><strong>Address label</strong></label>
                    <input type="text" class="form-control" name="label" placeholder="e.g. Depot, Office..." autocomplete="off" value="{{ $address_data->label }}" id="label">
					@if ($errors->has('label'))
					<span class="error">{{ $errors->first('label') }}</span>
					@endif
                  </div>
                </div>
				<hr />
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label><strong>Address</strong></label>
					<input type="text" class="form-control" placeholder="Attention" name="attention"  autocomplete="off" value="{{ $address_data->attention }}" id="attention">
					<br />
                    <textarea class="form-control" name="street_address" placeholder="Street address or PO box" autocomplete="off" value="" id="street_address">{{ $address_data->street_address }}</textarea>
					@if ($errors->has('street_address'))
					<span class="error">{{ $errors->first('street_address') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <input type="text" placeholder="Town / City" class="form-control" name="town_city" autocomplete="off" value="{{ $address_data->town_city }}" id="town_city">
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-8">
                    <input type="text" placeholder="State / Region" class="form-control" name="state_region" value="{{ $address_data->state_region }}" autocomplete="off" id="state_region">
                  </div>
				  <div class=" col-lg-4">
                    <input type="number" placeholder="Postal / Zip Code" maxlength="6" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="zip_code" value="{{ $address_data->zip_code }}" autocomplete="off" id="zip_code">
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <input type="text" class="form-control"  name="country" placeholder="Country" autocomplete="off" value="{{ $address_data->country }}" id="country">
                  </div>
                </div>
				<hr />
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label><strong>Telephone</strong></label>
				<div class="row">
				  <div class=" col-lg-3">
                    <input type="text" class="form-control" placeholder="Country" name="tel_country" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ $address_data->tel_country }}" id="tel_country">
                  </div>
				  <div class=" col-lg-3">
                    <input type="text" class="form-control"  name="tel_area" placeholder="Area" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" value="{{ $address_data->tel_area }}" id="tel_area">
                  </div>
				  <div class=" col-lg-6">
                    <input type="text" class="form-control"  name="tel_number" placeholder="Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" value="{{ $address_data->tel_number }}" id="tel_number">
                  </div>
				  </div>
				  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Instructions</label>
                    <textarea class="form-control" maxlength="500" name="instruction" autocomplete="off" value="" id="instruction">{{ $address_data->instruction }}</textarea>
					
                  </div>
                </div>
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Update Address</button>
				  <a href="{{ url('delivery-address') }}" title="Back"><button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic"> Back</button></a>
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
function vendorDataPostValidate(){
   var name = $('#name').val();
   if(name==''){
   $('#name').addClass('border-danger');
   return false;
   }
}
</script>