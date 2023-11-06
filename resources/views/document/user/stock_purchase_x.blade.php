@extends('layouts.fms_admin_layouts')
@section('pageTitle', 'Dashboard')
@section('pagecontent')
@php
error_reporting(0);
@endphp
<style>
table.table td { line-height: 0px; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
    <form action="{{ url('admin/dataSubmit') }}" name="financial_summery" id="financial_summery" method="post">
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
            <tr class="blue-box">
              <th style="text-align:center; font-weight:bold;"><span class="co-name">CLOSING STOCK</span> <span class="co-name" style="float:right;"><a class="add-opening-stock" href="javascript:void(0);"><i class="fa fa-plus-circle" style="color:#006600; font-size:20px; float:right;" aria-hidden="true"></i></a></span></th>
              @foreach(getMonths() as $months)
              <td>&nbsp;</td>
              @endforeach </tr>
          @php
          
          $i=0;
          
          @endphp
          
          @foreach($opening_stock as $key1=>$opening_stock)
          <tr class="opening_stock" id="remove-{{$i}}">
            <th class="hidden_th a-fa-click" id="a-{{$i}}"><div class="product"> <span class="sp-a-{{$i}}">{{ @$opening_stock['name'] }}</span>
			  <select cus="a-{{$i}}" id="{{ @$opening_stock['_id'] }}" class="a-{{$i}} e-{{$i}} attribute" autocomplete="off" name="row[{{ $i }}][name]" style="display:none;">
		  @foreach($opening_stock_select as $opening_stock_dropdown)
		  <option @if(@$opening_stock['name']==@$opening_stock_dropdown['name']) selected="selected" @endif value="{{ @$opening_stock_dropdown['name'] }}">{{ @$opening_stock_dropdown['name'] }}</option>
		  @endforeach
		  </select>
              &nbsp;<a style="display:none; padding:0px 0px !important;" id="a-{{$i}}" class="fa-submit-attribute fa-check-a-{{$i}}" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove" cus="{{$i}}" id="{{ @$opening_stock['_id'] }}" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th>
            <input value="{{ @$opening_stock['_id'] }}" id="h-a-{{$i}}" type="hidden" name="row[{{ $i }}][id]" />
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-03_2020" align="center"><span id="s-exp-amt-{{$i}}-03_2020" class="r-exp-amt-{{$i}}-02_2020">{{ @$opening_stock['03_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e1 number exp-amt-{{$i}}-03_2020 03_2020 r-exp-amt-{{$i}}-02_2020" value="{{ @$opening_stock['03_2020'] }}" name="row[{{ $i }}][03_2020]" cus="exp-amt-{{$i}}-03_2020" id="03_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-03_2020" class="fa-submit fa-check-exp-amt-{{$i}}-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-02_2020" align="center"><span id="s-exp-amt-{{$i}}-02_2020" class="r-exp-amt-{{$i}}-01_2020">{{ @$opening_stock['02_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e2 number exp-amt-{{$i}}-02_2020 02_2020 r-exp-amt-{{$i}}-01_2020" value="{{ @$opening_stock['02_2020'] }}" name="row[{{ $i }}][02_2020]" cus="exp-amt-{{$i}}-02_2020" id="02_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-02_2020" class="fa-submit fa-check-exp-amt-{{$i}}-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-01_2020" align="center"><span id="s-exp-amt-{{$i}}-01_2020" class="r-exp-amt-{{$i}}-12_2019">{{ @$opening_stock['01_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e3 number exp-amt-{{ $i }}-01_2020 01_2020 r-exp-amt-{{$i}}-12_2019" value="{{ @$opening_stock['01_2020'] }}" name="row[{{ $i }}][01_2020]" cus="exp-amt-{{$i}}-01_2020" id="01_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-01_2020" class="fa-submit fa-check-exp-amt-{{$i}}-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-12_2019" align="center"><span id="s-exp-amt-{{$i}}-12_2019" class="r-exp-amt-{{$i}}-11_2019">{{ @$opening_stock['12_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e4 number exp-amt-{{ $i }}-12_2019 12_2019 r-exp-amt-{{$i}}-11_2019" value="{{ @$opening_stock['12_2019'] }}" name="row[{{ $i }}][12_2019]" cus="exp-amt-{{$i}}-12_2019" id="12_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-12_2019" class="fa-submit fa-check-exp-amt-{{$i}}-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-11_2019" align="center"><span id="s-exp-amt-{{$i}}-11_2019" class="r-exp-amt-{{$i}}-10_2019">{{ @$opening_stock['11_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e5 number exp-amt-{{ $i }}-11_2019 11_2019 r-exp-amt-{{$i}}-10_2019" value="{{ @$opening_stock['11_2019'] }}" name="row[{{ $i }}][11_2019]"  cus="exp-amt-{{$i}}-11_2019" id="11_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-11_2019" class="fa-submit fa-check-exp-amt-{{$i}}-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-10_2019" align="center"><span id="s-exp-amt-{{$i}}-10_2019" class="r-exp-amt-{{$i}}-09_2019">{{ @$opening_stock['10_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e6 number exp-amt-{{ $i }}-10_2019 10_2019 r-exp-amt-{{$i}}-09_2019" value="{{ @$opening_stock['10_2019'] }}" name="row[{{ $i }}][10_2019]" cus="exp-amt-{{$i}}-10_2019" id="10_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-10_2019" class="fa-submit fa-check-exp-amt-{{$i}}-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-09_2019" align="center"><span id="s-exp-amt-{{$i}}-09_2019" class="r-exp-amt-{{$i}}-08_2019">{{ @$opening_stock['09_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e7 number exp-amt-{{ $i }}-09_2019 09_2019 r-exp-amt-{{$i}}-08_2019" value="{{ @$opening_stock['09_2019'] }}" name="row[{{ $i }}][09_2019]" cus="exp-amt-{{$i}}-09_2019" id="09_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-09_2019" class="fa-submit fa-check-exp-amt-{{$i}}-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-08_2019" align="center"><span id="s-exp-amt-{{$i}}-08_2019" class="r-exp-amt-{{$i}}-07_2019">{{ @$opening_stock['08_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e8 number exp-amt-{{ $i }}-08_2019 08_2019 r-exp-amt-{{$i}}-07_2019" value="{{ @$opening_stock['08_2019'] }}" name="row[{{ $i }}][08_2019]" cus="exp-amt-{{$i}}-08_2019" id="08_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-08_2019" class="fa-submit fa-check-exp-amt-{{$i}}-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-07_2019" align="center"><span id="s-exp-amt-{{$i}}-07_2019" class="r-exp-amt-{{$i}}-06_2019">{{ @$opening_stock['07_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e9 number exp-amt-{{ $i }}-07_2019 07_2019 r-exp-amt-{{$i}}-06_2019" value="{{ @$opening_stock['07_2019'] }}" name="row[{{ $i }}][07_2019]" cus="exp-amt-{{$i}}-07_2019" id="07_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-07_2019" class="fa-submit fa-check-exp-amt-{{$i}}-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-06_2019" align="center"><span id="s-exp-amt-{{$i}}-06_2019" class="r-exp-amt-{{$i}}-05_2019">{{ @$opening_stock['06_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e10 number exp-amt-{{ $i }}-06_2019 06_2019 r-exp-amt-{{$i}}-05_2019" value="{{ @$opening_stock['06_2019'] }}" name="row[{{ $i }}][06_2019]" cus="exp-amt-{{$i}}-06_2019" id="06_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-06_2019" class="fa-submit fa-check-exp-amt-{{$i}}-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-05_2019" align="center"><span id="s-exp-amt-{{$i}}-05_2019" class="r-exp-amt-{{$i}}-04_2019">{{ @$opening_stock['05_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e11 number exp-amt-{{ $i }}-05_2019 05_2019 r-exp-amt-{{$i}}-04_2019" value="{{ @$opening_stock['05_2019'] }}" name="row[{{ $i }}][05_2019]" cus="exp-amt-{{$i}}-05_2019" id="05_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-05_2019" class="fa-submit fa-check-exp-amt-{{$i}}-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-04_2019" align="center"><span id="s-exp-amt-{{$i}}-04_2019">{{ @$opening_stock['04_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e12 number exp-amt-{{ $i }}-04_2019 04_2019" value="{{ @$opening_stock['04_2019'] }}" name="row[{{ $i }}][04_2019]" cus="exp-amt-{{$i}}-04_2019" id="04_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-04_2019" class="fa-submit fa-check-exp-amt-{{$i}}-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
          </tr>
          @php
          
          $i++;
          
          @endphp
          
          @endforeach
          <tr id="e">
            <th align="right" style="text-align:right; font-weight:bold;"><span class="co-name">Total Closing Stock =</span></th>
            <td id="e1-tot" class="tot-03_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e2-tot" class="tot-02_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e3-tot" class="tot-01_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e4-tot" class="tot-12_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e5-tot" class="tot-11_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e6-tot" class="tot-10_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e7-tot" class="tot-09_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e8-tot" class="tot-08_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e9-tot" class="tot-07_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e10-tot" class="tot-06_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e11-tot" class="tot-05_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="e12-tot" class="tot-04_2019" align="center" style="font-weight:bold; width:100px;"></td>
          </tr>
          <tr class="blue-box" >
            <th style="text-align:center; font-weight:bold;"><span class="co-name" style="color:#FFFFFF;">PURCHASES</span><span class="co-name" style="float:right;"><a class="add-purchases" href="javascript:void(0);"><i class="fa fa-plus-circle" style="color:#006600; font-size:20px; float:right;" aria-hidden="true"></i></a></span></th>
            @foreach(getMonths() as $months)
            <td>&nbsp;</td>
            @endforeach </tr>
          @foreach($purchases as $key=>$purchases)
          <tr class="purchases remove-{{ $i }}" id="remove-purchases-{{ @$purchases['opening_stock_id'] }}">
            <th class="hidden_th a-fa-click" id="a-{{$i}}"> <div class="product"><span class="sp-a-{{$i}} e-{{ @$purchases['opening_stock_id'] }}">{{ @$purchases['name'] }}</span>
		<select cus="a-{{$i}}" id="{{ @$purchases['_id'] }}" class="a-{{$i}} e-{{$i}} attribute-purchase" autocomplete="off" name="row[{{ $i }}][name]" style="display:none;">
		  @foreach($purchases_select as $purchases_dropdown)
		  <option @if($purchases['name']==$purchases_dropdown['name']) selected="selected" @endif value="{{ $purchases_dropdown['name'] }}">{{ $purchases_dropdown['name'] }}</option>
		  @endforeach
		  </select>
              &nbsp;<a style="display:none; padding:0px 0px !important;" id="a-{{$i}}" class="fa-submit-attribute fa-check-a-{{$i}}" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove" cus="{{$i}}" id="{{ @$purchases['_id'] }}" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a></div> </th>
            <input value="{{ @$purchases['_id'] }}" id="h-a-{{$i}}" type="hidden" name="row[{{ $i }}][id]" />
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-03_2020" align="center"><span id="f-exp-amt-{{$i}}-03_2020">{{ @$purchases['03_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f1 number-purchase exp-amt-{{$i}}-03_2020 f-03_2020" value="{{ @$purchases['03_2020'] }}" name="row[{{ $i }}][03_2020]" cus="exp-amt-{{$i}}-03_2020" id="03_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-03_2020" class="fa-submit fa-check-exp-amt-{{$i}}-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-02_2020" align="center"><span id="f-exp-amt-{{$i}}-02_2020">{{ @$purchases['02_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f2 number-purchase exp-amt-{{$i}}-02_2020 f-02_2020" value="{{ @$purchases['02_2020'] }}" name="row[{{ $i }}][02_2020]" cus="exp-amt-{{$i}}-02_2020" id="02_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-02_2020" class="fa-submit fa-check-exp-amt-{{$i}}-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-01_2020" align="center"><span id="f-exp-amt-{{$i}}-01_2020">{{ @$purchases['01_2020'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f3 number-purchase exp-amt-{{ $i }}-01_2020 f-01_2020" value="{{ @$purchases['01_2020'] }}" name="row[{{ $i }}][01_2020]" cus="exp-amt-{{$i}}-01_2020" id="01_2020"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-01_2020" class="fa-submit fa-check-exp-amt-{{$i}}-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-12_2019" align="center"><span id="f-exp-amt-{{$i}}-12_2019">{{ @$purchases['12_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f4 number-purchase exp-amt-{{ $i }}-12_2019 f-12_2019" value="{{ @$purchases['12_2019'] }}" name="row[{{ $i }}][12_2019]" cus="exp-amt-{{$i}}-12_2019" id="12_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-12_2019" class="fa-submit fa-check-exp-amt-{{$i}}-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-11_2019" align="center"><span id="f-exp-amt-{{$i}}-11_2019">{{ @$purchases['11_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f5 number-purchase exp-amt-{{ $i }}-11_2019 f-11_2019" value="{{ @$purchases['11_2019'] }}" name="row[{{ $i }}][11_2019]"  cus="exp-amt-{{$i}}-11_2019" id="11_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-11_2019" class="fa-submit fa-check-exp-amt-{{$i}}-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-10_2019" align="center"><span id="f-exp-amt-{{$i}}-10_2019">{{ @$purchases['10_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f6 number-purchase exp-amt-{{ $i }}-10_2019 f-10_2019" value="{{ @$purchases['10_2019'] }}" name="row[{{ $i }}][10_2019]" cus="exp-amt-{{$i}}-10_2019" id="10_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-10_2019" class="fa-submit fa-check-exp-amt-{{$i}}-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-09_2019" align="center"><span id="f-exp-amt-{{$i}}-09_2019">{{ @$purchases['09_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f7 number-purchase exp-amt-{{ $i }}-09_2019 f-09_2019" value="{{ @$purchases['09_2019'] }}" name="row[{{ $i }}][09_2019]" cus="exp-amt-{{$i}}-09_2019" id="09_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-09_2019" class="fa-submit fa-check-exp-amt-{{$i}}-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-08_2019" align="center"><span id="f-exp-amt-{{$i}}-08_2019">{{ @$purchases['08_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f8 number-purchase exp-amt-{{ $i }}-08_2019 f-08_2019" value="{{ @$purchases['08_2019'] }}" name="row[{{ $i }}][08_2019]" cus="exp-amt-{{$i}}-08_2019" id="08_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-08_2019" class="fa-submit fa-check-exp-amt-{{$i}}-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-07_2019" align="center"><span id="f-exp-amt-{{$i}}-07_2019">{{ @$purchases['07_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f9 number-purchase exp-amt-{{ $i }}-07_2019 f-07_2019" value="{{ @$purchases['07_2019'] }}" name="row[{{ $i }}][07_2019]" cus="exp-amt-{{$i}}-07_2019" id="07_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-07_2019" class="fa-submit fa-check-exp-amt-{{$i}}-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-06_2019" align="center"><span id="f-exp-amt-{{$i}}-06_2019">{{ @$purchases['06_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f10 number-purchase exp-amt-{{ $i }}-06_2019 f-06_2019" value="{{ @$purchases['06_2019'] }}" name="row[{{ $i }}][06_2019]" cus="exp-amt-{{$i}}-06_2019" id="06_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-06_2019" class="fa-submit fa-check-exp-amt-{{$i}}-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-05_2019" align="center"><span id="f-exp-amt-{{$i}}-05_2019">{{ @$purchases['05_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f11 number-purchase exp-amt-{{ $i }}-05_2019 f-05_2019" value="{{ @$purchases['05_2019'] }}" name="row[{{ $i }}][05_2019]" cus="exp-amt-{{$i}}-05_2019" id="05_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-05_2019" class="fa-submit fa-check-exp-amt-{{$i}}-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-04_2019" align="center"><span id="f-exp-amt-{{$i}}-04_2019">{{ @$purchases['04_2019'] }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f12 number-purchase exp-amt-{{ $i }}-04_2019 f-04_2019" value="{{ @$purchases['04_2019'] }}" name="row[{{ $i }}][04_2019]" cus="exp-amt-{{$i}}-04_2019" id="04_2019"/>
              <a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-04_2019" class="fa-submit fa-check-exp-amt-{{$i}}-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td>
          </tr>
          @php         
          $i++;          
          @endphp          
          @endforeach
          <tr id="purchase">
            <th align="right" style="text-align:right; font-weight:bold;"><span class="co-name">Total Purchases =</span></th>
            <td id="f1-tot" class="tot-f-03_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f2-tot" class="tot-f-02_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f3-tot" class="tot-f-01_2020" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f4-tot" class="tot-f-12_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f5-tot" class="tot-f-11_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f6-tot" class="tot-f-10_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f7-tot" class="tot-f-09_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f8-tot" class="tot-f-08_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f9-tot" class="tot-f-07_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f10-tot" class="tot-f-06_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f11-tot" class="tot-f-05_2019" align="center" style="font-weight:bold; width:100px;"></td>
            <td id="f12-tot" class="tot-f-04_2019" align="center" style="font-weight:bold; width:100px;"></td>
          </tr>
         
          
            </tbody>
          
        </table>
        
        <!--<button type="submit" name="Submit" class="btn btn-success">Submit</button>--> 
        
      </div>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
$(function(){
$(document).on('paste keyup', '.number',function(e){
    $(this).val($(this).val().replace(/[^-\d]/g, ''));
  });
});
</script> 
<script>
$(function(){
$(document).on('paste keyup', '.number-purchase',function(e){
    $(this).val($(this).val().replace(/[^-\d]/g, ''));
  });
});
</script> 
<script>
$(function(){
   $(document).on('click','.fa-submit',function(){
   var id = $(this).attr('id');
   var cus = $(this).attr('cus');
   $(this).hide();
   $('.'+id).hide();
   $('#s-'+id).show();
   $('#f-'+id).show();
   var name_val = $('.'+id).val();
   var column_name = $('.'+id).attr('id');
   var id_rel = $('.'+id).attr('rel');
   var id_db = $('#h-'+id_rel).val();
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['opening_stock']);
		  $('.exp-amt-'+id).attr('id', data['opening_stock']);
		  //$('.'+id).attr('id', data['opening_stock']);
		  $('#fix-amt').val(data['opening_stock']);
		  $('.fix-amt').attr('id', data['opening_stock']);
		  }
        }
      });
    });
});
</script> 
<script>
$(function(){
   $(document).on('click','.fa-submit-purchase',function(){
   var id = $(this).attr('id');
   var cus = $(this).attr('cus');
   $(this).hide();
   $('.'+id).hide();
   $('#s-'+id).show();
   $('#f-'+id).show();
   var name_val = $('.'+id).val();
   var column_name = $('.'+id).attr('id');
   var id_rel = $('.'+id).attr('rel');
   var id_db = $('#h-'+id_rel).val();
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributePurchaseX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['opening_stock']);
		  $('.exp-amt-'+id).attr('id', data['opening_stock']);
		  //$('.'+id).attr('id', data['opening_stock']);
		  $('#fix-amt').val(data['opening_stock']);
		  $('.fix-amt').attr('id', data['opening_stock']);
		  }
        }
      });
    });
});
</script> 
<script>
$(function(){
   $(document).on('click','.fa-submit-attribute',function(){
   var id = $(this).attr('id');
   var cus = $(this).attr('cus');
   $(this).hide();
   var attribute_val = $('.'+id).val();
   $('.sp-'+id).html(attribute_val);
   $('.'+id).hide();
   $('.sp-'+id).show();
   var name_val = $('.'+id).val();
   var id_db = $('#h-'+id).val();
   var column_name = 'name';
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributeX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='' && response!=1)
			{
			data = JSON.parse(response);
			$('#h-'+id).val(data['opening_stock']);
			$('.exp-amt-'+id).attr('id', data['opening_stock']);
			$('.'+id).attr('id', data['opening_stock']);
			$('#fix-amt').val(data['opening_stock']);
			$('.fix-amt').attr('id', data['opening_stock']);
			var rowCount2 = $('#table-basic >tbody >tr').length;
			$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
			$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
			
			$("table.table.fixed_table tr .task_left_fix").each(function() {
			var x = $(this).offset();
			$(this).css({ "left": x.left - 0 + "px"});
			});
			$("table.table.fixed_table tr.task_top_fix th").each(function() {
			var y = $(this).offset();
			$(this).css({ "top": y.top - 0 + "px"});
			});
			$(".hidden_td").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			var amount = $('.'+id).val();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			$(".hidden_th").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			}else{
			$('.fa-check-'+id).show();
            $('.'+id).show();
            $('.sp-'+id).hide();
		  alert('Data already added.Please choose another one.');
		  return false;
		  }
		  	   
        }
      });
    });
});
</script> 
<script>
$(function(){
   $(document).on('click','.fa-submit-attribute-purchase',function(){
   var id = $(this).attr('id');
   var cus = $(this).attr('cus');
   var attribute_val = $('.'+id).val();
   $('.sp-'+id).html(attribute_val);
   $(this).hide();
   $('.'+id).hide();
   $('.sp-'+id).show();
   var name_val = $('.'+id).val();
   var id_db = $('#h-'+id).val();
   var column_name = 'name';
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributePurchaseX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='' && response!=1)
			{
			data = JSON.parse(response);
			$('#h-'+id).val(data['opening_stock']);
			$('.exp-amt-'+id).attr('id', data['opening_stock']);
			$('.'+id).attr('id', data['opening_stock']);
			$('#fix-amt').val(data['opening_stock']);
			$('.fix-amt').attr('id', data['opening_stock']);
			$(".hidden_td").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			var amount = $('.'+id).val();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			$(".hidden_th").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			}else{
			$('.fa-check-'+id).show();
            $('.'+id).show();
            $('.sp-'+id).hide();
		  alert('Data already added.Please choose another one.');
		  return false;
		  }
        }
      });
    });
});
</script> 
 
<script>
$(document).on('click','.add-opening-stock',function(){
   var rowCount = $('#table-basic >tbody >tr').length;
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/ajaxStockAttributePurchaseX') }}" ,
        type: "POST",
        data: {rowCount:rowCount},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		   $('#e').before(response);
			$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
			$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
			
			$("table.table.fixed_table tr .task_left_fix").each(function() {
			var x = $(this).offset();
			$(this).css({ "left": x.left - 0 + "px"});
			});
			$("table.table.fixed_table tr.task_top_fix th").each(function() {
			var y = $(this).offset();
			$(this).css({ "top": y.top - 0 + "px"});
			});
			
			$('.a-'+(rowCount+1)).focus();
			$(".hidden_td").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			var amount = $('.'+id).val();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			$(".hidden_th").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
		  }
        }
      });
});
</script>



<script>
$(document).on('click','.add-purchases',function(){
   var rowCount = $('#table-basic >tbody >tr').length;
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/ajaxStockAttributePurchaseAddX') }}" ,
        type: "POST",
        data: {rowCount:rowCount},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		   $('#purchase').before(response);
			$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
			$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
			
			$("table.table.fixed_table tr .task_left_fix").each(function() {
			var x = $(this).offset();
			$(this).css({ "left": x.left - 0 + "px"});
			});
			$("table.table.fixed_table tr.task_top_fix th").each(function() {
			var y = $(this).offset();
			$(this).css({ "top": y.top - 0 + "px"});
			});
			
			$('.a-'+(rowCount+1)).focus();
			$(".hidden_td").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			var amount = $('.'+id).val();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			$(".hidden_th").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
		  }
        }
      });
});
</script>
 
