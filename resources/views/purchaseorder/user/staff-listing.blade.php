@extends('purchaseorder.layout.app')
@section('title', 'Staff Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
<!-- Page -->
<div class="page fix-table">
  <div class="page-content container-fluid">     
    <!-- Panel Table Add Row -->    
    <div class="panel">
      <header class="panel-heading page-heading">
        <h3 class="panel-title">Staff Management</h3>
        <div class="page-header-actions"> <a title="Add Vendor" class="btn btn-primary" href="{{ url('purchaseorder/add-staff') }}"><i class="icon md-plus" aria-hidden="true"></i> Add Staff</a></div>
      </header>
      <div class="pane-body">
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
        <table class="table responsive-table dataTable" cellspacing="0" id="exampleAddRow">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Mobile Number</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>          
          @if(!empty($staff_data) && $staff_data->count())          
          @foreach($staff_data as $key=>$data)
          <tr class="gradeA">
            <td data-table="#">{{ $key+1 }}</td>
            <td data-table="Name">{{ $data->name }}</td>
            <td data-table="Email">{{ $data->email }}</td>
            <td data-table="Role">@if($data->role_id==1)Super Admin @elseif($data->role_id==2) Admin @elseif($data->role_id==3) Staff @else Approver @endif</td>
            <td data-table="Mobile No.">{{ $data->phone }}</td>
            <td data-table="Status">@if($data->joined==1) <span style="color:green;">Joined</span> @else <span style="color:red;">Not joined yet</span> @endif</td>
            <td data-table="Actions" class="actions"><a href="{{ url('purchaseorder/edit-staff/'.$data->id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a> <a href="{{ url('purchaseorder/staffDelete/'.$data->id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a></td>
          </tr>
          @endforeach          
          @else
          <tr>
            <td class="no-data-table" colspan="5">There are no data.</td>
          </tr>
          @endif
            </tbody>          
        </table>
        {!! $staff_data->links() !!} </div>
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