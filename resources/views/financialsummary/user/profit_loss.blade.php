@extends('financialsummary.layouts.fms_admin_layouts')
@section('pageTitle', 'Dashboard')
@section('pagecontent')
@php
error_reporting(0);
setlocale(LC_MONETARY, 'en_IN');
@endphp
<style>
table.table td { line-height: 0px; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
$(window).on('load',function(e) { 
var msg = '<?php echo getProfitDropdown('all_profit', Auth::user()->id);?>';
$('#dropdown-ajax').html(msg);	
}); 
</script>
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
    <form action="{{ url('financialsummary/dataSubmitProfileLoss') }}" name="financial_summery" id="financial_summery" method="post">
      @csrf
      <div class="table-scrollable">
        <table cellspacing="0" id="table-basic" class="table table-sm table-bordered table-striped fixed_table hover-edit">
          <thead>
            <tr class="task_top_fix htf1">
              <th class="heading-tab" rowspan="2">FINANCIAL SUMMARY</th>
              <th colspan="14" class="nav-tab"> @include('financialsummary.layouts.tabbing') </th>
            <tr class="task_top_fix htf2"> @foreach(getMonths() as $months)
              <th bgcolor="#000000" style="color:#FFFFFF;">{{ $months }}</th>
              @endforeach </tr>
          </thead>
          <tbody>
          
          @foreach(getProfitDropdownPage() as $key=>$centersData)
          <tr class="blue-box @if($key!=0) data-t @endif">
            <th bgcolor="#4285f4"  @if($key==0) id="dropdown-ajax"  @endif> </th>
            <td colspan="12" bgcolor="#4285f4" style="color:#FFFFFF;"><strong @if($key==0) class="first-center" @endif>{{ $centersData['company_name'] }}</strong>
              <input type="hidden" @if($key==0) class="first-center-name" @endif id="c-{{ $centersData['_id'] }}" value="{{ $centersData['company_name'] }}" /></td>
          </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Revenue</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetRevenue($monthsdata,$centersData['_id'])) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Variable Expenses</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetVariableExpenses($monthsdata,$centersData['_id'])) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Closing Stock</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetClosingStock($monthsdata,$centersData['_id'])) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Gross Profit</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',GrossProfit(NetRevenue($monthsdata,$centersData['_id']), NetVariableExpenses($monthsdata,$centersData['_id']), NetClosingStock($monthsdata,$centersData['_id']))) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Gross Profit %</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',GrossProfitPercentage(GrossProfit(NetRevenue($monthsdata,$centersData['_id']), NetVariableExpenses($monthsdata,$centersData['_id']), NetClosingStock($monthsdata,$centersData['_id'])), NetRevenue($monthsdata,$centersData['_id']))) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Fixed Cost</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetFixedCost($monthsdata,$centersData['_id'])) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Profit</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetProfit(GrossProfit(NetRevenue($monthsdata,$centersData['_id']), NetVariableExpenses($monthsdata,$centersData['_id']), NetClosingStock($monthsdata,$centersData['_id'])), NetFixedCost($monthsdata,$centersData['_id']))) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Net Profit Margin %</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',NetProfitMargin(NetFixedCost($monthsdata,$centersData['_id']), NetRevenue($monthsdata,$centersData['_id']))) }}</td>
            @endforeach </tr>
          <tr class="{{ $centersData['_id'] }} data-t">
            <th><strong>Break Even Point</strong></th>
            @foreach(getMonthsData() as $monthsdata)
            <td align="center">{{ money_format('%!i',BreakEvenPoint(NetFixedCost($monthsdata,$centersData['_id']), GrossProfitPercentage(GrossProfit(NetRevenue($monthsdata,$centersData['_id']), NetVariableExpenses($monthsdata,$centersData['_id']), NetClosingStock($monthsdata,$centersData['_id'])), NetRevenue($monthsdata,$centersData['_id'])))) }}</td>
            @endforeach </tr>
          @endforeach
            </tbody>
          
        </table>
      </div>
    </form>
  </div>
  <div id="loader" style="display:none; text-align:center;"><!--<img src="{{ url('public/theme/assets/images/loading.gif') }}" style="width: 150px; height: auto; position: absolute; top: 50%; left: 50%; margin: -75px -76px;" />-->
  <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
  </div>
  <div class="container-fluid">
    <div class="row">
     @foreach(getProfitDropdownPage() as $key=>$centersData)
      <div class="col-md-6 graph-div graph-{{ $centersData['_id'] }}" style="display:none">
        <div class="graphbox" style="color:#f7f7f7; margin-top:20px;">
          <div id="chartContainer-{{ $centersData['_id'] }}" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6 graph-div graph-{{ $centersData['_id'] }}" style="display:none">
        <div class="graphbox" style="color:#f7f7f7; margin-top:20px;">
          <div id="chartContainer_netVariableExpenses-{{ $centersData['_id'] }}" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6 graph-div graph-{{ $centersData['_id'] }}" style="display:none">
        <div class="graphbox" style="color:#f7f7f7; margin-top:20px;">
          <div id="chartContainer_NetFixedCost-{{ $centersData['_id'] }}" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6 graph-div graph-{{ $centersData['_id'] }}" style="display:none">
        <div class="graphbox" style="color:#f7f7f7; margin-top:20px;">
          <div id="chartContainer_Gross_Profit-{{ $centersData['_id'] }}" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      <div class="col-md-6 graph-div graph-{{ $centersData['_id'] }}" style="display:none">
        <div class="graphbox" style="color:#f7f7f7; margin-top:20px;">
          <div id="chartContainer_Net_Profit-{{ $centersData['_id'] }}" style="height: 300px; width: 100%;"></div>
        </div>
      </div>
      @endforeach
      </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");

