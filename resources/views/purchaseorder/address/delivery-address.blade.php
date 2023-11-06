@extends('purchaseorder.layout.app')
@section('title', 'Address Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar')
<!-- Page -->
<div class="page">
      <div class="page-content container-fluid">      
        <!-- Panel Table Add Row -->
        <div class="panel">
      <header class="panel-heading page-heading">
        <h3 class="panel-title">Delivery Address</h3>
        <div class="page-header-actions">
          <div class="btn-group btn-group-sm" id="withBtnGroup" aria-label="Page Header Actions" role="group">
            <div class="dropdown">
              <a title="Add Address" href="{{ url('purchaseorder/add-address') }}"><button type="button" class="btn btn-primary">
			  <span class="icon md-plus" aria-hidden="true"></span>
                Add Address
              </button></a>
            </div>
          </div>
        </div>
		<?php if(@Session::get('success')!=''){?>			
			<div class="alert alert-success col-md-6">			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>			
			<?php echo Session::get('success');?>			
			</div>			
			<?php } ?>
      </header>
	  
      <div id="exampleTransition" data-plugin="animateList" class="address-book">
        <ul class="blocks-sm-100 blocks-lg-2 blocks-xxl-3">
		  @if(!empty($address_data) && $address_data->count())
		  @foreach($address_data as $key=>$data)
          <li @if($data->default_address==1) class="default" @endif>
            <div class="panel panel-bordered">
              <div class="panel-heading">
                <h3 class="panel-title" style="padding-bottom:2px; padding:10px 30px;">&nbsp;</h3>
                <div class="panel-actions">
				   @if($data->default_address==0)
				   <a style="color:green;" class="panel-action icon md-check" title="Make Default" href="{{ url('purchaseorder/default-address/'.$data->id) }}" data-toggle="tooltip" data-original-title="Make Default"></a>
				   @else
				    <a class="panel-action icon" title="Default Address" href="javascript:void(0);" data-toggle="tooltip" data-original-title="Default">Default Address</a>
				   @endif
                  <a class="panel-action icon md-edit" href="{{ url('purchaseorder/edit-address/'.$data->id) }}" data-toggle="tooltip" data-original-title="Edit Address" aria-hidden="true"></a>
                  <a class="panel-action icon md-close" onclick="return confirm('Are you sure to delete the address?')" href="{{ url('purchaseorder/delete-address/'.$data->id) }}" data-toggle="tooltip" data-original-title="Delete Address"></a>
                </div>
              </div>
              <div class="panel-body" style="padding-top:10px;">
                <p>
				<strong style="font-weight:bold;">{{ $data->label }}</strong><br />
				@if($data->street_address!='')
				{{ $data->street_address }}<br />
				@endif
				@if($data->town_city!='')
				{{ $data->town_city }}<br />
				@endif
				@if($data->state_region!='')
				{{ $data->state_region }}<br />
				@endif
				@if($data->zip_code!='')
				{{ $data->zip_code }}<br />
				@endif
				@if($data->country!='')
				{{ $data->country }}<br/>
				@endif
				Telephone :{{ $data->tel_country }}&nbsp;{{ $data->tel_area }}&nbsp;{{ $data->tel_number }}<br/>
				Instructions : {{ stripslashes($data->instruction) }}
				  </p>
              </div>
            </div>
          </li>
          @endforeach
		  @else
		  <li>
            <div class="panel panel-bordered">
              <div class="panel-heading">
                <h3 class="panel-title">No address found.</h3>
                
              </div>
              
            </div>
          </li>
		  @endif
        </ul>
      </div>
    </div></div></div>
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