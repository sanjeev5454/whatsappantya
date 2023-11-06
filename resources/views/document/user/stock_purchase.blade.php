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
              <th style="text-align:center; font-weight:bold;"><span class="co-name">CLOSING STOCK</span></th>
              @foreach(getMonths() as $months)
              <td>&nbsp;</td>
              @endforeach </tr>
          @php
          
          $i=0;
          
          @endphp
          
          @foreach($opening_stock as $key1=>$opening_stock)
          <tr class="opening_stock" id="remove-{{$i}}">
            <th class="hidden_th a-fa-click" id="a-{{$i}}"><div class="product"> <span class="sp-a-{{$i}}">{{ @$opening_stock['name'] }}</span>
              <input value="{{ @$opening_stock['name'] }}" type="text" cus="a-{{$i}}" id="{{ @$opening_stock['_id'] }}" class="a-{{$i}} e-{{$i}} attribute" autocomplete="off" name="row[{{ $i }}][name]" style="display:none;" /></div></th>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-03_2020" align="center"><span id="s-exp-amt-{{$i}}-03_2020" class="r-exp-amt-{{$i}}-02_2020">{{ amountCanculatedClosing(@$opening_stock['name'],'03_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e1 number exp-amt-{{$i}}-03_2020 03_2020 r-exp-amt-{{$i}}-02_2020" value="{{ amountCanculatedClosing(@$opening_stock['name'],'03_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][03_2020]" cus="exp-amt-{{$i}}-03_2020" id="03_2020"/>
			  </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-02_2020" align="center"><span id="s-exp-amt-{{$i}}-02_2020" class="r-exp-amt-{{$i}}-01_2020">{{ amountCanculatedClosing(@$opening_stock['name'],'02_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e2 number exp-amt-{{$i}}-02_2020 02_2020 r-exp-amt-{{$i}}-01_2020" value="{{ amountCanculatedClosing(@$opening_stock['name'],'02_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][02_2020]" cus="exp-amt-{{$i}}-02_2020" id="02_2020"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-01_2020" align="center"><span id="s-exp-amt-{{$i}}-01_2020" class="r-exp-amt-{{$i}}-12_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'01_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e3 number exp-amt-{{ $i }}-01_2020 01_2020 r-exp-amt-{{$i}}-12_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'01_2020',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][01_2020]" cus="exp-amt-{{$i}}-01_2020" id="01_2020"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-12_2019" align="center"><span id="s-exp-amt-{{$i}}-12_2019" class="r-exp-amt-{{$i}}-11_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'12_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e4 number exp-amt-{{ $i }}-12_2019 12_2019 r-exp-amt-{{$i}}-11_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'12_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][12_2019]" cus="exp-amt-{{$i}}-12_2019" id="12_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-11_2019" align="center"><span id="s-exp-amt-{{$i}}-11_2019" class="r-exp-amt-{{$i}}-10_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'11_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e5 number exp-amt-{{ $i }}-11_2019 11_2019 r-exp-amt-{{$i}}-10_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'11_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][11_2019]"  cus="exp-amt-{{$i}}-11_2019" id="11_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-10_2019" align="center"><span id="s-exp-amt-{{$i}}-10_2019" class="r-exp-amt-{{$i}}-09_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'10_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e6 number exp-amt-{{ $i }}-10_2019 10_2019 r-exp-amt-{{$i}}-09_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'10_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][10_2019]" cus="exp-amt-{{$i}}-10_2019" id="10_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-09_2019" align="center"><span id="s-exp-amt-{{$i}}-09_2019" class="r-exp-amt-{{$i}}-08_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'09_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e7 number exp-amt-{{ $i }}-09_2019 09_2019 r-exp-amt-{{$i}}-08_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'09_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][09_2019]" cus="exp-amt-{{$i}}-09_2019" id="09_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-08_2019" align="center"><span id="s-exp-amt-{{$i}}-08_2019" class="r-exp-amt-{{$i}}-07_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'08_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e8 number exp-amt-{{ $i }}-08_2019 08_2019 r-exp-amt-{{$i}}-07_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'08_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][08_2019]" cus="exp-amt-{{$i}}-08_2019" id="08_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-07_2019" align="center"><span id="s-exp-amt-{{$i}}-07_2019" class="r-exp-amt-{{$i}}-06_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'07_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e9 number exp-amt-{{ $i }}-07_2019 07_2019 r-exp-amt-{{$i}}-06_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'07_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][07_2019]" cus="exp-amt-{{$i}}-07_2019" id="07_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-06_2019" align="center"><span id="s-exp-amt-{{$i}}-06_2019" class="r-exp-amt-{{$i}}-05_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'06_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e10 number exp-amt-{{ $i }}-06_2019 06_2019 r-exp-amt-{{$i}}-05_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'06_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][06_2019]" cus="exp-amt-{{$i}}-06_2019" id="06_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-05_2019" align="center"><span id="s-exp-amt-{{$i}}-05_2019" class="r-exp-amt-{{$i}}-04_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'05_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e11 number exp-amt-{{ $i }}-05_2019 05_2019 r-exp-amt-{{$i}}-04_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'05_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][05_2019]" cus="exp-amt-{{$i}}-05_2019" id="05_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-04_2019" align="center"><span id="s-exp-amt-{{$i}}-04_2019">{{ amountCanculatedClosing(@$opening_stock['name'],'04_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="e12 number exp-amt-{{ $i }}-04_2019 04_2019" value="{{ amountCanculatedClosing(@$opening_stock['name'],'04_2019',getPrefix(Auth::user()->id).'_tbl_opening_stock') }}" name="row[{{ $i }}][04_2019]" cus="exp-amt-{{$i}}-04_2019" id="04_2019"/>
              </td>
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
            <th style="text-align:center; font-weight:bold;"><span class="co-name" style="color:#FFFFFF;">PURCHASES</span></th>
            @foreach(getMonths() as $months)
            <td>&nbsp;</td>
            @endforeach </tr>
          @foreach($purchases as $key=>$purchases)
          <tr class="purchases remove-{{ $i }}" id="remove-purchases-{{ @$purchases['opening_stock_id'] }}">
            <th class="hidden_th a-fa-click" id="a-{{$i}}"> <div class="product"><span class="sp-a-{{$i}} e-{{ @$purchases['opening_stock_id'] }}">{{ @$purchases['name'] }}</span></div> </th>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-03_2020" align="center"><span id="f-exp-amt-{{$i}}-03_2020">{{ amountCanculated(@$purchases['name'],'03_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f1 number-purchase exp-amt-{{$i}}-03_2020 f-03_2020" value="{{ amountCanculated(@$purchases['name'],'03_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][03_2020]" cus="exp-amt-{{$i}}-03_2020" id="03_2020"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-02_2020" align="center"><span id="f-exp-amt-{{$i}}-02_2020">{{ amountCanculated(@$purchases['name'],'02_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f2 number-purchase exp-amt-{{$i}}-02_2020 f-02_2020" value="{{ amountCanculated(@$purchases['name'],'02_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][02_2020]" cus="exp-amt-{{$i}}-02_2020" id="02_2020"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-01_2020" align="center"><span id="f-exp-amt-{{$i}}-01_2020">{{ amountCanculated(@$purchases['name'],'01_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f3 number-purchase exp-amt-{{ $i }}-01_2020 f-01_2020" value="{{ amountCanculated(@$purchases['name'],'01_2020',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][01_2020]" cus="exp-amt-{{$i}}-01_2020" id="01_2020"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-12_2019" align="center"><span id="f-exp-amt-{{$i}}-12_2019">{{ amountCanculated(@$purchases['name'],'12_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f4 number-purchase exp-amt-{{ $i }}-12_2019 f-12_2019" value="{{ amountCanculated(@$purchases['name'],'12_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][12_2019]" cus="exp-amt-{{$i}}-12_2019" id="12_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-11_2019" align="center"><span id="f-exp-amt-{{$i}}-11_2019">{{ amountCanculated(@$purchases['name'],'11_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f5 number-purchase exp-amt-{{ $i }}-11_2019 f-11_2019" value="{{ amountCanculated(@$purchases['name'],'11_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][11_2019]"  cus="exp-amt-{{$i}}-11_2019" id="11_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-10_2019" align="center"><span id="f-exp-amt-{{$i}}-10_2019">{{ amountCanculated(@$purchases['name'],'10_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f6 number-purchase exp-amt-{{ $i }}-10_2019 f-10_2019" value="{{ amountCanculated(@$purchases['name'],'10_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][10_2019]" cus="exp-amt-{{$i}}-10_2019" id="10_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-09_2019" align="center"><span id="f-exp-amt-{{$i}}-09_2019">{{ amountCanculated(@$purchases['name'],'09_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f7 number-purchase exp-amt-{{ $i }}-09_2019 f-09_2019" value="{{ amountCanculated(@$purchases['name'],'09_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][09_2019]" cus="exp-amt-{{$i}}-09_2019" id="09_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-08_2019" align="center"><span id="f-exp-amt-{{$i}}-08_2019">{{ amountCanculated(@$purchases['name'],'08_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f8 number-purchase exp-amt-{{ $i }}-08_2019 f-08_2019" value="{{ amountCanculated(@$purchases['name'],'08_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][08_2019]" cus="exp-amt-{{$i}}-08_2019" id="08_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-07_2019" align="center"><span id="f-exp-amt-{{$i}}-07_2019">{{ amountCanculated(@$purchases['name'],'07_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f9 number-purchase exp-amt-{{ $i }}-07_2019 f-07_2019" value="{{ amountCanculated(@$purchases['name'],'07_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][07_2019]" cus="exp-amt-{{$i}}-07_2019" id="07_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-06_2019" align="center"><span id="f-exp-amt-{{$i}}-06_2019">{{ amountCanculated(@$purchases['name'],'06_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f10 number-purchase exp-amt-{{ $i }}-06_2019 f-06_2019" value="{{ amountCanculated(@$purchases['name'],'06_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][06_2019]" cus="exp-amt-{{$i}}-06_2019" id="06_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-05_2019" align="center"><span id="f-exp-amt-{{$i}}-05_2019">{{ amountCanculated(@$purchases['name'],'05_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f11 number-purchase exp-amt-{{ $i }}-05_2019 f-05_2019" value="{{ amountCanculated(@$purchases['name'],'05_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][05_2019]" cus="exp-amt-{{$i}}-05_2019" id="05_2019"/>
              </td>
            <td class="hidden_td fa-click" id="exp-amt-{{$i}}-04_2019" align="center"><span id="f-exp-amt-{{$i}}-04_2019">{{ amountCanculated(@$purchases['name'],'04_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}</span>
              <input type="text" rel="a-{{$i}}" autocomplete="off" style=" text-align: center; display:none;" class="f12 number-purchase exp-amt-{{ $i }}-04_2019 f-04_2019" value="{{ amountCanculated(@$purchases['name'],'04_2019',getPrefix(Auth::user()->id).'_tbl_purchases') }}" name="row[{{ $i }}][04_2019]" cus="exp-amt-{{$i}}-04_2019" id="04_2019"/>
              </td>
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