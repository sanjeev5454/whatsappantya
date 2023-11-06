@extends('layout.app')
@section('title', 'Add Purchase Order')
@section('content')
@include('layout.partials.sidebar')
<style type="text/css">
.table-wrap table{ border:1px solid #dddddd; font-size:14px }
.table-wrap th, .table-wrap td{ padding:10px 10px; border-bottom:1px solid #ddd; border-right:1px solid #ddd; }
.table-wrap th{ background:#fafbfb; white-space:nowrap; color:#999; font-weight:bold; padding:7px 10px; }
.purchaseorder-box{ clear:both; }
.purchaseorder-box .search-form{ margin-bottom:5px; }
.purchaseorder-box .search-form .search-form-box{ width:100%; clear:both; float:left; }
.purchaseorder-box .search-form .search-form-box > div{ float:left; margin:0 10px 10px 0; }
.purchaseorder-box .search-form hr{ clear:both; width:100%; }
.purchaseorder-box .search-form .search-form-box .contact-form{ width:250px; }
.purchaseorder-box .search-form .search-form-box .date-form{ width:180px; }
.purchaseorder-box .search-form .search-form-box > div label{ margin:0 0 2px; display:block; }
.purchaseorder-box .search-form .search-form-box > div input,
.purchaseorder-box .search-form .search-form-box > div select{ padding:8px 10px; border:1px solid #dddddd; }
.purchaseorder-box .search-form .search-form-box > div select{ padding-right:30px; display:inline-block; }
.purchaseorder-box .search-form .search-form-box .contact-form.right-amounts{ float:right; margin-right:0; }
.purchaseorder-box .search-form .search-form-box .contact-form.right-amounts label{ width:auto; display:inline-block; margin:0 5px 0 0; font-weight:bold; }
.purchaseorder-box .search-form .search-form-box .contact-form.right-amounts select{ width:calc(100% - 100px); }
.purchaseorder-box .table-wrap{ margin-bottom:15px; }
.purchaseorder-box .add-row{ width: 100%; clear: both; padding: 0 0 15px; overflow:hidden; border-bottom:1px solid #e0e0e0; }
.purchaseorder-box .add-left{ float: left; }
.purchaseorder-box a.btn + .add-left{ margin-right:5px; }
.purchaseorder-box .total-right{ float: right; margin-bottom:30px; }
.purchaseorder-box .total-right .subtotal-box{ border-bottom:1px solid #ddd; width: 300px; box-sizing: border-box; padding:8px 0 8px 30px; overflow: hidden; }
.purchaseorder-box .total-right .subtotal-box label{ margin:0; float:left; }
.purchaseorder-box .total-right .subtotal-box span{ float:right; }
.purchaseorder-box .total-right .subtotal-box.grand-total{ font-weight: bold; font-size: 150%;}
.purchaseorder-box .address-wrap{ clear:both; border-top:1px solid #e0e0e0; padding-top:20px;  }
.purchaseorder-box .address-wrap label{ margin:0 0 2px; display:block; font-weight:bold; }
.purchaseorder-box .form-box{ margin-bottom:15px; }
.purchaseorder-box textarea{ height:110px; }
.purchaseorder-box .save-row{ padding:15px 0 0 0; clear: both; border-top:1px solid #e0e0e0; overflow:hidden; }
.delivery-address{ position:relative; z-index:99; display:inline-table; }
.delivery-address .dropdown-box{ position:absolute; background:#fff; top:99.99%; left:0; display:none; width:300px; }
.delivery-address.clicked .dropdown-box{ display:block; }
.delivery-address > a{ display:inline-table; padding:5px 20px 5px 0; }
.delivery-address > a:after { display: inline-block; width: 0; height: 0; margin-left: .2431rem; vertical-align: .2431rem; content: ""; border-top: .286rem solid; border-right: .286rem solid transparent;  border-bottom: 0; border-left: .286rem solid transparent; }
.delivery-address ul{ margin:0; padding:0; list-style:none; border:1px solid #e0e0e0; max-height:160px; overflow:auto; }
/* width */
.delivery-address ul::-webkit-scrollbar { width:10px; }
/* Track */
.delivery-address ul::-webkit-scrollbar-track { background:#f1f1f1; }
/* Handle */
.delivery-address ul::-webkit-scrollbar-thumb { background:#888; border-radius: 10px;  }
/* Handle on hover */
.delivery-address ul::-webkit-scrollbar-thumb:hover { background:#555; }
.delivery-address ul li{ padding:10px; border-bottom:1px solid #e0e0e0; cursor:pointer; }
.delivery-address ul li.link-tab{ padding:0; }
.delivery-address ul li.link-tab a{ padding:10px; display:block; }
.delivery-address ul li.link-tab a:hover{ text-decoration:underline; }
.delivery-address ul li:hover{ background-color:#fafafa; }
.delivery-address ul li h2{ margin:0 0 8px; font-size:15px; }
.delivery-address ul li p:last-child{ margin-bottom:0; }
.table-wrap input { min-height:32px; color:#999; }
.table-wrap td{ height:32px; }
.typeahead { background-color: #FFFFFF; }
.tt-query { box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset; }
.tt-hint { color: #999999; }
.tt-menu { background-color: #FFFFFF; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 8px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); margin-top: 12px; padding: 8px 0; width: 190px; }
.tt-suggestion { font-size: 22px;  /* Set suggestion dropdown font size */ padding: 3px 20px; }
.tt-suggestion:hover { cursor: pointer; background-color: #0097CF; color: #FFFFFF; }
.tt-suggestion p { margin: 0; }
.dashboard .card { height: calc(100% - 90px); background:none;}
.table td, .table th { padding: 5px; vertical-align: top; border-top: 1px solid #e0e0e0; }
.two-button button{ float:left; border-radius:5px 0 0 5px; border-right:1px solid rgba(0, 0, 0, 0.1); padding:5px 15px !important; }
.two-button button + button{ border-radius:0 5px 5px 0; border-right:1px solid rgba(0, 0, 0, 0); outline:none; padding:5px 10px !important; }
.card-body{ background:#fff; -ms-flex: 1 1 auto; flex: 1 1 auto; padding: 1.429rem; }
.history-box{ margin-top:30px;  background:#fff; -ms-flex: 1 1 auto; flex: 1 1 auto; padding:0; }
.history-box h2{ font-size:15px; margin:0; padding:0 0 10px; border-bottom:1px solid #e0e0e0; }
.history-form{ padding:1.429rem; background:#fafbfb; border-bottom:0px solid #e0e0e0; display:none1; }
.history-box.clicked .history-form{ display:block; }
.history-box.clicked .note-box{ display:none; }
.textarea-box{ padding:0 0 15px 0; }
.textarea-box textarea{ height:100px; }
.note-box{ padding:15px 0; }
</style>
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
    <div class="row justify-content-md-center">
      <div class="col-md-12">
        <h2>View Purchase Order {{ 'PO-'.$purchase_data->order_number }}</h2>
        <?php if(@Session::get('success')!=''){?>
        <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
        <?php } ?>
		<form class="" action="{{ url('new-purchase-order-update/'.$purchase_data->_id) }}" method="post" autocomplete="on" onsubmit="return validate();">
		@csrf
        <div class="card">
          <div class="card-body">
            <div class="purchaseorder-box">
              <div class="search-form">
                
                  <div class="search-form-box">
				  <div class="col-md-12" style="padding-left:0px;">@if($purchase_data->status==0) Draft @elseif($purchase_data->status==1) <span style="color:green;">Approved</span> @elseif($purchase_data->status==2) <span style="color:green;">Awaiting Approval</span> @elseif($purchase_data->status==3) <span style="color:green;">Billed</span> @endif @if($purchase_data->sent==1) <span style="color:red; margin-left:20px;"><img style="width: 20px;height: auto;" src="{{ url('assets/images/checkicon.png') }}" alt=""> Sent</span> @endif<span style="float:right;">  <a data-toggle="modal" data-target="#myModal" class="btn btn-default waves-effect waves-classic">Send</a>  <a href="{{ url('generate-pdf/'.$purchase_data->_id) }}" class="btn btn-default waves-effect waves-classic">Pdf</a> 
				 
				  <div class="add-left">
                  <div class="dropdown two-button show">
                    <button type="button" class="btn btn-primary add-new-line waves-effect waves-classic" cus="1">Options</button>
                    <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-classic" data-toggle="dropdown" aria-expanded="false"> </button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(78px, 34px, 0px);"> <a class="dropdown-item add-new-line" cus="5" href="{{ url('edit-purchase-order/'.$purchase_data->_id) }}">Edit</a> <a class="dropdown-item add-new-line" href="{{ url('purchaseDelete/'.$purchase_data->_id) }}" onclick="return confirm('Are you sure to delete the row?');">Delete</a> </div>
                  </div>
                </div></span></div>
				  <hr />
                    <div class="contact-form bs-example">
					
                      <label for="contact">Vendor</label>
                      <span style="color:#000000;">{{ $purchase_data->contact }}</span>
					  <br />
					  <br />
					  <span style="color:#000000;">Address</span>
					  <br />
					  <span style="color:#000000;">{{ vendorDetails($purchase_data->contact)->address }}</span>
					  <br />
					  <br />
					  Email :<span style="color:#000000;">{{ vendorDetails($purchase_data->contact)->email }}</span>
					  <br />
                    </div>
                    <div class="date-form">
                      <label for="date">Date</label>
                      <span style="color:#000000;">{{ $purchase_data->date }}</span>
                    </div>
                    <div class="date-form">
                      <label for="delivery-date">Delivery Date</label>
                      <span style="color:#000000;">{{ $purchase_data->delivery_date }}</span>
                    </div>
                    <div class="date-form">
                      <label for="order-number">Order number</label>
                     <span style="color:#000000;">{{ 'PO-'.$purchase_data->order_number }}</span>
                    </div>
					@if($purchase_data->reference!='')
                    <div class="date-form">
                      <label for="reference">Reference</label>
                      <span style="color:#000000;">{{ $purchase_data->reference }}</span>
                    </div>
					@endif
                  </div>
                  <hr />
                  <div class="search-form-box">
                 
                  </div>
                
              </div>
              <div class="table-wrap">
                <table class="editable-table table table-striped" id="editableTable1">
                  <thead>
                    <tr>
                      <th width="170">Item</th>
                      <th>Item SKU</th>
                      <th width="80">Quantity</th>
					  <th width="110">Unit</th>
                      <th width="110">Price</th>
                      <th width="90">Disc %</th>
                      <th width="110">Amount INR</th>
					  <th width="90">GST %</th>
                    </tr>
                  </thead>
                  <tbody id="results">
                  @for($i=1;$i<=count($purchase_data->row);$i++)
                  <tr id="data-row-{{ $i }}">
                    <td data-text="Item">
					{{ ItemDetails($purchase_data->row[$i]['item']) }}  @if(ItemDetailsUpdateQty($purchase_data->_id)!='')<span style="color:#063; font-size:9px; float:right;">  <strong>Received [{{ ItemDetailsUpdateQty($purchase_data->_id) }}]</strong><br /><strong>{{ ItemDetailsUpdateDate($purchase_data->_id) }}</strong></span> @endif
                    </td>
                    <td data-text="Item SKU" id="data-row-item-sku-{{ $i }}">
					{{ $purchase_data->row[$i]['item_sku'] }}
                    </td>
                    
                    <td data-text="Quantity">
					{{ $purchase_data->row[$i]['quantity'] }}
                    </td>
					<td data-text="Unit">
					{{ $purchase_data->row[$i]['unit'] }}
                    </td>
                    <td data-text="Price">
					{{ $purchase_data->row[$i]['price'] }}
                    </td>
                    <td data-text="Disc %">
					{{ $purchase_data->row[$i]['disc'] }}
                    </td>
                    <td data-text="Amount INR" id="data-row-amount-{{ $i }}" class="amount" style="font-weight:bold;" align="right">
					{{ $purchase_data->row[$i]['amount'] }}
                    </td>
					<td data-text="GST %">
					{{ $purchase_data->row[$i]['gst'] }}
                    </td>
                  </tr>
                  @endfor
                  </tbody>
                  
                </table>
              </div>
              <div class="add-row">
                <div class="total-right">
                  <div class="subtotal">
                    <div class="subtotal-box">
                      <label>Subtotal</label>
                      <span id="subtotal">{{ $purchase_data->subtotal }}</span></div>
					  <div class="subtotal-box">
                      <label>GST</label>
                      <span id="gst-total">{{ $purchase_data->gst_total }}</span></div>
                    <div class="subtotal-box grand-total">
                      <label><strong>Total</strong></label>
                      <span id="grandtotal">{{ $purchase_data->total }}</span></div>
                  </div>
                </div>
				
				
                
				<div class="row address-wrap">
				<div class="col-md-12">
				<h3>Delivery details</h3>
				<div class="delivery-address">
				Delivery Address
				</div>
				</div>
				
                  <div class="col-md-3 address-bydefault">
                    <label id="add-label-html">{{$purchase_data->address['delivery_address_label']}}</label>
                    <p><span id="add-street-address-html">{{$purchase_data->address['delivery_address_street_address']}}</span>
                      <span id="add-town-city-html">{{$purchase_data->address['delivery_address_town_city']}}</span><br/>
                      <span id="add-state-region-html">{{$purchase_data->address['delivery_address_state_region']}}</span><br/>
                      <span id="add-zip-code-html">{{$purchase_data->address['delivery_address_zip_code']}}</span><br/>
                      <span id="add-country-html">{{$purchase_data->address['delivery_address_country']}}</span></p>
                  </div>
				  <div class="col-md-3 address-select" style="display:none;">
				  <label>Address</label>
				  {{$purchase_data->address['new_delivery_address']}}
				  </div>
                  <div class="col-md-3">
                    <div class="form-box">
                      <label>Kind Attention</label>
                      {{$purchase_data->address['attention']}}
                    </div>
                   
                  </div>
                  <div class="col-md-6">
                    <label>Delivery Instructions</label>
                    {{stripslashes($purchase_data->address['instruction'])}}
                  </div>
                </div>
              </div>
			  
			  <!--<div class="history-box">
		  <h2>History & Notes</h2>
		  <div class="history-form1">
		  {{stripslashes($purchase_data->history_note)}} 
		  </div>
		  </div>-->
			  
              <div class="save-row">
			   @if($purchase_data->status==0)
                <div class="save-left float-left"> <button type="submit" name="save" value="save" class="btn btn-primary">Save</button> </div>
				@endif
				@if($purchase_data->status==2)
				<button type="submit" name="awaiting" value="save" class="btn btn-primary">Save & submit for approval</button>
				@endif
                <div class="save-right float-right"> <a href="{{ url('purchase-order-listing') }}"  class="btn btn-secondary">Cancel</a> </div>
              </div>
            </div>
          </div>
		  
		  
		  
        </div>
		
		</form>
		
		
		
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    <form class="" action="{{ url('purchase-order-send/'.$purchase_data->_id) }}" method="post" autocomplete="on">
	@csrf
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="border-bottom:1px solid #e0e0e0;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Purchase Order</h4>
        </div>
        <div class="modal-body">
		  <table width="100%" class="table table-bordered table-hover table-striped">
		<tr>
		<td><strong>From</strong></td>
		<td>{{ userDetails(Auth::id())->name }}</td>
		</tr>
		<tr>
		<td><strong>Reply to</strong></td>
		<td>{{ userDetails(Auth::id())->email }}</td>
		</tr>
		</table>
		<hr />
		<strong>To</strong>:<input type="text" class="form-control width-full" value="{{ vendorDetails($purchase_data->contact)->email }}" id="to_send_email" name="to_send_email">
		<div style="margin-top:20px;">
		<strong>Message</strong>:<input type="text" class="form-control width-full" value="Purchase Order PO-{{ $purchase_data->order_number }} from {{ userDetails(Auth::id())->name }} for {{ $purchase_data->contact }}" id="to_send_subject" name="to_send_subject">
		</div>
		<div style="margin-top:20px;">
		<textarea class="form-control width-full" wrap="hard" style="height:200px;white-space: pre-line;text-align: left;-moz-text-align-last: left;text-align-last: left;" rows="4" cols="20" name="to_send_message_body">Hi {{ $purchase_data->contact }},
Here's purchase order PO-{{ $purchase_data->order_number }} for INR {{ $purchase_data->total }}.
Delivery due date, address and instructions are included in the purchase order.
If you have any questions, 
Please let us know.
Thanks,
{{ userDetails(Auth::id())->name }}
		</textarea>
		</div>
		
		
		<div class="checkbox-custom checkbox checkbox-primary checkbox-sm">
		<input type="checkbox" @if(@in_array('sms',vendorDetails($purchase_data->contact)->notification)) checked @endif  class="checkBoxClass" id="inputCheckboxsms" value="1" name="smssend">
		<label for="inputCheckboxsms">SMS (Text Message)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" @if(@in_array('whatsup',vendorDetails($purchase_data->contact)->notification)) checked @endif class="checkBoxClass" id="inputCheckboxwhatsup" value="1" name="whatsappsend">
		<label for="inputCheckboxwhatsup">Whatsapp</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" class="checkBoxClass" @if(@in_array('mail',vendorDetails($purchase_data->contact)->notification)) checked @endif id="inputCheckboxmail" value="1" name="mailsend">
		<label for="inputCheckboxmail">Mail</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--<input type="checkbox" class="ckbCheckAll" @if(@in_array('all',vendorDetails($purchase_data->contact)->notification)) checked @endif id="inputCheckboxall" value="all" name="all">
		<label for="inputCheckboxall">All</label>-->
		</div>
		
		
        </div>
		
        <div class="modal-footer" style="border-top:1px solid #e0e0e0;">
		  <button type="submit" class="btn btn-success">Send</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
     </form> 
    </div>
  </div>
@endsection
@section('pagescript')
<script>
$(document).ready(function () {
    $("#inputCheckboxall").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });
});
</script>
@stop