$("table.table.fixed_table tr .task_left_fix").each(function() {
 var x = $(this).offset();
 $(this).css({ "left": x.left - 0 + "px"});
});

/*$("table.table.fixed_table tr.task_top_fix th").each(function() {
 var y = $(this).offset();
 $(this).css({ "top": y.top - 0 + "px"});
});*/

$("table.table.fixed_table tr.htf1 th").each(function() {
 var y = $(this).offset();
 $(this).css({ "top": 0 + "px"});
});

$("table.table.fixed_table tr.htf2 th").each(function() {
 var y = $(this).offset();
 $(this).css({ "top": 38 + "px"});
});

});
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.amt-revenue').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
	 var tot_revenue = sum;
     $('#tot-revenue').html(tot_revenue.toLocaleString('en-IN')+'.00');
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.amt-net-variable-exp').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
	 var tot_revenue = sum;
     $('#amt-net-variable-exp').html(tot_revenue.toLocaleString('en-IN')+'.00');
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.amt-net-fixed-cost').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
	 var tot_revenue = sum;
     $('#amt-net-fixed-cost').html(tot_revenue.toLocaleString('en-IN')+'.00');
 });
</script> 
<script>
$(function(){
     $(document).on('click','#all-profit',function(){
	      if($(this).is(':checked')){
		    var all_profit_loss = 1;
			$.ajax({
			type: "GET",
			url: "{{ url('financialsummary/ajaxAllProfitLossUpdate')}}/"+all_profit_loss,
			data: {all_profit_loss:all_profit_loss},
			success: function(msg){
			//alert(msg); return false;
			if(msg==1)
			{
			$('#all-profit-loss').show();
			}
			}
			});
		  }else{
		  var all_profit_loss = 0;
		  $.ajax({
			type: "GET",
			url: "{{ url('financialsummary/ajaxAllProfitLossUpdate')}}/"+all_profit_loss,
			data: {all_profit_loss:all_profit_loss},
			success: function(msg){
			//alert(msg); return false;
			if(msg==1)
			{
			$('#all-profit-loss').hide();
			}
			}
			});
		  }
	 });
});
</script>
<style type="text/css">
.page-content{ padding:0; }
table.table.fixed_table tr.blue-box th, table.table.fixed_table tr.blue-box td{ text-align: center; }
.canvasjs-chart-credit{display:none !important;}
</style>
@endsection 