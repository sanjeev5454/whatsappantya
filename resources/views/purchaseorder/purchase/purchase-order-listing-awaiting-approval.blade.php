@extends('purchaseorder.layout.app')
@section('title', 'Purchase Order Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
<!-- Page -->
<div class="page no-padding-mobile">
  <div class="page-content container-fluid">    
    <!-- Panel Table Add Row -->    
    <div class="panel">
      <header class="panel-heading page-heading">
        <h3 class="panel-title">Purchase Orders</h3>
        <div class="page-header-actions">
        <a title="Add Item" class="btn btn-primary" href="{{ url('purchaseorder/add-purchase-order') }}"><i class="icon md-plus" aria-hidden="true"></i> New Purchase Order</a></div></header>
      <div class="pane-body">
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
        <div class="tab-box-res"><a href="javascript:void(0);">Slect Order List</a></div>
        <ul class="nav nav-tabs tab-res-tab" id="myTab" role="tablist" style="margin-bottom:10px;">
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing') }}">All ({{ count($purchase_data) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-draft') }}">Draft ({{ count($purchase_data_draft) }})</a> </li>
          <li class="nav-item"> <a class="nav-link active">Awaiting Approval ({{ count($purchase_data_awaiting) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-approval') }}">Approved ({{ count($purchase_data_approved) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-po-wise') }}">PO View</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-invoice-wise') }}">Invoice View</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-intake-form') }}">Intake</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-item-wise') }}">Item View</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-pending-list') }}">Pending List</a></li>
          <select class="form-control select-vendor">
          <option value="">Vendor</option>
          @foreach(getVendor() as $vendors)
          <option value="{{ $vendors->vendor_code }}">{{ $vendors->vendor_code }}</option>
          @endforeach
          </select>
        </ul>
        <div class="tab-content tab-table-fix" id="myTabContent">
          <div class="show table-layout-fixed message-planner-box purchase-order-listing-table" id="awaiting" role="tabpanel" aria-labelledby="awaiting-tab">
            <table class="table responsive-table dataTable t3" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th class="sort ta po-th" style="cursor:pointer;" id="heder_po_awaiting">#PO</th>
                  <th class="sort ta vendor-th" style="cursor:pointer;" id="heder_vendor_awaiting">Vendor</th>
                  <th class="sort ta date-raised-th" style="cursor:pointer;" id="heder_date_awaiting">Date raised</th>
                  <th class="delivery-date-th">Delivery date</th>
                  <th class="amount-th">Amount</th>
                  <th class="status-th">Status</th>
                  <th class="notification-th">Notification</th>
                  <th class="action-th">Action</th>
                  <th class="color-th">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
              
              @if(count($purchase_data_awaiting)>0)
              
              @foreach($purchase_data_awaiting as $data)
              @php
              $del = date('Y-m-d',strtotime($data->delivery_date));
              $late_pink = date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d'))));
              $late = date('Y-m-d');
              @endphp
              <tr class="gradeA s-{{$data->contact}}">
                <td data-table="#PO">PO-{{$data->order_number}}</td>
                <td data-table="Vendor">{{$data->contact}}</td>
                <td data-table="Date raised"><span style="display:none;">{{ strtotime($data->date)}}</span>{{$data->date}}</td>
                <td data-table="Delivery date"><span style="color: @if($qty==$rec_q) green @elseif($del<=$late) red @elseif($del<=$late_pink) pink @endif">{{$data->delivery_date}}</span></td>
                <td data-table="Amount">{{$data->total}}</td>
                <td data-table="Status"><div class="inline-box">
                @if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif </div></td>                  
                <td data-table="Notification">{{$data->notification}}</td>
                <td class="actions purchase-order-actions" data-table="Actions">
                   @if($data->status==1)
                  <span class="download-dropdown"><a href="javascript:void(0)" class="btn btn-sm btn-icon btn-pure btn-default on-default"><i class="icon md-download" aria-hidden="true"></i></a>
                    <ul>
                    @if(Auth::user()->user_role==1)
                    <li><a href="{{ url('purchaseorder/vendor-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Vendor Desktop Download</a></li>
                    <li><a href="{{ url('purchaseorder/vendor-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Vendor Mobile Download</a></li>
                    <li><a href="{{ url('purchaseorder/staff-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Mobile Download</a></li>
                    <li><a href="{{ url('purchaseorder/staff-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Desktop Download</a></li>
                    @else
                    <li><a href="{{ url('purchaseorder/staff-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Mobile Download</a></li>
                    <li><a href="{{ url('purchaseorder/staff-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Desktop Download</a></li>
                    @endif
                    </ul>
                   </span>
                   @endif
                    
                    <a @if($data->status==0 || $data->status==2) href="{{ url('purchaseorder/edit-purchase-order/'.$data->_id) }}" @else href="{{ url('purchaseorder/view-purchase-order/'.$data->_id) }}" @endif class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                  
                  data-toggle="tooltip" data-original-title="@if($data->status==0 || $data->status==2) Edit @elseif($data->status==1) View @endif">
                  
                  @if($data->status==0 || $data->status==2) <i class="icon md-edit" aria-hidden="true"></i> @elseif($data->status==1 || $data->status==3) <i class="icon md-eye" aria-hidden="true"></i> @endif </a> @if($data->status==0 || $data->status==2) 
                  @if(Auth::user()->user_role==1)
                  <a href="{{ url('purchaseorder/purchaseorderapproved/'.$data->_id) }}"  data-original-title="Approval"><i class="icon md-check" aria-hidden="true"></i></a> 
                  @endif
                  @if(in_array(Auth::user()->id,$approval_rights))
                  <a href="{{ url('purchaseorder/purchaseorderapproved/'.$data->_id) }}" data-original-title="Approval"><i class="icon md-check" aria-hidden="true"></i></a> 
                  @endif
                  <!-- Modal -->
                  
                  <form action="{{ url('purchaseorder/purchaseorderapproved/'.$data->_id) }}" method="post" style="display:inline;">
                    @csrf
                    <div class="modal fade" id="exampleModal-{{$data->_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">A copy of the PO will be sent to your chosen Staff.</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                          </div>
                          <div class="modal-body">
                            <div class="radio">
                              <label>
                                <input type="radio" name="code_vendor" value="1">
                                SHOW VENDOR DETAILS to Staff (Full name, Address and Contact Details).</label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="code_vendor" value="0">
                                HIDE VENDOR DETAILS from Staff (Only Vendor Code will be displayed).</label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" name="approve" value="approve" class="btn btn-success">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                  @endif 
                  @if(Auth::user()->user_role==1)
                  <a href="{{ url('purchaseorder/purchaseDelete/'.$data->_id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"

                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                      @endif
                      </td>
                      <td class="delivery-status" data-table="Delivery Status">@if($del<=$late)<div class="wrapper-red"></div>@elseif($del<=$late_pink)<div class="wrapper-pink"></div>@endif</td>
              </tr>
              @endforeach
              
              @else
              <tr>
                <td colspan="8" class="no-data-table" align="center">There are no purchase orders to display.</td>
              </tr>
              @endif
                </tbody>
              
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <!-- End Panel Table Add Row --> 
    
  </div>
