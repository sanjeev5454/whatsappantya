@extends('layouts.fms_admin_layouts')
@section('pageTitle', 'Dashboard')
@section('pagecontent')
<style>
table.table td {
   line-height: 0px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="page creat-fms-box1">
	<div class="page-content container-fluid1">
<form action="{{ url('admin/dataSubmitSales') }}" name="financial_summery" id="financial_summery" method="post">
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
          <th bgcolor="#4285f4"><span class="co-name" style="color:#FFFFFF;">SALES</span><span class="co-name" style="float:right;"><a class="add-sales" href="javascript:void(0);"><i class="fa fa-plus-circle" style="color:#006600; font-size:20px; float:right;" aria-hidden="true"></i></a></span></th>
          @foreach(getMonths() as $months)
          <td bgcolor="#4285f4">&nbsp;</td>
		  @endforeach
        </tr>
		
		@php
		$i=0;
		@endphp
		@foreach($sales as $key1=>$sales)
        <tr class="sales" rel="{{ @$sales['_id'] }}" id="remove-{{$i}}">
          <th class="hidden_th a-fa-click" id="a-{{$i}}">
		  <div class="product">
		  <span class="sp-a-{{$i}}">{{ @$sales['name'] }}</span>
		  <input value="{{ @$sales['name'] }}" type="text" cus="a-{{$i}}" id="{{ @$sales['_id'] }}" class="a-{{$i}} e-{{$i}} attribute" autocomplete="off" name="row[{{ $i }}][name]" style="display:none;" />&nbsp;<a style="display:none; padding:0px 0px !important;" id="a-{{$i}}" class="fa-submit-attribute fa-check-a-{{$i}}" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove" cus="{{$i}}" id="{{ @$sales['_id'] }}" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a>
		  </div>
		  </th>
		  <input value="{{ @$sales['_id'] }}" id="h-a-{{$i}}" type="hidden" name="row[{{ $i }}][id]" />
		  
          <td class="hidden_td fa-click" id="exp-amt-{{$i}}-03_2020" align="center"><span id="s-exp-amt-{{$i}}-03_2020">{{ @$sales['03_2020'] }}</span>
		  <input type="text" rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e1 number exp-amt-{{$i}}-03_2020 03_2020" value="{{ @$sales['03_2020'] }}" name="row[{{ $i }}][03_2020]" cus="exp-amt-{{$i}}-03_2020" id="03_2020"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-03_2020" class="fa-submit fa-check-exp-amt-{{$i}}-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
          <td class="hidden_td fa-click" id="exp-amt-{{$i}}-02_2020" align="center"><span id="s-exp-amt-{{$i}}-02_2020">{{ @$sales['02_2020'] }}</span>
		  <input type="text" rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e2 number exp-amt-{{$i}}-02_2020 02_2020" value="{{ @$sales['02_2020'] }}" name="row[{{ $i }}][02_2020]" cus="exp-amt-{{$i}}-02_2020" id="02_2020"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-02_2020" class="fa-submit fa-check-exp-amt-{{$i}}-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
          <td class="hidden_td fa-click" id="exp-amt-{{$i}}-01_2020" align="center"><span id="s-exp-amt-{{$i}}-01_2020">{{ @$sales['01_2020'] }}</span>
		  <input type="text" rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e3 number exp-amt-{{ $i }}-01_2020 01_2020" value="{{ @$sales['01_2020'] }}" name="row[{{ $i }}][01_2020]" cus="exp-amt-{{$i}}-01_2020" id="01_2020"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-01_2020" class="fa-submit fa-check-exp-amt-{{$i}}-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-12_2019" align="center"><span id="s-exp-amt-{{$i}}-12_2019">{{ @$sales['12_2019'] }}</span>
		  <input type="text" rel="a-{{$i}}"  autocomplete="off" style="text-align: center; display:none;" class="e4 number exp-amt-{{ $i }}-12_2019 12_2019" value="{{ @$sales['12_2019'] }}" name="row[{{ $i }}][12_2019]" cus="exp-amt-{{$i}}-12_2019" id="12_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-12_2019" class="fa-submit fa-check-exp-amt-{{$i}}-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-11_2019" align="center"><span id="s-exp-amt-{{$i}}-11_2019">{{ @$sales['11_2019'] }}</span>
		  <input type="text" rel="a-{{$i}}"  autocomplete="off" style="text-align: center; display:none;" class="e5 number exp-amt-{{ $i }}-11_2019 11_2019" value="{{ @$sales['11_2019'] }}" name="row[{{ $i }}][11_2019]"  cus="exp-amt-{{$i}}-11_2019" id="11_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-11_2019" class="fa-submit fa-check-exp-amt-{{$i}}-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-10_2019" align="center"><span id="s-exp-amt-{{$i}}-10_2019">{{ @$sales['10_2019'] }}</span>
		  <input type="text" rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e6 number exp-amt-{{ $i }}-10_2019 10_2019" value="{{ @$sales['10_2019'] }}" name="row[{{ $i }}][10_2019]" cus="exp-amt-{{$i}}-10_2019" id="10_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-10_2019" class="fa-submit fa-check-exp-amt-{{$i}}-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-09_2019" align="center"><span id="s-exp-amt-{{$i}}-09_2019">{{ @$sales['09_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e7 number exp-amt-{{ $i }}-09_2019 09_2019" value="{{ @$sales['09_2019'] }}" name="row[{{ $i }}][09_2019]" cus="exp-amt-{{$i}}-09_2019" id="09_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-09_2019" class="fa-submit fa-check-exp-amt-{{$i}}-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-08_2019" align="center"><span id="s-exp-amt-{{$i}}-08_2019">{{ @$sales['08_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e8 number exp-amt-{{ $i }}-08_2019 08_2019" value="{{ @$sales['08_2019'] }}" name="row[{{ $i }}][08_2019]" cus="exp-amt-{{$i}}-08_2019" id="08_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-08_2019" class="fa-submit fa-check-exp-amt-{{$i}}-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-07_2019" align="center"><span id="s-exp-amt-{{$i}}-07_2019">{{ @$sales['07_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e9 number exp-amt-{{ $i }}-07_2019 07_2019" value="{{ @$sales['07_2019'] }}" name="row[{{ $i }}][07_2019]" cus="exp-amt-{{$i}}-07_2019" id="07_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-07_2019" class="fa-submit fa-check-exp-amt-{{$i}}-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-06_2019" align="center"><span id="s-exp-amt-{{$i}}-06_2019">{{ @$sales['06_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e10 number exp-amt-{{ $i }}-06_2019 06_2019" value="{{ @$sales['06_2019'] }}" name="row[{{ $i }}][06_2019]" cus="exp-amt-{{$i}}-06_2019" id="06_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-06_2019" class="fa-submit fa-check-exp-amt-{{$i}}-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-05_2019" align="center"><span id="s-exp-amt-{{$i}}-05_2019">{{ @$sales['05_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e11 number exp-amt-{{ $i }}-05_2019 05_2019" value="{{ @$sales['05_2019'] }}" name="row[{{ $i }}][05_2019]" cus="exp-amt-{{$i}}-05_2019" id="05_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-05_2019" class="fa-submit fa-check-exp-amt-{{$i}}-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		  <td class="hidden_td fa-click" id="exp-amt-{{$i}}-04_2019" align="center"><span id="s-exp-amt-{{$i}}-04_2019">{{ @$sales['04_2019'] }}</span>
		  <input type="text"  rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e12 number exp-amt-{{ $i }}-04_2019 04_2019" value="{{ @$sales['04_2019'] }}" name="row[{{ $i }}][04_2019]" cus="exp-amt-{{$i}}-04_2019" id="04_2019"/><a style="display:none; padding:0px 0px !important;" id="exp-amt-{{$i}}-04_2019" class="fa-submit fa-check-exp-amt-{{$i}}-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
		  </td>
		 
        </tr>
		@php
		$i++;
		@endphp
		@endforeach
		
		
        <tr id="e">
          <th align="right" style="text-align:right; font-weight:bold;"><span class="co-name">Total Sales =</span></th>
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
       
      </tbody>
    </table>
	
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
        url: "{{ url('admin/dataSubmitSales') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['sales_id']);
		  $('.exp-amt').attr('id', data['sales_id']);
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
   $('.'+id).hide();
   $('.sp-'+id).show();
   var id_db = $('#h-'+id).val();
   var name_val = $('.'+id).val();
   var column_name = 'name';
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitSales') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id).val(data['sales_id']);
		  $('.exp-amt').attr('id', data['sales_id']);
		  }
        }
      });
    });
});
</script>

