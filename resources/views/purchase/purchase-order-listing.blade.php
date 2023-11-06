@extends('layout.app')
@section('title', 'Purchase Order Listing')
@section('content')

@include('layout.partials.sidebar')
<!-- Page -->
<div class="page">
      <div class="page-content">
      
        <!-- Panel Table Add Row -->
        <div class="panel">
          <header class="panel-heading">
            <h3 class="panel-title">Purchase Orders</h3>
          </header>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-15">
                  <a title="Add Item" href="{{ url('add-purchase-order') }}"><button class="btn btn-primary" type="button">
                    <i class="icon md-plus" aria-hidden="true"></i> New Purchase Order
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
			<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:10px;">
			<li class="nav-item">
			<a class="nav-link @if(@$_GET['page']=='') active show @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All ({{ count($purchase_data) }})</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Draft ({{ count($purchase_data_draft) }})</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="awaiting-tab" data-toggle="tab" href="#awaiting" role="tab" aria-controls="awaiting" aria-selected="false">Awaiting Approval ({{ count($purchase_data_awaiting) }})</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Approved ({{ count($purchase_data_approved) }})</a>
			</li>
			<li class="nav-item">
			<a class="nav-link @if(@$_GET['page']!='') active show @endif" id="billed-tab" data-toggle="tab" href="#billed" role="tab" aria-controls="billed" aria-selected="false">Item Wise</a>
			</li>
			</ul>
			<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade @if(@$_GET['page']=='') active show @endif " id="home" role="tabpanel" aria-labelledby="home-tab">
			<table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Reference</th>
                  <th>Supplier</th>
				  <th>Date raised</th>
				  <th>Delivery date</th>
				  <th>Amount</th>
				  <th>Status</th>
				  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(count($purchase_data)>0)
			  @foreach($purchase_data as $data)
                <tr class="gradeA">
                  <td>PO-{{$data->order_number}}</td>
                  <td>{{$data->reference}}</td>
                  <td>{{$data->contact}}</td>
				  <td>{{$data->date}}</td>
				  <td style="color:red;">{{$data->delivery_date}}</td>
				  <td>{{$data->total}}</td>
				  <td>@if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif @if($data->sent==1) <span style="color:green; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> Sent</span> @endif</td>
				  <td class="actions">
                     <a @if($data->status==0 || $data->status==2) href="{{ url('edit-purchase-order/'.$data->_id) }}" @else href="{{ url('view-purchase-order/'.$data->_id) }}" @endif class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="@if($data->status==0 || $data->status==2) Edit @elseif($data->status==1) View @endif">
					  @if($data->status==0 || $data->status==2)
					  <i class="icon md-edit" aria-hidden="true"></i>
					  @elseif($data->status==1 || $data->status==3)
					  <i class="icon md-eye" aria-hidden="true"></i>
					  @endif
					  </a>
                    <a href="{{ url('purchaseDelete/'.$data->_id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  
                  </td>
                </tr>
              @endforeach
			  @else
			  <tr><td colspan="8" align="center">There are no purchase orders to display.</td></tr>
			  @endif
              </tbody>
            </table>
			</div>
			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			<table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Reference</th>
                  <th>Supplier</th>
				  <th>Date raised</th>
				  <th>Delivery date</th>
				  <th>Amount</th>
				  <th>Status</th>
				  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(count($purchase_data_draft)>0)
			  @foreach($purchase_data_draft as $data)
                <tr class="gradeA">
                  <td>PO-{{$data->order_number}}</td>
                  <td>{{$data->reference}}</td>
                  <td>{{$data->contact}}</td>
				  <td>{{$data->date}}</td>
				  <td style="color:red;">{{$data->delivery_date}}</td>
				  <td>{{$data->total}}</td>
				  <td>@if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif @if($data->sent==1) <span style="color:green; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> Sent</span> @endif</td>
				  <td class="actions">
                     <a @if($data->status==0 || $data->status==2) href="{{ url('edit-purchase-order/'.$data->_id) }}" @else href="{{ url('view-purchase-order/'.$data->_id) }}" @endif class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="@if($data->status==0 || $data->status==2) Edit @elseif($data->status==1) View @endif">
					  @if($data->status==0 || $data->status==2)
					  <i class="icon md-edit" aria-hidden="true"></i>
					  @elseif($data->status==1 || $data->status==3)
					  <i class="icon md-eye" aria-hidden="true"></i>
					  @endif
					  </a>
                    <a href="{{ url('purchaseDelete/'.$data->_id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  
                  </td>
                </tr>
              @endforeach
			  @else
			  <tr><td colspan="8" align="center">There are no purchase orders to display.</td></tr>
			  @endif
              </tbody>
            </table>
			</div>
			<div class="tab-pane fade" id="awaiting" role="tabpanel" aria-labelledby="awaiting-tab">
			<table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Reference</th>
                  <th>Supplier</th>
				  <th>Date raised</th>
				  <th>Delivery date</th>
				  <th>Amount</th>
				  <th>Status</th>
				  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(count($purchase_data_awaiting)>0)
			  @foreach($purchase_data_awaiting as $data)
                <tr class="gradeA">
                  <td>PO-{{$data->order_number}}</td>
                  <td>{{$data->reference}}</td>
                  <td>{{$data->contact}}</td>
				  <td>{{$data->date}}</td>
				  <td style="color:red;">{{$data->delivery_date}}</td>
				  <td>{{$data->total}}</td>
				  <td>@if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif @if($data->sent==1) <span style="color:green; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> Sent</span> @endif</td>
				  <td class="actions">
                     <a @if($data->status==0 || $data->status==2) href="{{ url('edit-purchase-order/'.$data->_id) }}" @else href="{{ url('view-purchase-order/'.$data->_id) }}" @endif class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="@if($data->status==0 || $data->status==2) Edit @elseif($data->status==1) View @endif">
					  @if($data->status==0 || $data->status==2)
					  <i class="icon md-edit" aria-hidden="true"></i>
					  @elseif($data->status==1 || $data->status==3)
					  <i class="icon md-eye" aria-hidden="true"></i>
					  @endif
					  </a>
                    <a href="{{ url('purchaseDelete/'.$data->_id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  
                  </td>
                </tr>
              @endforeach
			  @else
			  <tr><td colspan="8" align="center">There are no purchase orders to display.</td></tr>
			  @endif
              </tbody>
            </table>
			</div>
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
			<table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Reference</th>
                  <th>Supplier</th>
				  <th>Date raised</th>
				  <th>Delivery date</th>
				  <th>Amount</th>
				  <th>Status</th>
				  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
			  @if(count($purchase_data_approved)>0)
			  @foreach($purchase_data_approved as $data)
                <tr class="gradeA">
                  <td>PO-{{$data->order_number}}</td>
                  <td>{{$data->reference}}</td>
                  <td>{{$data->contact}}</td>
				  <td>{{$data->date}}</td>
				  <td style="color:red;">{{$data->delivery_date}}</td>
				  <td>{{$data->total}}</td>
				  <td>@if($data->status==0) Draft @elseif($data->status==1) Approved @elseif($data->status==2) Awaiting Approval @elseif($data->status==3) Billed @endif @if($data->sent==1) <span style="color:green; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> Sent</span> @endif
				  @if(checkStatus($data->_id)!='')
				  <span style="color:green; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> {{ checkStatus($data->_id) }}</span>
				  @endif
				  </td>
				  <td class="actions">
                     <a @if($data->status==0 || $data->status==2) href="{{ url('edit-purchase-order/'.$data->_id) }}" @else href="{{ url('view-purchase-order/'.$data->_id) }}" @endif class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                      data-toggle="tooltip" data-original-title="@if($data->status==0 || $data->status==2) Edit @elseif($data->status==1) View @endif">
					  @if($data->status==0 || $data->status==2)
					  <i class="icon md-edit" aria-hidden="true"></i>
					  @elseif($data->status==1 || $data->status==3)
					  <i class="icon md-eye" aria-hidden="true"></i>
					  @endif
					  </a>
                    <a href="{{ url('purchaseDelete/'.$data->_id) }}" onclick="return confirm('Are you sure to delete the row?');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
					  
                  </td>
                </tr>
              @endforeach
			  @else
			  <tr><td colspan="8" align="center">There are no purchase orders to display.</td></tr>
			  @endif
              </tbody>
            </table>
			</div>
			<div class="tab-pane @if(@$_GET['page']!='') active show @endif" id="billed" role="tabpanel" aria-labelledby="billed-tab">
			<table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
				 <th>#PO Number</th>
                  <th>Order Date</th>
				  <th>Delivery Date</th>
                  <th>Items</th>
                  <th>Qty</th>
				  <th>Vendor Name</th>
				  <th>Status</th>
				  <th>Received Qty</th>
				  <th>Received Date</th>
                </tr>
              </thead>
              <tbody>
			  @if(count($purchase_data_items_val)>0)
			  @foreach($purchase_data_items_val as $key=>$data)
                <tr class="gradeA">
				  <td>{{ $data['order_number'] }}</td>
                  <td>{{ purchaseOrderDetails($data['order_number'])->date }}</td>
				  <td>{{ purchaseOrderDetails($data['order_number'])->delivery_date }}</td>
                  <td>{{ ItemDetails($data['item']) }}</td>
                  <td>{{ $data['quantity'] }}</td>
				  <td>{{ purchaseOrderDetails($data['order_number'])->contact }}</td>
				  <td class="actions" id="status-{{ $key }}">
				  @if(purchaseOrderDetailsReciveQty($data['_id'])=='')
                  <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal-{{ $key }}" type="button">
                  Change Status
                  </button>
				  @else
				  Received
				  @endif
                  </td>
					<div class="modal fade" id="myModal-{{ $key }}" role="dialog">
					<div class="modal-dialog">
					<!-- Modal content-->
					
					<div class="modal-content">
					<div class="modal-header" style="border-bottom:1px solid #e0e0e0;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Change Status</h4>
					</div>
					<div class="modal-body col-md-12">
					<form class="form-inline" action="">
					<label for="change_order_qty-{{ $key }}" class="mr-sm-2">Change Order Quantity : </label> 
					<input type="number" min="1" value="{{ $data['quantity'] }}"  id="change_order_qty-{{ $key }}" class="form-control" name="change_order_qty">
					</form>
					</div>
					<div class="modal-footer" style="border-top:1px solid #e0e0e0;">
					<button type="submit" class="btn btn-success change_order_qty" item_number="{{ $data['item'] }}" order_number="{{ $data['order_number'] }}" order="{{ $data['_id'] }}" cus="{{ $key }}">Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
					</div> 
					</div>
					</div>
				  <td id="re-qty-{{ $key }}">{{ purchaseOrderDetailsReciveQty($data['_id']) }}</td>
				  <td id="re-date-{{ $key }}">{{ purchaseOrderDetailsReciveDate($data['_id']) }}</td>
                </tr>
              @endforeach
			  @else
			  <tr><td colspan="9" align="center">There are no purchase orders to display.</td></tr>
			  @endif
              </tbody>
            </table>
			<div style="text-align:center;">{{ $purchase_data_items_val->links() }}</div>
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
<script>
  $(function(){
     $(document).on('click','.change_order_qty',function(){
	      var id = $(this).attr('cus');
		  var order_number = $(this).attr('order_number');
		  var item_number = $(this).attr('item_number');
		  var order = $(this).attr('order');
		  var qty_val = $('#change_order_qty-'+id).val();
		  if(qty_val!='' && qty_val!=0)
		  {
			$.ajax({
			type: "GET",
			url: "{{ url('ajaxItemQuantityUpdateData')}}/"+qty_val+"/"+order_number+"/"+item_number+"/"+order,
			data: {qty_val:qty_val,order_number:order_number,item_number:item_number,order:order},
			success: function(msg){
				//alert(msg); return false;
			if(msg!='')
			{
			$('#status-'+id).html('Received');
			$('#re-qty-'+id).html(qty_val);
			$('#re-date-'+id).html(msg);
			$('.btn-danger').trigger('click');
			}
			}
			});
		  }
	 });
  });
  </script>
@stop

