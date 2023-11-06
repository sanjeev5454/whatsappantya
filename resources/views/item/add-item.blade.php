@extends('layout.app')
@section('title', 'Add Item')
@section('content')

@include('layout.partials.sidebar')
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
    <h2>Add Item </h2>
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
            <form method="POST" action="{{ url('itemDataPost') }}" enctype="multipart/form-data" onsubmit="return itemDataPostValidate();">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="item_name" autocomplete="off" value="{{ old('item_name') }}" id="item_name">
					@if ($errors->has('item_name'))
					<span class="error">{{ $errors->first('item_name') }}</span>
					@endif
                  </div>
                </div>
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Item SKU</label>
                    <input type="text" class="form-control" name="item_sku" autocomplete="off" value="{{ old('item_sku') }}" id="item_sku">
					@if ($errors->has('item_sku'))
					<span class="error">{{ $errors->first('item_sku') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Description</label>
                    <textarea class="form-control" name="description" autocomplete="off" value="" id="address">{{ old('description') }}</textarea>
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Unit</label>
					<select class="form-control" name="unit" id="unit" autocomplete="off">
					<option value="">-- Select Unit --</option>
					@if(!empty(getAllUnits()))
					@foreach(getAllUnits() as $allUnits)
					<option @if (old('unit') == $allUnits) {{ 'selected' }} @endif value="{{ $allUnits }}">{{ $allUnits }}</option>
					@endforeach
					@endif
					@if(!empty(getAllOtherUnits()))
					@foreach(getAllOtherUnits() as $units)
					<option @if (old('unit') == $units) {{ 'selected' }} @endif value="{{ $units }}">{{ $units }}</option>
					@endforeach
					@endif
					<option @if (old('unit') == "Other") {{ 'selected' }} @endif value="Other">Other</option>
					</select>
					@if ($errors->has('unit'))
					<span class="error">{{ $errors->first('unit') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row other-unit" @if (old('unit') == "Other") {{ '' }} @else style="display:none;" @endif >
                  <div class=" col-lg-12">
                    <label>Other Unit</label>
                    <input type="text" class="form-control" name="other_unit" data-role="tagsinput" value="{{ old('other_unit') }}" autocomplete="off" id="other_unit">
					
					<small class="text-muted">Add other unit separated by comma (,).</small>
					@if ($errors->has('other_unit'))
					<br/>
					<span class="error">{{ $errors->first('other_unit') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Price/Unit</label>
                    <input type="text" class="form-control" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ old('price') }}" id="price">
					@if ($errors->has('price'))
					<span class="error">{{ $errors->first('price') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Vendor Name</label>
                    <select class="form-control" name="vendor_id" autocomplete="off">
					<option value="">-- Select Vendor --</option>
					@foreach($vendors as $all_vendor)
					<option @if (old('vendor_id') == $all_vendor->id) {{ 'selected' }} @endif value="{{ $all_vendor->id }}">{{ $all_vendor->vendor_name }}</option>
					@endforeach
					</select>
					@if ($errors->has('vendor_id'))
					<span class="error">{{ $errors->first('vendor_id') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row">
                  <div class=" col-lg-12">
                    <label>GST (in %)</label>
                    <input type="text" class="form-control" name="gst" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  autocomplete="off" value="{{ old('gst') }}" id="gst">
					@if ($errors->has('gst'))
					<span class="error">{{ $errors->first('gst') }}</span>
					@endif
                  </div>
                </div>
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Add Item</button>
				  <a href="{{ url('item-listing') }}" title="Back"><button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic"> Back</button></a>
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
