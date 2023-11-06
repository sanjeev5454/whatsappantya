@extends('layout.app')
@section('title', 'Vendor Listing')
@section('content')

@include('layout.partials.sidebar')
<!-- Page -->
<div class="page">
      <div class="page-content">
      
        <!-- Panel Table Add Row -->
        <div class="panel">
          <header class="panel-heading">
            <h3 class="panel-title">Vendor Management</h3>
          </header>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-15">
                  <a title="Add Vendor" href="{{ url('add-vendor') }}"><button id="addToTable" class="btn btn-primary" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i> Add Vendor
                  </button></a>
                </div>
              </div>
            </div>
			<?php if(@Session::get('success')!=''){?>
			
			<div class="alert alert-success">
			
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
			
			<?php echo Session::get('success');?>
			
			</div>
			
			<?php } ?>
            <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Address</th>
				  <th>Contact Person</th>
				  <th>Email</th>
				  <th>Whatsapp Number</th>
				  <th>Mobile Number</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(!empty($vendor_data) && $vendor_data->count())
			  @foreach($vendor_data as $key=>$data)
                <tr class="gradeA">
                  <td>{{ $key+1 }}</td>
                  <td>{{ $data->vendor_name }}</td>
                  <td>{{ $data->address }}</td>
				  <td>{{ $data->contact_person }}</td>
				  <td>{{ $data->email }}</td>
				  <td>{{ $data->whatsapp_number }}</td>
				  <td>{{ $data->mobile_number }}</td>
                  <td class="actions">
                    <a href="{{ url('edit-vendor/'.$data->id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                    <a href="{{ url('vendorDelete/'.$data->id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  
                  </td>
                </tr>
               @endforeach
				@else
				<tr>
				<td colspan="10">There are no data.</td>
				</tr>
				@endif
              </tbody>
            </table>
			{!! $vendor_data->links() !!}
          </div>
        </div>
        <!-- End Panel Table Add Row -->

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