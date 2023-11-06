@extends('layouts.fms_admin_layouts')
@section('pageTitle', 'Dashboard')
@section('pagecontent')
@php
error_reporting(0);
setlocale(LC_MONETARY, 'en_IN');
@endphp
<style>
table.table td {
   line-height: 0px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="page creat-fms-box1">
	<div class="page-content container-fluid1">
	
<form action="{{ url('admin/dataSubmitProfileLoss') }}" name="financial_summery" id="financial_summery" method="post">
@csrf
  <div class="table-scrollable">
    <table cellspacing="0" id="table-basic" class="table table-sm table-bordered table-striped fixed_table hover-edit">
          <thead>
          <tr class="task_top_fix htf1">
              <th class="heading-tab" rowspan="2">FINANCIAL SUMMARY</th>
              <th colspan="14" class="nav-tab"> 
				@include('layouts.tabbing')
	        </th>
            <tr class="task_top_fix htf2">              
              @foreach(getMonths() as $months)
              <th bgcolor="#000000" style="color:#FFFFFF;">{{ $months }}</th>
              @endforeach </tr>
      </thead>
      <tbody>
        <tr class="blue-box">
          <th bgcolor="#4285f4">&nbsp;</th>
          @foreach(getMonths() as $months)
          <td bgcolor="#4285f4">&nbsp;</td>
		  @endforeach
        </tr>
		
		 
		<tr>
		<th><strong>Net Revenue</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetRevenue($monthsdata)) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Net Variable Expenses</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetVariableExpenses($monthsdata)) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Net Closing Stock</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetClosingStock($monthsdata)) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Gross Profit</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllGrossProfit(getAllNetRevenue($monthsdata), getAllNetVariableExpenses($monthsdata), getAllNetClosingStock($monthsdata))) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Gross Profit %</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllGrossProfitPercentage(getAllGrossProfit(getAllNetRevenue($monthsdata), getAllNetVariableExpenses($monthsdata), getAllNetClosingStock($monthsdata)), getAllNetRevenue($monthsdata))) }}</td>
		@endforeach

		</tr>
		
		<tr>
		<th><strong>Net Fixed Cost</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetFixedCost($monthsdata)) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Net Profit</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetProfit(getAllGrossProfit(getAllNetRevenue($monthsdata), getAllNetVariableExpenses($monthsdata), getAllNetClosingStock($monthsdata)), getAllNetFixedCost($monthsdata))) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Net Profit Margin %</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllNetProfitMargin(getAllNetFixedCost($monthsdata), getAllNetRevenue($monthsdata))) }}</td>
		@endforeach
		</tr>
		
		<tr>
		<th><strong>Break Even Point</strong></th>
		@foreach(getMonthsData() as $monthsdata)
		<td align="center">{{ money_format('%!i',getAllBreakEvenPoint(getAllNetFixedCost($monthsdata), getAllGrossProfitPercentage(getAllGrossProfit(getAllNetRevenue($monthsdata), getAllNetVariableExpenses($monthsdata), getAllNetClosingStock($monthsdata)), getAllNetRevenue($monthsdata)))) }}</td>
		@endforeach
		</tr>
		
       
      </tbody>
    </table>
	
  </div>
  
  </form>
	</div>
	<div class="container-fluid graph-div">
	<div class="row" style="color:#f7f7f7; margin-top:20px;">
	<div id="getAllchartContainer" style="height: 300px; width: 100%;"></div>
	</div>
	</div>
	
	<hr />
	
	<div class="container-fluid graph-div">
	<div class="row" style="color:#f7f7f7; margin-top:20px;">
	<div id="getAllchartContainer_netVariableExpenses" style="height: 300px; width: 100%;"></div>
	</div>
	</div>
	
	
	<hr />
	
	<div class="container-fluid graph-div">
	<div class="row" style="color:#f7f7f7; margin-top:20px;">
	<div id="getAllchartContainer_NetFixedCost" style="height: 300px; width: 100%;"></div>
	</div>
	</div>
	
	<hr />
	
	
	<div class="container-fluid graph-div">
	<div class="row" style="color:#f7f7f7; margin-top:20px;">
	<div id="getAllchartContainer_Gross_Profit" style="height: 300px; width: 100%;"></div>
	</div>
	</div>
	
	<hr />
	
	<div class="container-fluid graph-div">
	<div class="row" style="color:#f7f7f7; margin-top:20px;">
	<div id="getAllchartContainer_Net_Profit" style="height: 300px; width: 100%;"></div>
	</div>
	</div>
	
	<hr />
	
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

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

<style type="text/css">
.page-content{ padding:0; }
table.table.fixed_table tr.blue-box th, table.table.fixed_table tr.blue-box td{ text-align: center; }
.canvasjs-chart-credit{display:none !important;}
</style>


@endsection
