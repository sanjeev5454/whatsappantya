@extends('purchaseorder.layout.app')
@section('title', 'Vendor Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
<!-- Page -->
<div class="page fix-table">
  <div class="page-content container-fluid">    
    <!-- Panel Table Add Row -->    
    <div class="panel">
      <header class="panel-heading">
        <h3 class="panel-title">Vendor Management</h3>
      </header>
      <div class="panel">
      <!--  <div class="row">
          <div class="col-md-6">
            <div class="mb-15"> <a title="Add Vendor" href="{{ url('purchaseorder/add-vendor') }}">
              <button id="addToTable" class="btn btn-primary" type="button"> <i class="icon md-plus" aria-hidden="true"></i> Add Vendor </button>
              </a> </div>
          </div>
        </div> -->
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
        <table class="table responsive-table dataTable" cellspacing="0" id="exampleAddRow">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Code</th>
              <th>Address</th>
              <th class="white-space">Contact Person</th>
              <th>Email</th>
              <th class="white-space">Whatsapp Number</th>
              <th class="white-space">Mobile Number</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          
          @if(!empty($vendor_data) && $vendor_data->count())
          
          @foreach($vendor_data as $key=>$data)
          <tr class="gradeA">
            <td data-table="#">{{ $key+1 }}</td>
            <td data-table="Name">{{ $data->vendor_name }}</td>
            <td data-table="Code">{{ $data->vendor_code }}</td>
            <td data-table="Address">{{ $data->address }}</td>
            <td data-table="Contact Person">{{ $data->contact_person }}</td>
            <td data-table="Email">{{ $data->email }}</td>
            <td data-table="Whatsapp No.">{{ $data->whatsapp_number }}</td>
            <td data-table="Mobile No.">{{ $data->mobile_number }}</td>
            <td data-table="Actions" class="actions white-space"><a href="{{ url('purchaseorder/edit-vendor/'.$data->id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"  data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a><a href="{{ url('purchaseorder/vendorDelete/'.$data->id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a></td>
          </tr>
          @endforeach
          
          @else
          <tr>
            <td class="no-data-table" colspan="10">There are no data.</td>
          </tr>
          @endif
            </tbody>
          
        </table>
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