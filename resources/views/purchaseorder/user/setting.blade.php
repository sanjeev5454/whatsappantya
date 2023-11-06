@extends('purchaseorder.layout.app')
@section('title', 'Setting')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
  <div class="new-form">
    <h2>Setting </h2>
    <div class="row ">
      <div class="col-md-6 col-lg-6">
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
        <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('purchaseorder/user/settingUpdate') }}" enctype="multipart/form-data" onsubmit="">
              @csrf
              <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <label>Please uncheck with staff should be hide the side menus bar.</label>
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <!--<label>Menus</label>-->
                    <div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
                      <input type="checkbox" @if(@in_array('purchaseorders',$data['menus'])) checked @endif  class="checkBoxClass" id="inputCheckboxpurchase" value="purchaseorders" name="menus[purchaseorders]">
                      <label for="inputCheckboxpurchase">Purchase Orders</label>
                    </div>
                    <div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
                      <input type="checkbox" @if(@in_array('staff',$data['menus'])) checked @endif class="checkBoxClass" id="inputCheckboxstaff" value="staff" name="menus[staff]">
                      <label for="inputCheckboxstaff">Staff Management</label>
                    </div>
                    <div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
                      <input type="checkbox" @if(@in_array('vendor',$data['menus'])) checked @endif class="checkBoxClass" id="inputCheckboxvendor" value="vendor" name="menus[vendor]">
                      <label for="inputCheckboxvendor">Vendor Management</label>
                    </div>
                    <div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
                      <input type="checkbox" @if(@in_array('item',$data['menus'])) checked @endif class="checkBoxClass" id="inputCheckboxitem" value="item" name="menus[item]">
                      <label for="inputCheckboxitem">Item Management</label>
                    </div>
                    <div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
                      <input type="checkbox" @if(@in_array('address',$data['menus'])) checked @endif class="checkBoxClass" id="inputCheckboxaddress" value="address" name="menus[address]">
                      <label for="inputCheckboxaddress">Address Managementt</label>
                    </div>
                  </div>
                </div>
                <label>A copy of the PO will be sent to your chosen Staff.</label>
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <div class="radio">
                      <label>
                        <input required type="radio" @if(@$data['code_vendor']==1) checked @endif name="code_vendor" value="1">
                        SHOW VENDOR DETAILS to Staff (Full name, Address and Contact Details).</label>
                    </div>
                    <div class="radio">
                      <label>
                        <input required type="radio" @if(@$data['code_vendor']==0) checked @endif name="code_vendor" value="0">
                        HIDE VENDOR DETAILS from Staff (Only Vendor Code will be displayed).</label>
                    </div>
                  </div>
                </div>
                @php
                
                $approval_rights = explode(',',$data['approval_rights']);
                
                @endphp
                <label>Purchase Order approval rights to :</label>
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <select name="approval_rights[]" class="form-control" multiple="multiple">
                      <option value="">-- Select Vendor --</option>
                      

					@foreach($vendors as $all_vendor)

					
                      <option @if(in_array($all_vendor->id,$approval_rights)) selected @endif value="{{ $all_vendor->id }}">{{ $all_vendor->name }}</option>
                      

					@endforeach   

                   
                    </select>
                  </div>
                </div>
                <div class="form-group row creat-fms-btn">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic"> Update Setting</button>
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
function editProfileValidate(){
   var name = $('#name').val();
   if(name==''){
   $('#name').addClass('border-danger');
   return false;
   }
}
</script>