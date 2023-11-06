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
/*.purchaseorder-box .search-form .search-form-box .contact-form{ width:250px; }*/
.purchaseorder-box .search-form .search-form-box .date-form{ width:180px; }
.purchaseorder-box .search-form .search-form-box .date-form.datesmall{ width:110px; }
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
.purchaseorder-box .total-right{ float: right; margin-bottom:30px; }
.purchaseorder-box .total-right .subtotal-box{ border-bottom:1px solid #ddd; width: 300px; box-sizing: border-box; padding:8px 0 8px 30px; overflow: hidden; }
.purchaseorder-box .total-right .subtotal-box label{ margin:0; float:left; }
.purchaseorder-box .total-right .subtotal-box span{ float:right; }
.purchaseorder-box .total-right .subtotal-box.grand-total{ font-weight: bold; font-size: 150%;}
.purchaseorder-box .address-wrap{ clear:both; border-top:1px solid #e0e0e0; padding-top:20px; }
.purchaseorder-box .address-wrap label{ margin:0 0 2px; display:block; font-weight:bold; }
.purchaseorder-box .form-box{ margin-bottom:15px; }
.purchaseorder-box textarea{ height:110px; }
.purchaseorder-box .save-row{ padding:15px 0 0; clear: both; border-top:1px solid #e0e0e0; }
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
.delivery-address ul::-webkit-scrollbar-thumb { background:#888; border-radius: 10px; }
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
.tt-suggestion { font-size: 15px;  /* Set suggestion dropdown font size */ padding: 3px 10px; }
.tt-suggestion:hover { cursor: pointer; background-color: #0097CF; color: #FFFFFF; }
.tt-suggestion p { margin: 0; }
.dashboard .card { height: calc(100% - 90px); background:none;}
.table td, .table th { padding: 5px; vertical-align: top; border-top: 1px solid #e0e0e0; }
.two-button button{ float:left; border-radius:5px 0 0 5px; border-right:1px solid rgba(0, 0, 0, 0.1); padding:5px 15px !important; }
.two-button button + button{ border-radius:0 5px 5px 0; border-right:1px solid rgba(0, 0, 0, 0); outline:none; padding:5px 10px !important; }
.card-body{ background:#fff; -ms-flex: 1 1 auto; flex: 1 1 auto; padding: 1.429rem; }
.history-box{ margin-top:30px;  background:#fff; -ms-flex: 1 1 auto; flex: 1 1 auto; padding:0; }
.history-box h2{ font-size:15px; margin:0; padding:0 0 10px; border-bottom:1px solid #e0e0e0; }
.history-form{ padding:1.429rem; background:#fafbfb; display:none; }
.history-box.clicked .history-form{ display:block; }
.history-box.clicked .note-box{ display:none; }
.textarea-box{ padding:0 0 15px 0; }
.textarea-box textarea{ height:100px; }
.note-box{ padding:15px 0; }
.form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */  color:rgba(117, 117, 117, .5); }
.form-control::-moz-placeholder { /* Firefox 19+ */  color:rgba(117, 117, 117, .5); }
.form-control:-ms-input-placeholder { /* IE 10+ */  color:rgba(117, 117, 117, .5); }
.form-control:-moz-placeholder { /* Firefox 18- */  color:rgba(117, 117, 117, .5); }
table tr.text-fields-tr td{ padding:0; }
table tr.text-fields-tr td select.form-control,
table tr.text-fields-tr td input.form-control{ border:0 none; border-radius:0; padding-left:5px; padding-right:5px; }
table tr.text-fields-tr td select.form-control{ padding-right:16px; background-position: center right -10px; }
table tr.text-fields-tr td { vertical-align:middle; }
table tr.text-fields-tr td .blankspan{ display:inline-block; padding:0 5px; }
.table-striped tbody tr td,
.table-striped tbody tr:nth-of-type(2n+1) td{ background:#fff; }
</style>
<!-- Page -->
<div class="page">
  <div class="page-content container-fluid">
    <div class="row justify-content-md-center">
      <div class="col-md-12">
        <h2>Edit Purchase Order {{ 'PO-'.$purchase_data->order_number }}</h2>
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
                    <div class="contact-form bs-example">
                      <label for="contact">Vendor</label>
                      <input type="text" class="form-control typeahead" placeholder="Start Typing..." id="contact" autocomplete="off" name="contact" value="{{ $purchase_data->contact }}">
                    </div>
                    <div class="date-form datesmall">
                      <label for="date">Date</label>
                      <input type="input" value="{{ $purchase_data->date }}" class="form-control" autocomplete="off" id="date" name="date">
                    </div>
                    <div class="date-form datesmall">
                      <label for="delivery-date">Delivery Date</label>
                      <input type="input" class="form-control" id="delivary_date" autocomplete="off" value="{{ $purchase_data->delivery_date }}" name="delivery_date">
                    </div>
                    <div class="date-form">
                      <label for="reference">Reference</label>
                      <input type="input" id="reference" value="{{ $purchase_data->reference }}" autocomplete="off" class="form-control" name="reference">
                    </div>
                    <div class="date-form">
                      <label for="order-number">Order number</label>
                      <input type="input" id="order_number" readonly="" value="{{ 'PO-'.$purchase_data->order_number }}" class="form-control" name="order_number">
                    </div>
                  </div>
                  <hr />
                  <div class="search-form-box"> </div>
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
                        <th width="40">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody id="results">
                    
                    @for($i=1;$i<=count($purchase_data->row);$i++)
                    <tr id="data-row-{{ $i }}" class="text-fields-tr">
                      <td data-text="Item"><select required class="form-control width-full item" cus="{{$i}}" rel="item" id="tmp_id_item_{{$i}}" name="row[{{$i}}][item]">
                          <option value="">None</option>
					@foreach($items as $allitems)					
                          <option @if($allitems->_id==$purchase_data->row[$i]['item']) selected @endif value="{{ $allitems->_id }}">{{ $allitems->item_name }}</option>
					@endforeach
                    </select></td>
                      <td data-text="Item SKU" id="data-row-item-sku-{{ $i }}"> <span class="blankspan">{{ $purchase_data->row[$i]['item_sku'] }}</span> </td>
                      <input type="hidden" class="form-control width-full" value="{{ $purchase_data->row[$i]['item_sku'] }}" rel="item-sku" id="tmp_id_item_sku-{{$i}}" name="row[{{$i}}][item_sku]" />
                      <td data-text="Quantity"><input type="text" required min="1" autocomplete="off" class="form-control width-full quantity" cus="{{$i}}" value="{{ $purchase_data->row[$i]['quantity'] }}" rel="quantity" id="tmp_id_qty_{{$i}}" name="row[{{$i}}][quantity]" /></td>
                      <td data-text="Unit"><select required class="form-control width-full" rel="unit" id="tmp_id_unit_{{$i}}" name="row[{{$i}}][unit]">
                          <option @if($purchase_data->row[$i]['unit']=='Kg') selected @endif value="Kg">Kg</option>
                          <option @if($purchase_data->row[$i]['unit']=='Pc') selected @endif value="Pc">Pc</option>
                          <option @if($purchase_data->row[$i]['unit']=='Meter') selected @endif value="Meter">Meter</option>
                          <option @if($purchase_data->row[$i]['unit']=='Feet') selected @endif value="Feet">Feet</option>
                          <option @if($purchase_data->row[$i]['unit']=='Inches') selected @endif value="Inches">Inches</option>
                          <option @if($purchase_data->row[$i]['unit']=='Cms') selected @endif value="Cms">Cms</option>
                        </select></td>
                      <td data-text="Price"><input required type="text" autocomplete="off" min="1" class="form-control width-full price" value="{{ $purchase_data->row[$i]['price'] }}" cus="{{$i}}" rel="price" id="tmp_id_price_{{$i}}" name="row[{{$i}}][price]" /></td>
                      <td data-text="Disc %"><input type="text" min="1" autocomplete="off" maxlength="2" value="{{ $purchase_data->row[$i]['disc'] }}" class="form-control width-full disc" cus="{{$i}}" rel="disc" id="tmp_id_disc_{{$i}}" name="row[{{$i}}][disc]" /></td>
                      <td data-text="Amount INR" id="data-row-amount-{{ $i }}" class="amount" style="font-weight:bold;" align="right"><span class="blankspan">{{ $purchase_data->row[$i]['amount'] }}</span> </td>
                      <td data-text="GST %"><input type="text" min="1" readonly="" autocomplete="off" maxlength="3" value="{{ $purchase_data->row[$i]['gst'] }}" class="form-control width-full gst" rel="gst" cus="{{$i}}" id="tmp_id_gst_{{$i}}" name="row[{{$i}}][gst]" />
                        <input type="hidden" autocomplete="off" class="form-control width-full gst-amount" value="{{ @$purchase_data->row[$i]['gst_amount'] }}" rel="gst-amount" cus="{{$i}}" id="tmp_id_gst_amount_{{$i}}" name="row[{{$i}}][gst_amount]" /></td>
                      <input type="hidden" class="form-control width-full" value="{{ $purchase_data->row[$i]['amount'] }}" rel="amount" id="tmp_id_amount_{{$i}}" name="row[{{$i}}][amount]" />
                      <td><a href="javascript:void(0);" onclick="return removeRow({{ $i }});" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a></td>
                    </tr>
                    <input type="hidden" class="form-control width-full" value="{{ $purchase_data->order_number }}" rel="order_number"  name="row[{{$i}}][order_number]" />
                    <input type="hidden" class="form-control width-full" value="{{ $purchase_data->row[$i]['order'] }}" rel="order"  name="row[{{$i}}][order]" />
                    @endfor
                      </tbody>
                    
                  </table>
                </div>
                <div class="add-row">
                  <div class="add-left">
                    <div class="dropdown two-button">
                      <button type="button" class="btn btn-primary add-new-line" cus="1">+ Add a new line</button>
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> </button>
                      <div class="dropdown-menu"> <a class="dropdown-item add-new-line" cus="5" href="javascript:void(0);">Add 5</a> <a class="dropdown-item add-new-line" cus="10" href="javascript:void(0);">Add 10</a> <a class="dropdown-item add-new-line" cus="20" href="javascript:void(0);">Add 20</a> </div>
                    </div>
                  </div>
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
                      <input type="hidden" class="grandtotal" name="total" value="{{ $purchase_data->total }}" />
                      <input type="hidden" class="grandgsttotal" name="gst_total" value="{{ $purchase_data->gst_total }}" />
                      <input type="hidden" class="subtotal" name="subtotal" value="{{ $purchase_data->subtotal }}" />
                    </div>
                  </div>
                  <div class="row address-wrap">
                    <div class="col-md-12">
                      <div class="delivery-address"> <a href="javascript:void(0);">Delivery Address</a>
                        <div class="dropdown-box">
                          <ul>
                            <li class="link-tab add" id="0"><a href="javascript:void(0);">None</a></li>
                            <li class="link-tab add"><a href="{{ url('add-address') }}">Add Address</a></li>
                            @foreach($all_address as $address)
                            <li class="add" id="{{$address->_id}}">
                              <h2>{{$address->label}}</h2>
                              <p>{{$address->street_address}}
                                
                                {{$address->town_city}}<br/>
                                {{$address->state_region}}<br/>
                                {{$address->zip_code}}<br/>
                                {{$address->country}}</p>
                            </li>
                            @endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 address-bydefault">
                      <label id="add-label-html">{{$purchase_data->address['delivery_address_label']}}</label>
                      <p><span id="add-street-address-html">{{$purchase_data->address['delivery_address_street_address']}}</span> <span id="add-town-city-html">{{$purchase_data->address['delivery_address_town_city']}}</span><br/>
                        <span id="add-state-region-html">{{$purchase_data->address['delivery_address_state_region']}}</span><br/>
                        <span id="add-zip-code-html">{{$purchase_data->address['delivery_address_zip_code']}}</span><br/>
                        <span id="add-country-html">{{$purchase_data->address['delivery_address_country']}}</span></p>
                      <input type="hidden" id="delivery_address_label" name="address[delivery_address_label]" value="{{$purchase_data->address['delivery_address_label']}}" class="form-control">
                      <input type="hidden" id="delivery_address_street_address" name="address[delivery_address_street_address]" value="{{$purchase_data->address['delivery_address_street_address']}}" class="form-control">
                      <input type="hidden" id="delivery_address_town_city" name="address[delivery_address_town_city]" value="{{$purchase_data->address['delivery_address_town_city']}}" class="form-control">
                      <input type="hidden" id="delivery_address_state_region" name="address[delivery_address_state_region]" value="{{$purchase_data->address['delivery_address_state_region']}}" class="form-control">
                      <input type="hidden" id="delivery_address_zip_code" name="address[delivery_address_zip_code]" value="{{$purchase_data->address['delivery_address_zip_code']}}" class="form-control">
                      <input type="hidden" id="delivery_address_country" name="address[delivery_address_country]" value="{{$purchase_data->address['delivery_address_country']}}" class="form-control">
                    </div>
                    <div class="col-md-3 address-select" style="display:none;">
                      <label>Address</label>
                      <textarea name="address[new_delivery_address]" style="height:112px;" class="form-control">{{$purchase_data->address['new_delivery_address']}}</textarea>
                    </div>
                    <div class="col-md-3">
                      <div class="form-box">
                        <label>Kind Attention</label>
                        <input type="text" id="attention" autocomplete="off" name="address[attention]" placeholder="Mr./Ms." value="{{$purchase_data->address['attention']}}" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label>Delivery Instructions</label>
                      <textarea name="address[instruction]" id="instruction" class="form-control">{{stripslashes($purchase_data->address['instruction'])}}</textarea>
                    </div>
                  </div>
                </div>
                
                <!--<div class="history-box">
		  <h2>History & Notes</h2>
		  <div class="note-box"><a href="javascript:void(0)" class="btn btn-primary">Add a note</a></div>
		  
		  <div class="history-form">
		  <div class="row">
		  <div class="col-md-6">
		  <div class="textarea-box">
		  <label>Note</label>
		  <textarea name="history_note" class="form-control">{{stripslashes($purchase_data->history_note)}}</textarea>
		  </div>
		  <div class="btn-box">
		  <a href="javascript:void(0)" class="btn btn-primary" style="display:none;">Save</a> <a href="javascript:void(0)" class="btn btn-secondary cancel-btn">Cancel</a>
		  </div>
		  </div>
		  </div>
		  </div>
		  </div>-->
                
                <div class="save-row"> @if($purchase_data->status==0)
                  <div class="save-left float-left">
                    <button type="submit" name="save" value="save" class="btn btn-primary">Save as draft</button>
                    @endif
                    
                    @if($purchase_data->status==2 || $purchase_data->status==0)
                    <button type="submit" name="awaiting" value="save" class="btn btn-primary">Save & submit for approval</button>
                    @endif </div>
                  <div class="save-right float-right">
                    <button type="submit" name="approve" value="approve" class="btn btn-success">Approve</button>
                    <a href="{{ url('purchase-order-listing') }}"  class="btn btn-secondary">Cancel</a> </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
{!!Html::script('assets/js/jquery-ui_datepicker.js')!!}
	{!!Html::style('assets/css/jquery-ui_datepicker.css')!!} 
<!--<script type="text/javascript">
  $( function() {
    $( "#date" ).datepicker({dateFormat: 'dd M yy'});
	$( "#delivary_date" ).datepicker({dateFormat: 'dd M yy'});
  } );
  </script>--> 
{!!Html::script('global/vendor/editable-table/mindmup-editabletable.js')!!}
  {!!Html::script('global/js/Plugin/editable-table.js')!!}
  {!!Html::script('assets/examples/js/tables/editable.js')!!} 
<script>
$(function(){
$('.typeahead').on('typeahead:selected', function(evt, item) {
var typeahead_val = $(this).val();
   if(typeahead_val!=''){
   $(":input:not([name=contact])").prop("disabled", false);
    $.ajax({
			type: "GET",
			url: "{{ url('ajaxTypeheadData')}}/"+typeahead_val,
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
<script>
$(function(){
$(document).on('keyup','.typeahead', function() {
var typeahead_val = $(this).val();
   if(typeahead_val!=''){
    $.ajax({
			type: "GET",
			url: "{{ url('ajaxTypeheadData')}}/"+typeahead_val,
			data: {typeahead_val:typeahead_val},
			success: function(msg){
			//alert(msg); return false;
			if(msg!='')
			{
			 $('.item').html(msg);
			 $(":input:not([name=contact])").prop("disabled", false);
			}else{
			
			$(":input:not([name=contact])").prop("disabled", true);
			}
			}
			});
   }else{
   $(":input:not([name=contact])").prop("disabled", true);
   }
});
});
</script> 
<script>
  function removeRow(row){
    if(row!=1){
    $('#data-row-'+row).remove();
		var subTotal = 0;
		$(".amount").each(function () {
		var stval = parseFloat($(this).text());
		subTotal += isNaN(stval) ? 0 : stval;
		});
		var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
	}
  }
  </script> 
<script>
  $(function(){
     $(document).on('change','.item',function(){
	      var id = $(this).attr('cus');
		  var item_val = $('#tmp_id_item_'+id).val();
		  if(item_val!='')
		  {
			$.ajax({
			type: "GET",
			url: "{{ url('ajaxItemData')}}/"+item_val,
			data: {item_val:item_val},
			success: function(msg){
			data = JSON.parse(msg);
            //alert(data['id']); return false;
			$('#data-row-item-sku-'+id).html('<span class="blankspan">'+data['item_sku']+'</span>');
			$('#tmp_id_item_sku-'+id).val(data['item_sku']);
			$('#tmp_id_desc_'+id).val(data['description']);
			$("#tmp_id_unit_"+id+" option:selected" ).text(data['unit']);
			$('#tmp_id_qty_'+id).val('');
			$('#tmp_id_price_'+id).val(data['price']);
			$('#tmp_id_gst_'+id).val(data['gst']);
			$('#data-row-amount-'+id).html('<span class="blankspan">'+eval(0*data['price']).toFixed(2)+'</span>');
			
			$('#tmp_id_amount_'+id).val(eval(0*data['price']).toFixed(2));
			var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
			}
			});
		  }else{
		   $('#data-row-item-sku-'+id).html('');
		   $('#tmp_id_item_sku-'+id).val('');
			$('#tmp_id_desc_'+id).val('');
			$("#tmp_id_unit_"+id+" option:selected" ).text('');
			$('#tmp_id_qty_'+id).val('');
			$('#tmp_id_price_'+id).val('');
			$('#tmp_id_gst_'+id).val('');
			$('#data-row-amount-'+id).html('');
			$('#data-row-amount-'+id).val('');
		    var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
		  }
	 });
  });
  </script> 
<script>
  $(function(){
     $(document).on('keyup mouseup','.quantity',function(){
	      var id = $(this).attr('cus');
		  var qty_val = $('#tmp_id_qty_'+id).val();
		  var price_val = $('#tmp_id_price_'+id).val();
		  var gst_val = $('#tmp_id_gst_'+id).val();
		  var disc_val = $('#tmp_id_disc_'+id).val();
		  if(qty_val!='')
		  {
			$('#data-row-amount-'+id).html('<span class="blankspan">'+eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2)+'</span>');
			$('#tmp_id_amount_'+id).val(eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2));
			$('#tmp_id_gst_amount_'+id).val(eval((((qty_val*price_val)-(qty_val*price_val*disc_val/100))*gst_val)/100).toFixed(2));
			var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
			}
	 });
  });
  </script> 
<script>
  $(function(){
     $(document).on('keyup mouseup','.price',function(){
	      var id = $(this).attr('cus');
		  var qty_val = $('#tmp_id_qty_'+id).val();
		  var price_val = $('#tmp_id_price_'+id).val();
		  var gst_val = $('#tmp_id_gst_'+id).val();
		  var disc_val = $('#tmp_id_disc_'+id).val();
		  if(qty_val!='')
		  {
			$('#data-row-amount-'+id).html('<span class="blankspan">'+eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2)+'</span>');
			$('#tmp_id_amount_'+id).val(eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2));
			$('#tmp_id_gst_amount_'+id).val(eval((((qty_val*price_val)-(qty_val*price_val*disc_val/100))*gst_val)/100).toFixed(2));
			var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
			}
	 });
  });
  </script> 
<script>
  $(function(){
     $(document).on('keyup mouseup','.gst',function(){
	      var id = $(this).attr('cus');
		  var qty_val = $('#tmp_id_qty_'+id).val();
		  var price_val = $('#tmp_id_price_'+id).val();
		  var gst_val = $('#tmp_id_gst_'+id).val();
		  var disc_val = $('#tmp_id_disc_'+id).val();
		  if(qty_val!='')
		  {
			$('#data-row-amount-'+id).html('<span class="blankspan">'+eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2)+'</span>');
			$('#tmp_id_amount_'+id).val(eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2));
			$('#tmp_id_gst_amount_'+id).val(eval((((qty_val*price_val)-(qty_val*price_val*disc_val/100))*gst_val)/100).toFixed(2));
			var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
			}
	 });
  });
  </script> 
<script>
  $(function(){
     $(document).on('keyup mouseup','.disc',function(){
	      var id = $(this).attr('cus');
		  var qty_val = $('#tmp_id_qty_'+id).val();
		  var price_val = $('#tmp_id_price_'+id).val();
		  var gst_val = $('#tmp_id_gst_'+id).val();
		  var disc_val = $('#tmp_id_disc_'+id).val();
		  if(qty_val!='')
		  {
			$('#data-row-amount-'+id).html('<span class="blankspan">'+eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2)+'</span>');
			$('#tmp_id_amount_'+id).val(eval((qty_val*price_val)-(qty_val*price_val*disc_val/100)).toFixed(2));
			$('#tmp_id_gst_amount_'+id).val(eval((((qty_val*price_val)-(qty_val*price_val*disc_val/100))*gst_val)/100).toFixed(2));
			var subTotal = 0;
			$(".amount").each(function () {
			var stval = parseFloat($(this).text());
			subTotal += isNaN(stval) ? 0 : stval;
			});
			var gstTotal = 0;
			$(".gst-amount").each(function () {
			var gtval = parseFloat($(this).val());
			gstTotal += isNaN(gtval) ? 0 : gtval;
			});
			 //alert(subTotal);
			$('#subtotal').html(subTotal.toFixed(2));
			$('.subtotal').val(subTotal.toFixed(2));
			$('#gst-total').html(gstTotal.toFixed(2));
			$('#grandtotal').html(eval(gstTotal+subTotal).toFixed(2));
			$('.grandgsttotal').val(eval(gstTotal+subTotal).toFixed(2));
			$('.grandtotal').val(eval(gstTotal+subTotal).toFixed(2));
			}
	 });
  });
  </script> 
<script>
  $(function(){
     $(document).on('click','.add-new-line',function(){
	 var count_of_row = $(this).attr('cus');
	 var rowCount = $('#editableTable1 >tbody >tr').length;
	 for(var i = 1; i <= count_of_row; i++) {
	 rowCount++;
	    var html = '<tr id="data-row-'+rowCount+'" class="text-fields-tr"><td data-text="Item"><select required class="form-control width-full item" cus="'+rowCount+'" rel="item" id="tmp_id_item_'+rowCount+'" name="row['+rowCount+'][item]"><option value="">None</option>@foreach($items as $allitems)<option value="{{ $allitems->_id }}">{{ $allitems->item_name }}</option>@endforeach</select></td><td data-text="Item SKU" id="data-row-item-sku-'+rowCount+'"><span class="blankspan"></span></td><input type="hidden" class="form-control width-full" rel="item-sku" id="tmp_id_item_sku-'+rowCount+'" name="row['+rowCount+'][item_sku]" /><td data-text="Quantity"><input autocomplete="off" type="text" min="1" required class="form-control width-full quantity" cus="'+rowCount+'" rel="quantity" id="tmp_id_qty_'+rowCount+'" name="row['+rowCount+'][quantity]" /></td><td data-text="Unit"><select required class="form-control width-full" rel="unit" id="tmp_id_unit_'+rowCount+'" name="row['+rowCount+'][unit]"><option value="Kg">Kg</option><option value="Pc">Pc</option><option value="Meter">Meter</option><option value="Feet">Feet</option><option value="Inches">Inches</option><option value="Cms">Cms</option></select></td><td data-text="Price"><input autocomplete="off" type="text" min="1" required class="form-control width-full price" cus="'+rowCount+'" rel="price" id="tmp_id_price_'+rowCount+'" name="row['+rowCount+'][price]" /></td><td data-text="Disc %"><input type="text" min="1" maxlength="2" autocomplete="off" class="form-control width-full disc" cus="'+rowCount+'" rel="disc" id="tmp_id_disc_'+rowCount+'" name="row['+rowCount+'][disc]" /></td><td data-text="Amount INR" id="data-row-amount-'+rowCount+'" class="amount" style="font-weight:bold;" align="right"><span class="blankspan"></span></td><input type="hidden" class="form-control width-full" rel="amount" id="tmp_id_amount_'+rowCount+'" name="row['+rowCount+'][amount]" /><td data-text="GST %"><input autocomplete="off" type="text" min="1" maxlength="3" class="form-control width-full gst" rel="gst" cus="'+rowCount+'" id="tmp_id_gst_'+rowCount+'" name="row['+rowCount+'][gst]" /><input type="hidden" autocomplete="off" class="form-control width-full gst-amount" value="" rel="gst-amount" cus="'+rowCount+'" readonly id="tmp_id_gst_amount_'+rowCount+'" name="row['+rowCount+'][gst_amount]" /></td><td><a href="javascript:void(0);" onclick="return removeRow('+rowCount+');" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a></td></tr><input type="hidden" class="form-control width-full" value="{{ $purchase_data->order_number }}" rel="order_number"  name="row['+rowCount+'][order_number]" /><input type="hidden" class="form-control width-full" value="'+rowCount+'" rel="order"  name="row['+rowCount+'][order]" />';
	     $('#results').append(html);
		 var typeahead_val = $('input.typeahead.tt-input').val();
		if(typeahead_val!=''){
		selectOption(typeahead_val,rowCount);
		}
		 }
	 });
	 
	 $(".delivery-address a").click(function(){
	 $(this).parent().toggleClass("clicked");
	 });
	 
	 $(".note-box a, a.cancel-btn").click(function(){
	 $(".history-box").toggleClass("clicked");
	 });
  });
  </script> 
<script>
  function selectOption(typeahead_val,rowCount)
  {
	$.ajax({
	type: "GET",
	url: "{{ url('ajaxTypeheadData')}}/"+typeahead_val,
	data: {typeahead_val:typeahead_val},
	success: function(msg){
	if(msg!='')
	{
	$('#tmp_id_item_'+rowCount).html(msg);
	}
	}
	});
  }
  </script> 
<script>
  function validate(){
   var contact = $('#contact').val();
   if(contact==''){
   $('#contact').addClass('border-danger');
   return false;
   }
   var delivary_date = $('#delivary_date').val();
   if(delivary_date==''){
   $('#delivary_date').addClass('border-danger');
   return false;
   }
    var order_number = $('#order_number').val();
   if(order_number==''){
   $('#order_number').addClass('border-danger');
   return false;
   }
   
  }
  </script> 
<script>
  $(function(){
     $(document).on('click','.add',function(){
	    var id = $(this).attr('id');
		$('.delivery-address').removeClass("clicked");
		if(id==0){
		 $('.address-bydefault').hide();
		 $('.address-select').show();
		 $('#attention').val('');
		 $('#telephone').val('');
		 $('#instruction').val('');
		}else if(id!=0 && id!=''){
		 $('.address-bydefault').show();
		 $('.address-select').hide();
		 $.ajax({
			type: "GET",
			url: "{{ url('ajaxAddressData')}}/"+id,
			data: {id:id},
			success: function(msg){
			data = JSON.parse(msg);
            //alert(data['id']); return false;
			$('#add-label-html').html(data['label']);
			$('#delivery_address_label').val(data['label']);
			$('#add-street-address-html').html(data['street_address']);
			$('#delivery_address_street_address').val(data['street_address']);
			$('#add-town-city-html').html(data['town_city']);
			$('#delivery_address_town_city').val(data['town_city']);
			$('#add-state-region-html').html(data['state_region']);
			$('#delivery_address_state_region').val(data['state_region']);
			$('#add-zip-code-html').html(data['zip_code']);
			$('#delivery_address_zip_code').val(data['zip_code']);
			$('#add-country-html').html(data['country']);
			$('#delivery_address_country').val(data['country']);
			$('#attention').val(data['attention']);
			$('#telephone').val(data['tel_country']+' '+data['tel_area']+' '+data['tel_number']);
			$('#instruction').val('');
			}
			});
		}
	 });
  });
  
  </script> 
<script>
	$(document).ready(function () {
	$("#date").datepicker({
	dateFormat: "dd M yy",
	/*minDate: 0,*/
	onSelect: function (date) {
	var date2 = $('#date').datepicker('getDate');
	date2.setDate(date2.getDate() + 1);
	//$('#delivary_date').datepicker('setDate', date2);
	//sets minDate to dt1 date + 1
	$('#delivary_date').datepicker('option', 'minDate', date2);
	}
	});
	$('#delivary_date').datepicker({
	dateFormat: "dd M yy",
	minDate: 1,
	onClose: function () {
	var dt1 = $('#date').datepicker('getDate');
	var dt2 = $('#delivary_date').datepicker('getDate');
	if (dt2 <= dt1) {
	var minDate = $('#delivary_date').datepicker('option', 'minDate');
	$('#delivary_date').datepicker('setDate', minDate);
	}
	}
	});
	});
	</script> 
@stop