<script>
$(function(){
     $(document).on('click','.remove',function(){
	   var row_chk = $(this).attr('cus');
	   var id = $(this).attr('id');
	   if(id==''){
	   var check_verify_one = confirm("Are you sure to delete the row?");
	   if(check_verify_one){
	   $('#remove-'+row_chk).remove();
	   $('.remove-'+row_chk).remove();
	   }
	   }else{
	   var check_verify = confirm("Are you sure to delete the row?");
	   if(check_verify){
	   
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "GET",
		url: "{{ url('admin/dataRemoveStockX')}}/"+id,
		data: {id:id},
        success: function( response ) {
		   //alert(response); return false;
		   $('.remove-'+row_chk).remove();
          $('#remove-'+row_chk).remove();
		  $('#remove-purchases-'+id).remove();
		  $('#remove-closing-'+id).remove();
			var sum0 = 0;
			$('.e0').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum0 += parseFloat(combat);
			}
			});
			$('#e0-tot').html(sum0.toLocaleString('en-IN'));
			
			var sum1 = 0;
			$('.e1').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum1 += parseFloat(combat);
			}
			});
			$('#e1-tot').html(sum1.toLocaleString('en-IN'));
			
			var sum2 = 0;
			$('.e2').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum2 += parseFloat(combat);
			}
			});
			$('#e2-tot').html(sum2.toLocaleString('en-IN'));
			
			var sum3 = 0;
			$('.e3').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum3 += parseFloat(combat);
			}
			});
			$('#e3-tot').html(sum3.toLocaleString('en-IN'));
			
			var sum4 = 0;
			$('.e4').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum4 += parseFloat(combat);
			}
			});
			$('#e4-tot').html(sum4.toLocaleString('en-IN'));
			
			
			var sum5 = 0;
			$('.e5').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum5 += parseFloat(combat);
			}
			});
			$('#e5-tot').html(sum5.toLocaleString('en-IN'));
			
			var sum6 = 0;
			$('.e6').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum6 += parseFloat(combat);
			}
			});
			$('#e6-tot').html(sum6.toLocaleString('en-IN'));
			
			var sum7 = 0;
			$('.e7').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum7+= parseFloat(combat);
			}
			});
			$('#e7-tot').html(sum7.toLocaleString('en-IN'));
			
			var sum8 = 0;
			$('.e8').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum8+= parseFloat(combat);
			}
			});
			$('#e8-tot').html(sum8.toLocaleString('en-IN'));
			
			var sum9 = 0;
			$('.e9').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum9+= parseFloat(combat);
			}
			});
			$('#e9-tot').html(sum9.toLocaleString('en-IN'));
			
			var sum10 = 0;
			$('.e10').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum10+= parseFloat(combat);
			}
			});
			$('#e10-tot').html(sum10.toLocaleString('en-IN'));
			
			var sum11 = 0;
			$('.e11').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum11+= parseFloat(combat);
			}
			});
			$('#e11-tot').html(sum11.toLocaleString('en-IN'));
			
			var sum12 = 0;
			$('.e12').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum12+= parseFloat(combat);
			}
			});
			$('#e12-tot').html(sum12.toLocaleString('en-IN'));
			
			var sum13 = 0;
			$('.e13').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum13+= parseFloat(combat);
			}
			});
			$('#e13-tot').html(sum13.toLocaleString('en-IN'));
			
			var sum14_0 = 0;
			$('.f0').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum14_0 += parseFloat(combat);
			}
			});
			$('#f0-tot').html(sum14_0.toLocaleString('en-IN'));
			
			var sum14 = 0;
			$('.f1').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum14 += parseFloat(combat);
			}
			});
			$('#f1-tot').html(sum14.toLocaleString('en-IN'));
			
			var sum15 = 0;
			$('.f2').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum15 += parseFloat(combat);
			}
			});
			$('#f2-tot').html(sum15.toLocaleString('en-IN'));
			
			var sum16 = 0;
			$('.f3').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum16 += parseFloat(combat);
			}
			});
			$('#f3-tot').html(sum16.toLocaleString('en-IN'));
			
			var sum17 = 0;
			$('.f4').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum17 += parseFloat(combat);
			}
			});
			$('#f4-tot').html(sum17.toLocaleString('en-IN'));
			
			var sum18 = 0;
			$('.f5').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum18 += parseFloat(combat);
			}
			});
			$('#f5-tot').html(sum18.toLocaleString('en-IN'));
			
			var sum19 = 0;
			$('.f6').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum19 += parseFloat(combat);
			}
			});
			$('#f6-tot').html(sum19.toLocaleString('en-IN'));
			
			var sum20 = 0;
			$('.f7').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum20 += parseFloat(combat);
			}
			});
			$('#f7-tot').html(sum20.toLocaleString('en-IN'));
			
			var sum21 = 0;
			$('.f8').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum21 += parseFloat(combat);
			}
			});
			$('#f8-tot').html(sum21.toLocaleString('en-IN'));
			
			var sum22 = 0;
			$('.f9').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum22 += parseFloat(combat);
			}
			});
			$('#f9-tot').html(sum22.toLocaleString('en-IN'));
			
			var sum23 = 0;
			$('.f10').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum23 += parseFloat(combat);
			}
			});
			$('#f10-tot').html(sum23.toLocaleString('en-IN'));
			
			var sum24 = 0;
			$('.f11').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum24 += parseFloat(combat);
			}
			});
			$('#f11-tot').html(sum24.toLocaleString('en-IN'));
			
			var sum25 = 0;
			$('.f12').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum25 += parseFloat(combat);
			}
			});
			$('#f12-tot').html(sum25.toLocaleString('en-IN'));
			
			var sum26 = 0;
			$('.f13').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum26 += parseFloat(combat);
			}
			});
			$('#f13-tot').html(sum26.toLocaleString('en-IN'));
			
			var sum27_0 = 0;
			$('.c0').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum27_0 += parseFloat(combat);
			}
			});
			$('#c0-tot').html(sum27_0.toLocaleString('en-IN'));
			
			
			var sum27 = 0;
			$('.c1').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum27 += parseFloat(combat);
			}
			});
			$('#c1-tot').html(sum27.toLocaleString('en-IN'));
			
			var sum28 = 0;
			$('.c2').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum28 += parseFloat(combat);
			}
			});
			$('#c2-tot').html(sum28.toLocaleString('en-IN'));
			
			var sum29 = 0;
			$('.c3').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum29 += parseFloat(combat);
			}
			});
			$('#c3-tot').html(sum29.toLocaleString('en-IN'));
			
			var sum30 = 0;
			$('.c4').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum30 += parseFloat(combat);
			}
			});
			$('#c4-tot').html(sum30.toLocaleString('en-IN'));
			
			var sum31 = 0;
			$('.c5').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum31 += parseFloat(combat);
			}
			});
			$('#c5-tot').html(sum31.toLocaleString('en-IN'));
			
			var sum32 = 0;
			$('.c6').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum32 += parseFloat(combat);
			}
			});
			$('#c6-tot').html(sum32.toLocaleString('en-IN'));
			
			var sum33 = 0;
			$('.c7').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum33 += parseFloat(combat);
			}
			});
			$('#c7-tot').html(sum33.toLocaleString('en-IN'));
			
			var sum34 = 0;
			$('.c8').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum34 += parseFloat(combat);
			}
			});
			$('#c8-tot').html(sum34.toLocaleString('en-IN'));
			
			var sum35 = 0;
			$('.c9').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum35 += parseFloat(combat);
			}
			});
			$('#c9-tot').html(sum35.toLocaleString('en-IN'));
			
			var sum36 = 0;
			$('.c10').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum36 += parseFloat(combat);
			}
			});
			$('#c10-tot').html(sum36.toLocaleString('en-IN'));
			
			var sum37 = 0;
			$('.c11').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum37 += parseFloat(combat);
			}
			});
			$('#c11-tot').html(sum37.toLocaleString('en-IN'));
			
			var sum38 = 0;
			$('.c12').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum38 += parseFloat(combat);
			}
			});
			$('#c12-tot').html(sum38.toLocaleString('en-IN'));
			
			var sum39 = 0;
			$('.c13').each(function () {
			var combat = $(this).val();
			if (!isNaN(combat) && combat.length !== 0) {
			sum39 += parseFloat(combat);
			}
			});
			$('#c13-tot').html(sum39.toLocaleString('en-IN'));
			
			
        }
		
        });
	   }
	   }
	 });
});
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e0').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e0-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e1').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e1-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e2').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e2-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e3').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e3-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e4').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e4-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e5').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e5-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e6').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e6-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e7').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e7-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e8').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e8-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e9').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e9-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e10').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e10-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e11').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e11-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e12').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e12-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.e13').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#e13-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f0').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f0-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f1').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f1-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f2').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f2-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f3').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f3-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f4').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f4-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f5').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f5-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f6').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f6-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f7').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f7-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f8').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f8-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f9').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f9-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f10').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f10-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f11').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f11-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f12').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f12-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.f13').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#f13-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c0').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c0-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c1').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c1-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c2').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c2-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c3').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c3-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c4').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c4-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c5').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c5-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c6').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c6-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c7').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c7-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c8').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c8-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c9').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c9-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c10').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c10-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c11').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c11-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c12').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c12-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(document).ready(function () {
     var sum = 0;
     $('.c13').each(function () {
         var combat = $(this).val();
         if (!isNaN(combat) && combat.length !== 0) {
             sum += parseFloat(combat);
         }
     });
     $('#c13-tot').html(sum.toLocaleString('en-IN'));
 });