<script>
$(function(){
   $(document).on('click','.add-sales',function(){
   
      var rowCount = $('#table-basic >tbody >tr').length;
       $('#e').before('<tr class="sales" rel="" id="remove-'+(rowCount+1)+'"> <th class="hidden_th a-fa-click" id="a-'+(rowCount+1)+'"><div class="product"> <span class="sp-a-'+(rowCount+1)+'" style="display:none;"></span> <input value="" type="text" cus="a-'+(rowCount+1)+'" class="a-'+(rowCount+1)+' e-'+(rowCount+1)+' attribute" autocomplete="off" name="row['+(rowCount+1)+'][name]" />&nbsp;<a style="padding:0px 0px !important;" id="a-'+(rowCount+1)+'" class="fa-submit-attribute fa-check-a-'+(rowCount+1)+'" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove exp-amt" cus="'+(rowCount+1)+'" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></th><input value="" type="hidden" id="h-a-'+(rowCount+1)+'" name="row['+(rowCount+1)+'][id]" /> <td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-03_2020" align="center"><span id="s-exp-amt-'+(rowCount+1)+'-03_2020" style="display:none;"></span> <input rel="a-'+(rowCount+1)+'" type="text" autocomplete="off" style="text-align: center;" class="e1 number exp-amt-'+(rowCount+1)+'-03_2020 03_2020" value="" name="row['+(rowCount+1)+'][03_2020]" cus="exp-amt-'+(rowCount+1)+'-03_2020" id="03_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-03_2020" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-03_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-02_2020" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-02_2020"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e2 number exp-amt-'+(rowCount+1)+'-02_2020 02_2020" value="" name="row['+(rowCount+1)+'][02_2020]" cus="exp-amt-'+(rowCount+1)+'-02_2020" id="02_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-02_2020" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-02_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-01_2020" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-01_2020"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e3 number exp-amt-'+(rowCount+1)+'-01_2020 01_2020" value="" name="row['+(rowCount+1)+'][01_2020]" cus="exp-amt-'+(rowCount+1)+'-01_2020" id="01_2020"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-01_2020" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-01_2020" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-12_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-12_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e4 number exp-amt-'+(rowCount+1)+'-12_2019 12_2019" value="" name="row['+(rowCount+1)+'][12_2019]" cus="exp-amt-'+(rowCount+1)+'-12_2019" id="12_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-12_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-12_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-11_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-11_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e5 number exp-amt-'+(rowCount+1)+'-11_2019 11_2019" value="" name="row['+(rowCount+1)+'][11_2019]" cus="exp-amt-'+(rowCount+1)+'-11_2019" id="11_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-11_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-11_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-10_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-10_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e6 number exp-amt-'+(rowCount+1)+'-10_2019 10_2019" value="" name="row['+(rowCount+1)+'][10_2019]" cus="exp-amt-'+(rowCount+1)+'-10_2019" id="10_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-10_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-10_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-09_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-09_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e7 number exp-amt-'+(rowCount+1)+'-09_2019 09_2019" value="" name="row['+(rowCount+1)+'][09_2019]" cus="exp-amt-'+(rowCount+1)+'-09_2019" id="09_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-09_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-09_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-08_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-08_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e8 number exp-amt-'+(rowCount+1)+'-08_2019 08_2019" value="" name="row['+(rowCount+1)+'][08_2019]" cus="exp-amt-'+(rowCount+1)+'-08_2019" id="08_2019"/><a style="padding:0px 0px !important;" id="exp-amt-'+(rowCount+1)+'-08_2019" cus="exp-amt" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-08_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-07_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-07_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e9 number exp-amt-'+(rowCount+1)+'-07_2019 07_2019" value="" name="row['+(rowCount+1)+'][07_2019]" cus="exp-amt-'+(rowCount+1)+'-07_2019" id="07_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-07_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-07_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-06_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-06_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e10 number exp-amt-'+(rowCount+1)+'-06_2019 06_2019" value="" name="row['+(rowCount+1)+'][06_2019]" cus="exp-amt-'+(rowCount+1)+'-06_2019" id="06_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-06_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-06_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-05_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-05_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e11 number exp-amt-'+(rowCount+1)+'-05_2019 05_2019" value="" name="row['+(rowCount+1)+'][05_2019]" cus="exp-amt-'+(rowCount+1)+'-05_2019" id="05_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-05_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-05_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="exp-amt-'+(rowCount+1)+'-04_2019" align="center"><span style="display:none;" id="s-exp-amt-'+(rowCount+1)+'-04_2019"></span> <input type="text"  rel="a-'+(rowCount+1)+'" autocomplete="off" style="text-align: center;" class="e12 number exp-amt-'+(rowCount+1)+'-04_2019 04_2019" value="" name="row['+(rowCount+1)+'][04_2019]" cus="exp-amt-'+(rowCount+1)+'-04_2019" id="04_2019"/><a style="padding:0px 0px !important;" cus="exp-amt" id="exp-amt-'+(rowCount+1)+'-04_2019" class="fa-submit fa-check-exp-amt-'+(rowCount+1)+'-04_2019" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td></tr>');
	   $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
$(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");


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
		url: "{{ url('admin/dataRemoveSales')}}/"+id,
		data: {id:id},
        success: function( response ) {
		   //alert(response); return false;
          $('#remove-'+row_chk).remove();
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
$(function(){

  $(document).on('keypress','.number',function(e) {
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
   $(document).on('keyup','.number',function(){
        var amount = $(this).val();
		var cus = $(this).attr('cus');
		var id = $(this).attr('id');
		$('#s-'+cus).html(amount);
		$('#f-'+cus).html(amount);
		var subTotal = 0;
		$("."+id).each(function () {
		var stval = parseFloat($(this).val());
		subTotal += isNaN(stval) ? 0 : stval;
		});
		
		$('.tot-'+id).html(subTotal.toLocaleString('en-IN'));
		
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
   $(document).on('keyup','.attribute',function(){
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
	 //$('#financial_summery').submit(); return false;
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
   var id = $(this).attr('cus');
   //alert(id); return false;
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
        url: "{{ url('admin/dataSubmitSales') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response); return false;
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id).val(data['sales_id']);
		  $('.exp-amt').attr('id', data['sales_id']);
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
   $('.fa-check-'+id).hide();
   $('.'+id).hide();
   var name_val = $(this).val();
   var column_name = $(this).attr('id');
   var id_rel = $(this).attr('rel');
   var id_db = $('#h-'+id_rel).val();
   $('#s-'+id).show();
   $('#f-'+id).show();
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: "{{ url('admin/dataSubmitSales') }}" ,
        type: "POST",
        data: {name_val:name_val,column_name:column_name,id_db:id_db},
        success: function( response ) {
          //alert(response);
		  if(response!='')
		  {
		  data = JSON.parse(response);
		  $('#h-'+id_rel).val(data['sales_id']);
		  $('.exp-amt').attr('id', data['sales_id']);
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

<style type="text/css">
.page-content{ padding:0; }
table.table.fixed_table tr.blue-box th, table.table.fixed_table tr.blue-box td{ text-align: center; }
</style>
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
