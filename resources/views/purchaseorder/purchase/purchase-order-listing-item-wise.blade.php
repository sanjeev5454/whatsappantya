@extends('purchaseorder.layout.app')
@section('title', 'Purchase Order Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
@php
setlocale(LC_MONETARY, 'en_IN');
@endphp
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
        <div class="row">
          <div class="col-md-6">
            <div class="mb-15">  </div>
          </div>
        </div>
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
        <div class="tab-box-res"><a href="javascript:void(0);">Slect Order List</a></div>
        <ul class="nav nav-tabs tab-res-tab" id="myTab" role="tablist" style="margin-bottom:10px;">
          @if(Auth::user()->role_id!="4")
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing') }}">All ({{ count($purchase_data_all) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-draft') }}">Draft ({{ count($purchase_data_draft) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-awaiting-approval') }}">Awaiting Approval ({{ count($purchase_data_awaiting) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-approval') }}">Approved ({{ count($purchase_data_approved) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-po-wise') }}">PO View</a></li>
          @endif
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-invoice-wise') }}">Invoice View</a></li>
          @if(Auth::user()->role_id!="4")
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-intake-form') }}">Intake</a> </li>
          <li class="nav-item"> <a class="nav-link active">Item View</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-pending-list') }}">Pending List</a></li>
          @endif
        </ul>
        <div class="tab-content tab-table-fix" id="myTabContent">
          <div class="table-layout-fixed message-planner-box purchase-order-listing-box" id="billed" role="tabpanel" aria-labelledby="billed-tab">
            <table class="table responsive-table dataTable" cellspacing="0" id="exampleAddRow1">
              <thead>
                <tr>
                  <th class="s-no-row item-th">Item</th>
                  <th class="s-no-row invoice-number-th"></th>
                  <th class="date-row invoice-th"></th>
                  <th class="date-row status-th"></th>
                </tr>
              </thead>
              <tbody>
              
              @if(count($purchase_data)>0)
              @foreach($purchase_data as $key=>$data)
              @if($data['item']!='')
              <tr class="gradeA">
                <td data-table="Item" class="show-hide-tab"><span>{{ ItemDetails($data['item']) }}</span></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              
              <tr class="display-none has-table">
                <td colspan="4" align="center">
              <table class="table responsive-table dataTable" cellspacing="0" cellpadding="0">
                <tr>
                <thead>
                  <th class="center">PO#</th>
                  <th class="center">PO Date</th>
                  <th class="center">Q. Ordered</th>
                  <th class="center">Q. Received</th>
                  <th class="center">Invoice Date</th>
                  <th class="center">Balance Q.</th>
                  </thead>
                </tr>
              @php
              $purchase_data_items_val = DB::table('tbl_purchase_order_qty_update')->where('item', $data['item'])->get();
              @endphp
              @if(count($purchase_data_items_val>0))
              @php
              $qty_rec = 0;
              @endphp
              @foreach($purchase_data_items_val as $key=>$data_item)
              <tr class="gradeA">
                <td class="center" data-table="PO"><span>PO-{{ $data_item['order_number'] }}</span></td>
                <td class="center" data-table="PO Date">{{ purchaseOrderDetails($data_item['order_number'])->date }}</td>
                <td class="center" data-table="Q. Ordered">{{ $data_item['quantity'] }}</td>
                <td class="center" data-table="Q. Received">@if($data_item['qty_received']=='') 0 @else {{ $data_item['qty_received']}} @endif</td> 
                <td class="center" data-table="Invoice Date">@if($data_item['invoice_date']=='') -- @else {{ $data_item['invoice_date']}} @endif</td>
                <td class="center" data-table="Balance Q.">{{ $data_item['quantity']-$data_item['qty_received'] }}</td>
              </tr>
              @php
              $qty_rec += $data_item['quantity']-$data_item['qty_received'];
              @endphp
              @endforeach
              @endif
              <tr>
                  <td colspan="5" align="right">Total Balance Q. : </td>
                  <td class="center"><strong>{{$qty_rec}}</strong></td>
              </tr>
              </table>
                </td>
              </tr>
              @endif
              @endforeach
              
              @else
              <tr>
                <td colspan="4" class="no-data-table" align="center">There are no purchase orders to display.</td>
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


<script>

  $(function(){

     $(document).on('click','.change_order_qty',function(){
         
         
         var id = $(this).attr('cus');

		  var order_number = $('.order-number-'+id).val();

		  var item_number = $('.item-number-'+id).val();

		  var order = $('.order-'+id).val();

		  var qty_val = $('.quantity-received-'+id).val();
		  
		  var received_date = $('.received-on-data-'+id).val();
		  
		  var invoice_number = $('.received-through-invoice-number-'+id).val();
         
         var numberOfChecked = $('input:checkbox:checked').length;
         
         if(numberOfChecked<=0){
             alert('Please check Quantity Received.');
             return false;
         }else if(received_date==''){
            alert('Please fill the Received Date.');
             return false; 
         }else if(invoice_number==''){
            alert('Please fill the Invoice Number.');
             return false; 
         }else{

	      

		  if(qty_val!='' && qty_val!=0)

		  {

			$.ajax({

			type: "GET",

			url: "{{ url('purchaseorder/ajaxItemQuantityUpdateData')}}/"+qty_val+"/"+order_number+"/"+item_number+"/"+order+"/"+received_date+"/"+invoice_number,

			data: {qty_val:qty_val,order_number:order_number,item_number:item_number,order:order,received_date:received_date,invoice_number:invoice_number},

			success: function(msg){

				//alert(msg); return false;

			if(msg!='')

			{

			$('#'+id+'-status').html('Received');

			$('#'+id+'-received-qty').html(qty_val);

			$('#'+id+'-received-date').html(received_date);
			
			$('#'+id+'-received-invoice').html(invoice_number);

			$('.btn-danger').trigger('click');

			}

			}

			});

		  }
         }

	 });
	 
	 $(".show-hide-tab").click(function() {
		 $(this).toggleClass("show");
		 $(this).parent().next().toggleClass("display-none");        
    });
	
	$(".tab-box-res a").click(function() {
		 $(this).parent().next().toggleClass("show");        
    });
	
	$(".tab-res-tab a").click(function() {
		$(".tab-res-tab").removeClass("show");
	});
	

  });
  
  </script> 
  <script>
      $(function(){
         $(document).on('click','.approve',function(){
             var id = $(this).attr('cus'); 
             $(this).hide();
             if(id!='')
             {
                 $('#app-'+id).show();
			$.ajax({
			type: "GET",
			url: "{{ url('purchaseorder/ajaxinvoiceApprove')}}/"+id,
			data: {id:id},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			var obj=JSON.parse(msg);
			$('.line-'+id).removeClass('red-line');
			$('.line-'+id).addClass('green-line');
			$('#sta-'+id).html(obj['ajax_on_table']);
			$('#app-'+id).hide();
			$('#san-'+id).html(obj['ajax_table']);
			}
			}
			});

		  }
         }); 
      });
  </script>
  <style>
  .display-none{display:none;}
  
  </style>
  <style>
        div.wrapper-pink {    
        height:10px;
        width:10px;
        padding:10px;
        background:pink;
        }
        div.wrapper-red {    
        height:10px;
        width:10px;
        padding:10px;
        background:red;
        }
        div.wrapper-green {    
        height:10px;
        width:10px;
        padding:10px;
        background:green;
        }
        .red-line td {
        color: red !important;
        }
        .green-line td {
        color: green !important;
        }
        </style>

@stop 