</div>

<!-- End Page --> 

@endsection 

@section('pagescript') 
<script src="https://rawgit.com/padolsey/jQuery-Plugins/master/sortElements/jquery.sortElements.js"></script>
<script>
$(function(){
    var table = $('.t3');
    $('#heder_po_awaiting, #heder_vendor_awaiting, #heder_date_awaiting')
        .wrapInner('<span title=""/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                if(inverse==true){
				$('.ta').addClass('sort');
				$('.ta').removeClass('dsc');
				$('.ta').removeClass('asc');
				$(this).addClass('asc');
				$(this).removeClass('sort');
				$(this).removeClass('dsc');
				}else if(inverse==false){
				$('.ta').addClass('sort');
				$('.ta').removeClass('dsc');
				$('.ta').removeClass('asc');
				$(this).addClass('dsc');
				$(this).removeClass('sort');
				$(this).removeClass('asc');
				}
                    
            });
                
        });
		$(".tab-box-res a").click(function() {
		 $(this).parent().next().toggleClass("show");        
    });
});
</script>
<script>
		    $(function(){
		       $(document).on('change','.select-vendor',function(){
		          var vendor_code = $(this).val();
		          if(vendor_code!='')
		          {
		          $('.gradeA').hide();
		          $('.s-'+vendor_code).show();
		          }else{
		          $('.gradeA').show();  
		          }
		       }); 
		    });
		</script>

<style>
        div.wrapper-pink {    
        height:5px;
        width:5px;
        padding:5px;
        background:pink;
        }
        div.wrapper-red {    
        height:5px;
        width:5px;
        padding:5px;
        background:red;
        }
        div.wrapper-green {    
        height:5px;
        width:5px;
        padding:5px;
        background:green;
        }
        </style>
@stop 