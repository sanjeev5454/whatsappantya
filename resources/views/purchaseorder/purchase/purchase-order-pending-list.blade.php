@extends('purchaseorder.layout.app')
@section('title', 'Purchase Order Listing')
@section('content')
@include('purchaseorder.layout.partials.sidebar') 
<!-- Page -->
<div class="page no-padding-mobile">
  <div class="page-content container-fluid">    
    <!-- Panel Table Add Row -->    
    <div class="panel1">
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
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-awaiting-approval') }}">Awaiting Approval ({{ count($purchase_data_awaiting) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-approval') }}">Approved ({{ count($purchase_data_approved) }})</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-po-wise') }}">PO Wise</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-invoice-wise') }}">Invoice Wise</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-intake-form') }}">Intake</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{ url('purchaseorder/purchase-order-listing-item-wise') }}">Item View</a></li>
          <li class="nav-item"> <a class="nav-link active">Pending List</a></li>
        </ul>
        <form action="{{url('purchaseorder/purchaseorderIntake')}}" method="post">
            @csrf
        <div class="tab-content tab-table-fix" id="myTabContent">
          <div class="purchase-order-pending-list-wrap" id="intake" role="tabpanel" aria-labelledby="intake-tab">
            <div class="search-form-wrap new-search-form-wrap">
                
  <div class="search-form-box new-date-form">
      <div class="new-date-form-section">
      <select class="form-control select-vendor" style="width:20%;margin: 0 auto;">
          <option value="">Vendor</option>
          @foreach(getVendor() as $vendors)
          <option value="{{ $vendors->vendor_code }}">{{ $vendors->vendor_code }}</option>
          @endforeach
          </select>          
      </div>
   <label class="radio-inline"><input class="select_type" type="radio" name="select_type" value="po"> PO Wise</label>
   <label class="radio-inline"><input class="select_type" type="radio" name="select_type" value="item"> Item Wise</label>
  </div>
</div>


<span id="result-data"></span>
          </div>
        </div>
        </form>
      </div>
    </div>
    
    <!-- End Panel Table Add Row --> 
    
  </div>
</div>

<!-- End Page --> 

@endsection 

@section('pagescript') 
{!!Html::script('https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js')!!} 
<script type="text/javascript">
	$(document).ready(function(){
	// Defining the local dataset
	var cars = ['{!! $autocomplete !!}'];
	
	// Constructing the suggestion engine
	var cars = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	local: cars
	});
	
	// Initializing the typeahead
	$('.typeahead').typeahead({
	hint: true,
	highlight: true, /* Enable substring highlighting */
	minLength: 1 /* Specify minimum characters required for showing result */
	},
	{
	name: 'cars',
	source: cars
	});
	});  
	</script> 
	<script>
$(function(){
$('.typeahead').on('typeahead:selected', function(evt, item) {
var typeahead_val = $(this).val();
$(":input:not([name=vendor])").prop("disabled", false);
   if(typeahead_val!=''){
   //$(":input:not([name=contact])").prop("disabled", false);
   //$("button[name='approve']").prop("disabled", true);
   //$("input[name='copy_of_staffs[]']").prop( "disabled", true );
    $.ajax({
			type: "GET",
			url: "{{ url('purchaseorder/ajaxTypeheadData')}}/"+typeahead_val,
			data: {typeahead_val:typeahead_val},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			 $('.item').html(msg);
			}
			}
			});
   }
});
});
</script> 
 
{!!Html::script('assets/js/jquery-ui_datepicker.js')!!}
{!!Html::style('assets/css/jquery-ui_datepicker.css')!!}

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
        $('input[name="select_type"]').click(function(){
         var select_vendor = $('.select-vendor').val();
       if($("input[name='select_type']:checked").val()=='po'){
           if(select_vendor==''){
               alert("Please select vendor name.");
               return false;
           }else{
               {
            var type = $("input[name='select_type']:checked").val();
			$.ajax({
			type: "GET",
			url: "{{ url('purchaseorder/ajaxPendingList')}}/"+type+"/"+select_vendor,
			data: {type:type,vendor:select_vendor},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			$('#result-data').html(msg);
			}
			}
			});
		    }
           }
       }
       if($("input[name='select_type']:checked").val()=='item'){
            if(select_vendor==''){
               alert("Please select vendor name.");
               return false;
           }else{
               {
            var type = $("input[name='select_type']:checked").val();
			$.ajax({
			type: "GET",
			url: "{{ url('purchaseorder/ajaxPendingList')}}/"+type+"/"+select_vendor,
			data: {type:type,vendor:select_vendor},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			$('#result-data').html(msg);
			}
			}
			});
		    }
           }
       }
        });
    });
</script>
<script>
    $(function(){
       $(document).on('change','.select-vendor',function(){
            var select_vendor = $(this).val();
            if(select_vendor==''){
               alert("Please select vendor name.");
               return false;
           }else{
            var type = $("input[name='select_type']:checked").val();
            if(type!=''){
            $.ajax({
			type: "GET",
			url: "{{ url('purchaseorder/ajaxPendingList')}}/"+type+"/"+select_vendor,
			data: {type:type,vendor:select_vendor},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			$('#result-data').html(msg);
			}
			}
			});
            }
           }
       }); 
    });
</script>

<style>
    #ui-id-1{display:none;}
    .ui-widget-content{display:none;}
</style>

@stop 