</script> 
<script>
$(function(){
  $(document).on('keypress','.number',function(e) {
	//if(isNaN(this.value+""+String.fromCharCode(e.charCode).toLocaleString('en-IN'))) return false;
  });
});
</script> 
<script>
$(function(){
  $(document).on('keypress','.number-purchase',function(e) {
	//if(isNaN(this.value+""+String.fromCharCode(e.charCode).toLocaleString('en-IN'))) return false;
  });
});
</script> 
<script>
$(".hidden_td").hover( function () {
  var id = $(this).attr('id');
  $('.fa-'+id).show();
  var amount = $('.'+id).val();
}, function() {
var id = $(this).attr('id');
  $('.fa-'+id).hide();
});
</script> 
<script>
$(".hidden_th").hover( function () {
  var id = $(this).attr('id');
  $('.fa-'+id).show();
}, function() {
var id = $(this).attr('id');
  $('.fa-'+id).hide();
});
</script> 
<script>
$(function(){
   $(document).on('keyup','.number,.number-purchase',function(){
        var amount = $(this).val();
		var cus = $(this).attr('cus');
		var id = $(this).attr('id');
		$('#s-'+cus).html(amount);
		$('#f-'+cus).html(amount);
		//$('.r-'+cus).val($('.c-'+id).val());
		//$('.r-'+cus).html($('.c-'+id).val());
		var subTotal = 0;
		$("."+id).each(function () {
		var stval = parseFloat($(this).val());
		subTotal += isNaN(stval) ? 0 : stval;
		});
		
		var subTotal2 = 0;
		$(".f-"+id).each(function () {
		var stval2 = parseFloat($(this).val());
		subTotal2 += isNaN(stval2) ? 0 : stval2;
		});
		
		var subTotal3 = 0;
		$(".c-"+id).each(function () {
		var stval3 = parseFloat($(this).val());
		subTotal3 += isNaN(stval3) ? 0 : stval3;
		});
		
		$('.tot-'+id).html(subTotal.toLocaleString('en-IN'));
		$('.tot-f-'+id).html(subTotal2.toLocaleString('en-IN'));
		$('.tot-c-'+id).html(subTotal3.toLocaleString('en-IN'));
		
		$("table.table.fixed_table tr td span").each(function() {
         var combat = $(this).html();
		 //alert(combat); return false;
         if (!isNaN(combat) && combat.length !== 0) {
			 //alert(Number(combat).toLocaleString('en-IN')); return false;
			 $(this).html(Number(combat).toLocaleString('en-IN'));
         }
     });   
		
   });
});
</script> 
<script>
$(function(){
   $(document).on('keyup','.attribute,.attribute-purchase',function(){
        var attribute_val = $(this).val();
		var id = $(this).attr('cus');
		var edit_val = $(this).attr('id');
		$('.sp-'+id).html(attribute_val);
		$('.e-'+edit_val).html(attribute_val);
   });
});
</script> 
<script>
$(function(){
    $(document).on('dblclick','.fa-click',function(){
	   var id = $(this).attr('id');
	   $('.'+id).show();
	   $('.'+id).select();
	   $('.'+id).focus();
	   $('#s-'+id).hide();
	   $('#f-'+id).hide();
	   //$(this).remove();
	   $('.fa-check-'+id).show();
	});
});
</script> 
<script>
$(function(){
    $(document).on('dblclick','.a-fa-click',function(){
	   var id = $(this).attr('id');
	   //alert(id);
	   $('.'+id).show();
	   $('.'+id).select();
	   $('.'+id).focus();
	   $('.sp-'+id).hide();
	   //$(this).remove();
	   $('.fa-check-'+id).show();
	});
});
</script> 
<script>
$(document).on('keypress','.attribute',function(e) {
    if(e.which == 13) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
   var id = $(this).attr('cus');
   //alert(id); return false;
    var attribute_val = $(this).val();
   $('.sp-'+id).html(attribute_val);
   $('.fa-check-'+id).hide();
   var name_val = $(this).val();
   $('.'+id).hide();
   $('.sp-'+id).show();
   var id_db = $('#h-'+id).val();
   var column_name = 'name';
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributeX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='' && response!=1)
			{
			data = JSON.parse(response);
			$('#h-'+id).val(data['opening_stock']);
			$('.exp-amt-'+id).attr('id', data['opening_stock']);
			$('.'+id).attr('id', data['opening_stock']);
			$('#fix-amt').val(data['opening_stock']);
			$('.fix-amt').attr('id', data['opening_stock']);
			var rowCount2 = $('#table-basic >tbody >tr').length;
			$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
			$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
			
			$("table.table.fixed_table tr .task_left_fix").each(function() {
			var x = $(this).offset();
			$(this).css({ "left": x.left - 0 + "px"});
			});
			$("table.table.fixed_table tr.task_top_fix th").each(function() {
			var y = $(this).offset();
			$(this).css({ "top": y.top - 0 + "px"});
			});
			$(".hidden_td").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			var amount = $('.'+id).val();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			$(".hidden_th").hover( function () {
			var id = $(this).attr('id');
			$('.fa-'+id).show();
			}, function() {
			var id = $(this).attr('id');
			$('.fa-'+id).hide();
			});
			}else{
			$('.fa-check-'+id).show();
            $('.'+id).show();
            $('.sp-'+id).hide();
		  alert('Data already added.Please choose another one.');
		  return false;
			}
		  	  
		  
		  
        }
      });
    
    }
});
</script> 
<script>
$(document).on('keypress','.attribute-purchase',function(e) {
    if(e.which == 13) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
   var id = $(this).attr('cus');
   //alert(id); return false;
    var attribute_val = $(this).val();
   $('.sp-'+id).html(attribute_val);
   $('.fa-check-'+id).hide();
   var name_val = $(this).val();
   $('.'+id).hide();
   $('.sp-'+id).show();
   var id_db = $('#h-'+id).val();
   var column_name = 'name';
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributePurchaseX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='' && response!=1)
		{
		data = JSON.parse(response);
		$('#h-'+id).val(data['opening_stock']);
		$('.exp-amt-'+id).attr('id', data['opening_stock']);
		$('.'+id).attr('id', data['opening_stock']);
		$('#fix-amt').val(data['opening_stock']);
		$('.fix-amt').attr('id', data['opening_stock']);
		
		$(".hidden_td").hover( function () {
		var id = $(this).attr('id');
		$('.fa-'+id).show();
		var amount = $('.'+id).val();
		}, function() {
		var id = $(this).attr('id');
		$('.fa-'+id).hide();
		});
		$(".hidden_th").hover( function () {
		var id = $(this).attr('id');
		$('.fa-'+id).show();
		}, function() {
		var id = $(this).attr('id');
		$('.fa-'+id).hide();
		});
		}else{
			$('.fa-check-'+id).show();
            $('.'+id).show();
            $('.sp-'+id).hide();
		  alert('Data already added.Please choose another one.');
		  return false;
		  }
        }
      });
    }
});
</script> 
<script>
$(document).on('keypress','.number',function(e) {
    if(e.which == 13) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
   var id = $(this).attr('cus');
   //alert(id); return false;
   $('.fa-check-'+id).hide();
   $('.'+id).hide();
   $('#s-'+id).show();
   $('#f-'+id).show();
   var name_val = $(this).val();
   var column_name = $(this).attr('id');
   var id_rel = $(this).attr('rel');
   var id_db = $('#h-'+id_rel).val();
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['opening_stock']);
		  $('.exp-amt-'+id).attr('id', data['opening_stock']);
		  //$('.'+id).attr('id', data['opening_stock']);
		  $('#fix-amt').val(data['opening_stock']);
		  $('.fix-amt').attr('id', data['opening_stock']);
		  }
        }
      });
    
    }
});
</script> 
<script>
$(document).on('keypress','.number-purchase',function(e) {
    if(e.which == 13) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  
   var id = $(this).attr('cus');
   //alert(id); return false;
   $('.fa-check-'+id).hide();
   $('.'+id).hide();
   $('#s-'+id).show();
   $('#f-'+id).show();
   var name_val = $(this).val();
   var column_name = $(this).attr('id');
   var id_rel = $(this).attr('rel');
   var id_db = $('#h-'+id_rel).val();
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitStockAttributePurchaseX') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['opening_stock']);
		  $('.exp-amt-'+id).attr('id', data['opening_stock']);
		  //$('.'+id).attr('id', data['opening_stock']);
		  $('#fix-amt').val(data['opening_stock']);
		  $('.fix-amt').attr('id', data['opening_stock']);
		  }
        }
      });
    
    }
});
</script> 


<script type="text/javascript">
$(document).ready(function() {
$(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");

$("table.table.fixed_table tr .task_left_fix").each(function() {
 var x = $(this).offset();
 $(this).css({ "left": x.left - 0 + "px"});
});
$("table.table.fixed_table tr.task_top_fix th").each(function() {
 var y = $(this).offset();
 $(this).css({ "top": y.top - 0 + "px"});
});
});
</script> 

<style type="text/css">.page-content{ padding:0; }</style>
<script>
$(document).ready(function() {
     $("table.table.fixed_table tr td span").each(function() {
         var combat = $(this).html();
		 //alert(combat); return false;
         if (!isNaN(combat) && combat.length !== 0) {
			 //alert(Number(combat).toLocaleString('en-IN')); return false;
			 $(this).html(Number(combat).toLocaleString('en-IN'));
         }
     });
});
</script>

@endsection 