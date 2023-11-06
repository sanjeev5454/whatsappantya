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
          <li class="nav-item"> <a class="nav-link @if(@$_GET['page']=='') active show @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All ({{ count($purchase_data) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-draft') }}">Draft ({{ count($purchase_data_draft) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-awaiting-approval') }}">Awaiting Approval ({{ count($purchase_data_awaiting) }})</a> </li>
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
          <div class="table-layout-fixed message-planner-box purchase-order-listing-table" id="home" role="tabpanel" aria-labelledby="home-tab">
          
            <table class="table responsive-table dataTable t1" cellspacing="0" id="exampleAddRow1"> <!--table-bordered table-hover table-striped-->
              <thead>
                <tr>
                  <th class="sort ta po-th" style="cursor:pointer;" id="heder_po_all">#PO</th>
                  <th class="sort ta vendor-th" style="cursor:pointer;" id="heder_vendor_all">Vendor</th>
                  <th class="sort ta date-raised-th" style="cursor:pointer;" id="heder_date_all">Date raised</th>
                  <th class="delivery-date-th">Delivery date</th>
                  <th class="amount-th">Amount</th>
                  <th class="status-th">Status</th>
                  <th>Instructed by</th>
                  <th class="notification-th">Notification</th>
                  <th class="action-th">Action</th>
                  <th class="color-th">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
              
              @if(count($purchase_data)>0)
              
              @foreach($purchase_data as $data)
                @php
                $del = date('Y-m-d',strtotime($data->delivery_date));
                $late_pink = date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d'))));
                $late = date('Y-m-d');
                $qty = 0;
                $rec_q = 0;
                for($i=1;$i<=count($data->row);$i++)
                {
                $rec_q += purchaseOrderDetailsReciveQty($data->row[$i]['item'],$data->order_number,$data->row[$i]['order']);
                $qty +=$data->row[$i]['quantity'];
                }
                @endphp
                
              <tr class="gradeA s-{{$data->contact}}">
                <td data-table="#PO">PO-{{$data->order_number}}</td>
                <td data-table="Vendor">{{$data->contact}}</td>
                <td data-table="Date raised"><span style="display:none;">{{ strtotime($data->date)}}</span>{{$data->date}}</td>
                <td data-table="Delivery date"><span style="color: @if($qty==$rec_q) green @elseif($del<=$late) red @elseif($del<=$late_pink) pink @endif">{{$data->delivery_date}}</span></td>
                <td data-table="Amount">{{$data->total}}</td>
                <td data-table="Status"><div class="inline-box">
                @if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif </div></td> 
                <td data-table="Instructed By"><div class="inline-box">{{userDetails($data->instructed_by)->name}}</div></td>
                <td data-table="Notification">{{$data->notification}}</td>
                <td class="actions purchase-order-actions" data-table="Actions">
                    @if($data->status==1)
                    <form action="{{ url('purchaseorder/purchaseorderapprovedsent/'.$data->_id) }}" method="post" style="display:inline;">
                    @csrf
                    <!--<button type="submit" data-toggle="tooltip" data-original-title="Resend" class="btn btn-sm btn-icon btn-pure btn-default on-default"><i class="icon md-whatsapp" aria-hidden="true"></i></button>-->
                    <span class="download-dropdown">
                    <button type="submit" data-toggle="tooltip" data-original-title="Resend" class="btn btn-sm btn-icon btn-pure btn-default on-default"><i class="icon md-whatsapp" aria-hidden="true"></i></button>
                    <ul>
                    <li><a href="{{ url('purchaseorder/purchaseorderapprovedsentAdmin/'.$data->_id) }}"><i class="icon md-whatsapp" aria-hidden="true"></i>To Admin</a></li>
                    <li><a href="{{ url('purchaseorder/purchaseorderapprovedsentVendor/'.$data->_id) }}"><i class="icon md-whatsapp" aria-hidden="true"></i>To Vendor </a></li>
                    <li><a href="{{ url('purchaseorder/purchaseorderapprovedsentStaff/'.$data->_id) }}"><i class="icon md-whatsapp" aria-hidden="true"></i>To Staff</a></li>
                    </ul>
                    </span>
                    </form>
                    @endif
                    
                    @if($data->status==1)
                  <span class="download-dropdown"><a href="javascript:void(0)" class="btn btn-sm btn-icon btn-pure btn-default on-default"><i class="icon md-download" aria-hidden="true"></i></a>
                    <ul>
                    @if(Auth::user()->user_role==1)
                    <!--<li><a href="{{ url('purchaseorder/vendor-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Vendor Desktop Download</a></li>-->
                    <li><a href="{{ url('purchaseorder/vendor-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Vendor Download</a></li>
                    <li><a href="{{ url('purchaseorder/staff-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Download</a></li>
                    <!--<li><a href="{{ url('purchaseorder/staff-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Desktop Download</a></li>-->
                    @else
                    <li><a href="{{ url('purchaseorder/staff-mobile-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Download</a></li>
                    <!--<li><a href="{{ url('purchaseorder/staff-desktop-generate-pdf/'.$data->_id) }}"><i class="icon md-download" aria-hidden="true"></i>Staff Desktop Download</a></li>-->
                    @endif
                    </ul>
                   </span>
                   @endif
                    
                    @if($data->status==0 || $data->status==2)
                    <a href="{{ url('purchaseorder/edit-purchase-order/'.$data->_id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                    @endif
                    @if(Auth::user()->user_role==1 || Auth::user()->user_role==2)
                     @if($data->status==1)
                    <a href="{{ url('purchaseorder/edit-purchase-order/'.$data->_id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                    @endif
                    @endif
                    
                    @if($data->status==1 || $data->status==3)
                    <a href="{{ url('purchaseorder/view-purchase-order/'.$data->_id) }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                    @endif
                    
                    
                  @if($data->status==0 || $data->status==2) 
                  @if(Auth::user()->user_role==1)
                  <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('purchaseorder/purchaseorderapproved/'.$data->_id) }}"  data-original-title="Approval"><i class="icon md-check" aria-hidden="true"></i></a> 
                  @endif
                  @if(in_array(Auth::user()->id,$approval_rights))
                  <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('purchaseorder/purchaseorderapproved/'.$data->_id) }}" data-original-title="Approval"><i class="icon md-check" aria-hidden="true"></i></a> 
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
                    <span class="download-dropdown right-dropdown click-to-open">
                    <button type="button" data-toggle="tooltip" data-original-title="Sent By" class="btn btn-sm btn-icon btn-pure btn-default on-default">
                        @if($data->message_receive_type!='' && $data->message_receive)
                        <i class="icon md-check-all" aria-hidden="true"></i>
                        @else
                        <i class="icon md-more-vert" aria-hidden="true"></i>
                        @endif
                        </button>
                    @if($data->message_receive_type!='' && $data->message_receive)
                    <ul class="no-icon">
                    <li><a href="javascript:void(0);"><strong>Sent by</strong> {{$data->message_receive_type}} : <span>{{$data->message_receive}}</span></a></li>
                    </ul>
                    @else
                    <form action="{{ url('purchaseorder/purchaseMessageReceiveData/') }}" method="post">
                        @csrf 
                        <input type="hidden" value="{{$data->_id}}" name="id">
                    <ul class="status-fill">
                    <span class="close-btn"><a href="javascript:void(0);"><i class="icon md-close-circle" aria-hidden="true"></i></a></span>
                    <li>
                    <select class="form-control message_receive_type" name="message_receive_type">
                    <option value="Whatsapp">Whatsapp</option>
                    <option value="Telegram">Telegram</option>
                    <option value="Text Message">Text Message</option>
                    <option value="Courier">Courier</option>
                    <option value="Speed Post">Speed Post</option>
                    </select>
                    </li>
                    <li class="text-box-wrap">
                    <input type="text" name="message_receive_date" autocomplete="off" required class="form-control date_receiving message_receive_date" placeholder="Date"/>
                    <input type="text" name="message_receive_doc" autocomplete="off" style="display:none;" class="form-control message_receive_doc" placeholder="Doc #"/>
                    <input style="cursor:pointer;" type="submit"  value="Submit" />
                    </li>
                    </ul>
                    </form>
                    @endif
                    </span>
                      </td>
                      <td class="delivery-status" data-table="Delivery Status">@if($qty==$rec_q)<div class="wrapper-green"></div>@elseif($del<=$late)<div class="wrapper-red"></div>@elseif($del<=$late_pink)<div class="wrapper-pink"></div>@endif</td>
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
    var table = $('.t1');
    $('#heder_po_all, #heder_vendor_all, #heder_date_all')
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
});
</script>
<script>
$(function(){
    var table = $('.t2');
    $('#heder_po_draft, #heder_vendor_draft, #heder_date_draft')
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
});
</script>
<script>
$(function(){
    var table = $('.t4');
    $('#heder_po_approve, #heder_vendor_approve, #heder_date_approve')
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
});
</script>

{!!Html::script('assets/js/jquery-ui_datepicker.js')!!}
{!!Html::style('assets/css/jquery-ui_datepicker.css')!!}
<script>
$(document).ready(function () {
$('.date_receiving').datepicker({
    dateFormat: "dd M yy",
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
        
        <script>
		$(function(){
			$(".click-to-open button.btn ").click(function() {
				$(".status-fill").removeClass('active-ul');
                $(this).parent().find(".status-fill").toggleClass('active-ul');
            });
			
			$(".status-fill .close-btn").click(function() {
                $(".status-fill").removeClass('active-ul');
            });
         });
        </script>
        <script>
            $(function(){
               $(document).on('change','.message_receive_type',function(){
                   var id = $(this).val();
                   if(id=='Courier' || id=='Speed Post')
                   {
                       $('.message_receive_doc').show();
                       $('.message_receive_date').hide();
                       $('.message_receive_doc').attr('required','required');
                       $('.message_receive_date').removeAttr('required');
                   }else{
                       $('.message_receive_doc').hide();
                       $('.message_receive_date').show();
                       $('.message_receive_date').attr('required','required');
                       $('.message_receive_doc').removeAttr('required');
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