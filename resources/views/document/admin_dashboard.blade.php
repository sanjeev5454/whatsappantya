@extends('document.layout.app')
@section('title', 'Dashboard')
@section('content')
@include('document.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="full-wrap body-box page">
  <div class="full-wrap table-box">
    <div class="container">
      <form action="{{ url('document/dataSubmit') }}" name="financial_summery" id="financial_summery" method="post">
        @csrf
        <div class="table-scrollable">
          <table cellspacing="0" id="table-basic" class="table table-bordered table-hover table-striped dataTable">
            <tbody>
              <tr class="task_top_fix htf2">
                <th class="task_left_fix" style="width:200px;"><strong>Documentation List</strong></th>
                <th align="center" style="text-align:center;"><strong>Link (Click to download)</strong></th>
                <th class="select-box" style="width:70px; text-align:center;"><strong>Select</strong></th>
              </tr>
            @php
            $i=0;
            @endphp
            @foreach($category as $c=>$category_all)
            <tr class="blue-box" id="{{$category_all['_id']}}">
              <td><span class="co-name">{{ $category_all['label_name'] }}</span> <span class="co-name" style="float:right;"><!--<a class="add-pan-cards" href="javascript:void(0);"><i class="fa fa-plus-circle" style="color:#006600; font-size:20px; float:right;" aria-hidden="true"></i></a>--></span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            @foreach(pan_cards($category_all['_id']) as $key1=>$pan_cards)
            <tr class="pan_cards" id="remove-{{$i}}">
              <td class="hidden_th a-fa-click" id="a-{{$i}}"><div class="product"> <span class="sp-a-{{$i}}">{{ @$pan_cards['name'] }}</span>
                  <input value="{{ @$pan_cards['name'] }}" placeholder="Name" type="text" cus="a-{{$i}}" class="a-{{$i}} e-{{$i}} attribute" autocomplete="off" name="row[{{ $i }}][name]" style="display:none;" />
                  &nbsp;<a style="display:none; padding:0px 0px !important;" id="a-{{$i}}" class="fa-submit-attribute fa-check-a-{{$i}}" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove" cus="{{$i}}" id="{{ @$pan_cards['_id'] }}" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div></td>
              <input id="cat-type-a-{{$i}}" value="{{ $category_all['_id'] }}" type="hidden" name="row[{{ $i }}][cat_id]" />
              <input id="type-a-{{$i}}" value="pan_cards" type="hidden" name="row[{{ $i }}][type]" />
              <input id="field-id-pan-amt-{{$i}}-link" value="{{ @$pan_cards['file_id'] }}" type="hidden" name="row[{{ $i }}][field_id]" />
              <input value="{{ @$pan_cards['_id'] }}" id="h-a-{{$i}}" type="hidden" name="row[{{ $i }}][id]" />
              <td class="hidden_td fa-click" id="pan-amt-{{$i}}-link" align="center"><div class="center-div"> <span class="link link-data" id="s-pan-amt-{{$i}}-link">{{ @$pan_cards['link'] }}</span>
                  <input type="text" rel="a-{{$i}}" autocomplete="off" style="text-align: center; display:none;" class="e1 number link input-pan-amt-{{$i}}-link" value="{{ @$pan_cards['link'] }}" name="row[{{ $i }}][link]" cus="pan-amt-{{$i}}-link" id="link" />
                  <div class="drive-btn">
                    <button rel="a-{{$i}}" type="button" style="display:none;" class="btn btn-primary g-local-pop-up e1 number link gdrive ldrive ldrive-pan-amt-{{$i}}-link" value="" name="row[{{$i}}][link]" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Local-Drive" cus="pan-amt-{{$i}}-link" id="link">Upload</button>
                    <button rel="a-{{$i}}" type="button" class="btn btn-primary g-drive-pop-up e1 number link gdrive gdrive-pan-amt-{{$i}}-link" value="" name="row[{{$i}}][link]" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Google-Drive" style="display:none;" cus="pan-amt-{{$i}}-link" id="link">Link with google drive</button>
                  </div>
                  <a href="javascript:void(0);" class="gdrive-icon" id="pan-amt-{{$i}}-link"><i style="display:none1;" class="fa fa-pencil-square-o gdrive-icon-pan-amt-{{$i}}-link" aria-hidden="true"></i></a> <a class="remove-link-{{$i}} remove-link" cus="{{$i}}" id="{{ @$pan_cards['_id'] }}" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> <a style="display:none; padding:0px 0px !important;" id="pan-amt-{{$i}}-link" class="fa-submit fa-check-pan-amt-{{$i}}-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></div></td>
              <td class="hidden_td fa-click" id="pan-amt-{{$i}}-select" align="center"><input type="checkbox" id="{{ @$pan_cards['file_id'] }}" class="select-{{$i}} sel" value="{{ @$pan_cards['_id'] }}" /></td>
            </tr>
            @php          
            
            $i++;          
            
            @endphp          
            
            @endforeach
            <tr id="add_doc_{{$category_all['_id']}}"></tr>
            @endforeach
            <tr id="result-votor" class="blue-box"> </tr>
              </tbody>
            
          </table>
        </div>
        <div id="email-send-btn" style="float:right; margin-top:10px; margin-right:10px; display:none;">
          <button type="button" class="btn btn-success btn-sm mail-send" data-toggle="modal" data-target="#myModal">Send Mail</button>
        </div>
        <input type="hidden" class="pop-up-data" />
      </form>
    </div>
  </div>
  <div class="full-wrap">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-15 mt-15">@include('document.layout.tabbing')</div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
 $(function() {
        $(document).on('click','.gdrive',function(){
           $('#button-reload').trigger('click');
		   var rel_data = $(this).attr('rel');
		   $('.pop-up-data').val(rel_data);
        });
    });
</script> 
<script>
    $(function() {
        $(document).on('click','.btn-save',function(){
		   var name = $(this).attr('name');
		   var id = $(this).attr('id');
		   var rel_data = $('.pop-up-data').val();
		   var sd_r = rel_data.replace(/[^0-9]/gi, ''); 
           var number = parseInt(sd_r, 10);
		   //alert('.pan-amt-'+number+'-link'+name); return false;
		   //Pan Card Start
		   $('.pan-amt-'+number+'-link').val(name);
		   $('#s-pan-amt-'+number+'-link').html(name);
		   $('.input-pan-amt-'+number+'-link').val(name);
		   $('.input-pan-amt-'+number+'-link').hide();
		   $('#s-pan-amt-'+number+'-link').show();
		   $('.gdrive-pan-amt-'+number+'-link').hide();
		   $('.ldrive-pan-amt-'+number+'-link').hide();
		   $('#field-id-pan-amt-'+number+'-link').val(id);
		   $('#pan-amt-'+number+'-link').trigger('click');
		   $('.remove-link-'+number).show();
		   //Pan Card End
		   
		    var id = 'pan-amt-'+number+'-link';
      var name_val = $('.input-' + id).val();
      var column_name = $('.input-' + id).attr('id');
      var id_rel = $('.input-' + id).attr('rel');
      var id_db = $('#h-' + id_rel).val();
      var type = $('#type-' + id_rel).val();
     var cat_id = $('#cat-type-' + id_rel).val();
	  var field_id = $('#field-id-' + id).val();
	  //alert(name_val); return false;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  field_id:field_id,
		  
		  cat_id:cat_id
        },
        success: function(response) {
          //alert(response);
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id_rel).val(data['pan_cards_id']);
              $('.d-' + id_rel).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
			  $('.gdrive-icon-' + id).show();
            }
            if (type == 'passports') {
              $('#h-' + id_rel).val(data['passports_id']);
              $('.d-' + id_rel).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id_rel).val(data['aadhar_card_id']);
              $('.d-' + id_rel).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id_rel).val(data['driving_licence_id']);
              $('.d-' + id_rel).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id_rel).val(data['voter_id']);
              $('.d-' + id_rel).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
          }
        }
      });
		   
		   
        });
    });
</script> 
<script>
    $(function() {
        $(document).on('click','.btn-select-local',function(){
		   var name = $(this).attr('name');
		   var rel_data = $('.pop-up-data').val();
		   var sd_r = rel_data.replace(/[^0-9]/gi, ''); 
           var number = parseInt(sd_r, 10);
		   //alert(name+'-'+id+'-'+rel_data+'-'+sd_r+'-'+number); return false;
		   //Pan Card Start
		   $('.pan-amt-'+number+'-link').val(name);
		   $('#s-pan-amt-'+number+'-link').html(name);
		   $('#s-pan-amt-'+number+'-link').show();
		   $('.input-pan-amt-'+number+'-link').val(name);
		   $('.input-pan-amt-'+number+'-link').hide();
		   $('.gdrive-pan-amt-'+number+'-link').hide();
		   $('.ldrive-pan-amt-'+number+'-link').hide();
		   $('#field-id-pan-amt-'+number+'-link').val(id);
		   $('#pan-amt-'+number+'-link').trigger('click');
		   $('.remove-link-'+number).show();
		   //Pan Card End
      var id = 'pan-amt-'+number+'-link';
      var name_val = $('.input-' + id).val();
      var column_name = $('.input-' + id).attr('id');
      var id_rel = $('.input-' + id).attr('rel');
      var id_db = $('#h-' + id_rel).val();
      var type = $('#type-' + id_rel).val();
      
	  var cat_id = $('#cat-type-' + id_rel).val();
	  
	  var field_id = $('#field-id-' + id).val();
	  //alert(name_val); return false;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  field_id:field_id,
		  
		  cat_id:cat_id
        },
        success: function(response) {
          //alert(response);
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id_rel).val(data['pan_cards_id']);
              $('.d-' + id_rel).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
			  $('.gdrive-icon-' + id).show();
            }
            if (type == 'passports') {
              $('#h-' + id_rel).val(data['passports_id']);
              $('.d-' + id_rel).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id_rel).val(data['aadhar_card_id']);
              $('.d-' + id_rel).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id_rel).val(data['driving_licence_id']);
              $('.d-' + id_rel).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id_rel).val(data['voter_id']);
              $('.d-' + id_rel).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
          }
        }
      });
		   
		   
        });
    });
</script> 
<script>
$(function(){
       $(document).on('click','.link-data',function(){
	        var fileId = $(this).attr('id');
			var sd = fileId.replace(/[^0-9]/gi, ''); 
            var number = parseInt(sd, 10);
			var d = $('.select-'+number).val();
			if(d!='')
			{
			$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
			});
			
			$.ajax({
			url: "{{ url('document/pageRedirect') }}",
			type: "POST",
			data: {
			d: d
			},
			success: function(response) {
			//alert(response);
            data = JSON.parse(response);
			if (data['source_type'] == 'gdrive' && data['file_id']!='') {
            window.open('https://drive.google.com/uc?id='+data['file_id']+'&export=download', '_blank');
			
			}
			
			if (data['source_type'] == 'ldrive' && data['file_id']!='') {
			window.open('{{ url("public/google_drive_file/") }}/'+data['file_id']+'/'+data['link'], '_blank');
			}
			}
			});
			}
	   });
});
</script> 
<script>
  $(function() {
    $(document).on('click', '.fa-submit', function() {
      var id = $(this).attr('id');
      var cus = $(this).attr('cus');
      var sd = id.replace(/[^0-9]/gi, ''); 
      var number = parseInt(sd, 10);
	  //alert(id); return false;
      $(this).hide();
      $('.input-' + id).hide();
	  $('.gdrive-' + id).hide();
	  $('.gdrive-icon-' + id).hide();
      $('#s-' + id).show();
      $('#f-' + id).show();
      var name_val = $('.input-' + id).val();
      var column_name = $('.input-' + id).attr('id');
      var id_rel = $('.input-' + id).attr('rel');
      var id_db = $('#h-' + id_rel).val();
      var type = $('#type-' + id_rel).val();
      var cat_id = $('#cat-type-'+id_rel).val();
	  var field_id = $('#field-id-' + id).val();
	  //alert(name_val); return false;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  field_id:field_id,
		  
		  cat_id:cat_id
        },
        success: function(response) {
          //alert(response);
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id_rel).val(data['pan_cards_id']);
              $('.d-' + id_rel).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
			  $('.gdrive-icon-' + id).show();
            }
            if (type == 'passports') {
              $('#h-' + id_rel).val(data['passports_id']);
              $('.d-' + id_rel).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id_rel).val(data['aadhar_card_id']);
              $('.d-' + id_rel).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id_rel).val(data['driving_licence_id']);
              $('.d-' + id_rel).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id_rel).val(data['voter_id']);
              $('.d-' + id_rel).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
          }
        }
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.fa-submit-attribute', function() {
      var id = $(this).attr('id');
      var cus = $(this).attr('cus');
	  var sd = id.replace(/[^0-9]/gi, ''); 
      var number = parseInt(sd, 10);
	  //alert(number); return false;
      $(this).hide();
      $('.' + id).hide();
      $('.sp-' + id).show();
      var id_db = $('#h-' + id).val();
      var name_val = $('.' + id).val();
      var column_name = 'name';
      var type = $('#type-' + id).val();
      var cat_id = $('#cat-type-' + id).val();
	  
	  var field_id = $('#field-id-pan-amt-'+number+'-link').val();
     // alert(field_id); return false;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  
		  cat_id:cat_id,
		  field_id:field_id
        },
        success: function(response) {
          //alert(response); return false;
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id).val(data['pan_cards_id']);
              $('.d-' + id_rel).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
            }
            if (type == 'passports') {
              $('#h-' + id).val(data['passports_id']);
              $('.d-' + id_rel).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id).val(data['aadhar_card_id']);
              $('.d-' + id_rel).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id).val(data['driving_licence_id']);
              $('.d-' + id_rel).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id).val(data['voter_id']);
              $('.d-' + id_rel).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
          }
        }
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.add-pan-cards', function() {
      //$('.add-doc').trigger('click');
      //$('.modal-backdrop').remove();
      var rowCount = $('#table-basic >tbody >tr').length;
       var id = $('.select_document').val();
      //alert(id); return false;
      $('#add_doc_'+id).before('<tr class="pan_cards" id="remove-' + (rowCount + 1) + '"><td class="hidden_th a-fa-click" id="a-' + (rowCount + 1) + '"><div class="product"><span class="sp-a-' + (rowCount + 1) + '" style="display:none;"></span><input value="" placeholder="Document Name" type="text" cus="a-' + (rowCount + 1) + '"  class="a-' + (rowCount + 1) + ' e-' + (rowCount + 1) + ' attribute" autocomplete="off" name="row[' + (rowCount + 1) + '][name]" style="display:none1;" />&nbsp;<a style="padding:0px 0px !important;" id="a-' + (rowCount + 1) + '" class="fa-submit-attribute fa-check-a-' + (rowCount + 1) + '" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove d-a-' + (rowCount + 1) + '" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a></div></td><input id="cat-type-a-' + (rowCount + 1) + '" value="'+id+'" type="hidden" name="row[' + (rowCount + 1) + '][cat_id]" /><input id="type-a-' + (rowCount + 1) + '" value="pan_cards" type="hidden" name="row[' + (rowCount + 1) + '][type]" /><input value="" id="h-a-' + (rowCount + 1) + '" type="hidden" name="row[' + (rowCount + 1) + '][id]" /><input id="field-id-pan-amt-' + (rowCount + 1) + '-link" value="" type="hidden" name="row[' + (rowCount + 1) + '][field_id]" /><td class="hidden_td fa-click" id="pan-amt-' + (rowCount + 1) + '-link" align="center"><div class="center-div"><span class="link link-data" id="s-pan-amt-' + (rowCount + 1) + '-link" style="display:none;"></span><input type="text" rel="a-' + (rowCount + 1) + '" autocomplete="off" style="text-align: center; display:none;" class="e1 number input-pan-amt-' + (rowCount + 1) + '-link link" value="" name="row[' + (rowCount + 1) + '][link]" cus="pan-amt-' + (rowCount + 1) + '-link" id="link"/><div class="drive-btn"><button rel="a-' + (rowCount + 1) + '" type="button" class="btn btn-primary g-local-pop-up e1 number link ldrive gdrive ldrive-pan-amt-' + (rowCount + 1) + '-link" value="" name="row[' + (rowCount + 1) + '][link]" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Local-Drive" cus="pan-amt-' + (rowCount + 1) + '-link" id="link">Upload</button><button rel="a-' + (rowCount + 1) + '" type="button" class="btn btn-primary g-drive-pop-up e1 number link gdrive gdrive-pan-amt-' + (rowCount + 1) + '-link" value="" name="row[' + (rowCount + 1) + '][link]" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Google-Drive" cus="pan-amt-' + (rowCount + 1) + '-link" id="link">Link with google drive</button></div><a style="padding:0px 0px !important; display:none;" id="pan-amt-' + (rowCount + 1) + '-link" class="fa-submit fa-check-pan-amt-' + (rowCount + 1) + '-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a><a href="javascript:void(0);" class="gdrive-icon" id="pan-amt-' + (rowCount + 1) + '-link"><i style="display:none;" class="fa fa-pencil-square-o gdrive-icon-pan-amt-' + (rowCount + 1) + '-link" aria-hidden="true"></i></a><a style="display:none;" class="remove-link-' + (rowCount + 1) + ' remove-link" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a></div></td><td class="hidden_td fa-click" id="pan-amt-' + (rowCount + 1) + '-select" align="center"><input type="checkbox" class="select-' + (rowCount + 1) + ' sel" value="" /></td></tr>');
      $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
      $(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
      $('.e-' + (rowCount + 1)).focus();
      $(".hidden_td").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
        var amount = $('.' + id).val();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
      $(".hidden_th").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.add-passports', function() {
      var rowCount = $('#table-basic >tbody >tr').length;
      $('#pass').before('<tr class="passports" id="remove-' + (rowCount + 1) + '"> <th class="hidden_th a-fa-click" id="a-' + (rowCount + 1) + '"> <div class="product"> <span class="sp-a-' + (rowCount + 1) + '" style="display:none;"></span> <input value="" type="text" cus="a-' + (rowCount + 1) + '" class="a-' + (rowCount + 1) + ' e-' + (rowCount + 1) + ' attribute" autocomplete="off" name="row[' + (rowCount + 1) + '][name]" style="display:none1;" />&nbsp;<a style="padding:0px 0px !important;" id="a-' + (rowCount + 1) + '" class="fa-submit-attribute fa-check-a-' + (rowCount + 1) + '" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove d-a-' + (rowCount + 1) + '" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div> </th> <input id="type-a-' + (rowCount + 1) + '" value="passports" type="hidden" name="row[' + (rowCount + 1) + '][type]" /> <input value="" id="h-a-' + (rowCount + 1) + '" type="hidden" name="row[' + (rowCount + 1) + '][id]" /> <td class="hidden_td fa-click" id="pass-amt-' + (rowCount + 1) + '-link" align="center"><span class="link" id="f-pass-amt-' + (rowCount + 1) + '-link" style="display:none;"></span> <input type="text" rel="a-' + (rowCount + 1) + '" autocomplete="off" style="text-align: center; display:none1;" class="f1 number pass-amt-' + (rowCount + 1) + '-link link" value="" name="row[' + (rowCount + 1) + '][link]" cus="pass-amt-' + (rowCount + 1) + '-link" id="link"/><a style="padding:0px 0px !important;" id="pass-amt-' + (rowCount + 1) + '-link" class="fa-submit fa-check-pass-amt-' + (rowCount + 1) + '-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="pass-amt-' + (rowCount + 1) + '-select" align="center"> <input type="checkbox" class="select-' + (rowCount + 1) + ' sel" value="" /> </td> </tr>');
      $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
      $(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
      $('.e-' + (rowCount + 1)).focus();
      $(".hidden_td").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
        var amount = $('.' + id).val();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
      $(".hidden_th").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.add-aadhar-card', function() {
      var rowCount = $('#table-basic >tbody >tr').length;
      $('#aadhar').before('<tr class="aadhar_card" id="remove-' + (rowCount + 1) + '"><th class="hidden_th a-fa-click" id="a-' + (rowCount + 1) + '"><div class="product"><span class="sp-a-' + (rowCount + 1) + '" style="display:none;"></span><input value="" type="text" cus="a-' + (rowCount + 1) + '"  class="a-' + (rowCount + 1) + ' e-' + (rowCount + 1) + ' attribute" autocomplete="off" name="row[' + (rowCount + 1) + '][name]" style="display:none1;" />&nbsp;<a style="padding:0px 0px !important;" id="a-' + (rowCount + 1) + '" class="fa-submit-attribute fa-check-a-' + (rowCount + 1) + '" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove d-a-' + (rowCount + 1) + '" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a></div></th><input id="type-a-' + (rowCount + 1) + '" value="aadhar_card" type="hidden" name="row[' + (rowCount + 1) + '][type]" /><input value="" id="h-a-' + (rowCount + 1) + '" type="hidden" name="row[' + (rowCount + 1) + '][id]" /><td class="hidden_td fa-click" id="aadhar-amt-' + (rowCount + 1) + '-link" align="center"><span class="link" id="f-aadhar-amt-' + (rowCount + 1) + '-link" style="display:none;"></span><input type="text" rel="a-' + (rowCount + 1) + '" autocomplete="off" style="text-align: center; display:none1;" class="f1 number aadhar-amt-' + (rowCount + 1) + '-link link" value="" name="row[' + (rowCount + 1) + '][link]" cus="aadhar-amt-' + (rowCount + 1) + '-link" id="link"/><a style="padding:0px 0px !important;" id="aadhar-amt-' + (rowCount + 1) + '-link" class="fa-submit fa-check-aadhar-amt-' + (rowCount + 1) + '-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a></td><td class="hidden_td fa-click" id="aadhar-amt-' + (rowCount + 1) + '-select" align="center"><input type="checkbox" class="select-' + (rowCount + 1) + ' sel" value="" /></td></tr>');
      $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
      $(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
      $(".hidden_td").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
        var amount = $('.' + id).val();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
      $(".hidden_th").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.add-driving-licence', function() {
      var rowCount = $('#table-basic >tbody >tr').length;
      $('#driving').before('<tr class="driving_licence" id="remove-' + (rowCount + 1) + '"> <th class="hidden_th a-fa-click" id="a-' + (rowCount + 1) + '"> <div class="product"> <span class="sp-a-' + (rowCount + 1) + '" style="display:none;"></span> <input value="" type="text" cus="a-' + (rowCount + 1) + '" class="a-' + (rowCount + 1) + ' e-' + (rowCount + 1) + ' attribute" autocomplete="off" name="row[' + (rowCount + 1) + '][name]" style="display:none1;" />&nbsp;<a style="padding:0px 0px !important;" id="a-' + (rowCount + 1) + '" class="fa-submit-attribute fa-check-a-' + (rowCount + 1) + '" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove d-a-' + (rowCount + 1) + '" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div> </th> <input id="type-a-' + (rowCount + 1) + '" value="driving_licence" type="hidden" name="row[' + (rowCount + 1) + '][type]" /> <input value="" id="h-a-' + (rowCount + 1) + '" type="hidden" name="row[' + (rowCount + 1) + '][id]" /> <td class="hidden_td fa-click" id="driving-amt-' + (rowCount + 1) + '-link" align="center"><span class="link" id="f-driving-amt-' + (rowCount + 1) + '-link" style="display:none;"></span> <input type="text" rel="a-' + (rowCount + 1) + '" autocomplete="off" style="text-align: center; display:none1;" class="f1 number driving-amt-' + (rowCount + 1) + '-link f-link" value="" name="row[' + (rowCount + 1) + '][link]" cus="driving-amt-' + (rowCount + 1) + '-link" id="link"/><a style="padding:0px 0px !important;" id="driving-amt-' + (rowCount + 1) + '-link" class="fa-submit fa-check-driving-amt-' + (rowCount + 1) + '-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="driving-amt-' + (rowCount + 1) + '-select" align="center"> <input type="checkbox" class="select-' + (rowCount + 1) + ' sel" value="" /> </td> </tr>');
      $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
      $(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
      $(".hidden_td").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
        var amount = $('.' + id).val();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
      $(".hidden_th").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('click', '.add-voter-id', function() {
      var rowCount = $('#table-basic >tbody >tr').length;
      $('#result-votor').before('<tr class="voter_id" id="remove-' + (rowCount + 1) + '"> <th class="hidden_th a-fa-click" id="a-' + (rowCount + 1) + '"> <div class="product"> <span class="sp-a-' + (rowCount + 1) + '" style="display:none;"></span> <input value="" type="text" cus="a-' + (rowCount + 1) + '" class="a-' + (rowCount + 1) + ' e-' + (rowCount + 1) + ' attribute" autocomplete="off" name="row[' + (rowCount + 1) + '][name]" style="display:none1;" />&nbsp;<a style="padding:0px 0px !important;" id="a-' + (rowCount + 1) + '" class="fa-submit-attribute fa-check-a-' + (rowCount + 1) + '" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>&nbsp;<a class="remove d-a-' + (rowCount + 1) + '" cus="' + (rowCount + 1) + '" id="" href="javascript:void(0);"><i class="fa fa-trash" style="font-size:15px; color:#FF0000;" aria-hidden="true"></i></a> </div> </th> <input id="type-a-' + (rowCount + 1) + '" value="voter_id" type="hidden" name="row[' + (rowCount + 1) + '][type]" /> <input value="" id="h-a-' + (rowCount + 1) + '" type="hidden" name="row[' + (rowCount + 1) + '][id]" /> <td class="hidden_td fa-click" id="voter-amt-' + (rowCount + 1) + '-link" align="center"><span class="link" id="f-voter-amt-' + (rowCount + 1) + '-link" style="display:none;"></span> <input type="text" rel="a-' + (rowCount + 1) + '" autocomplete="off" style="text-align: center; display:none1;" class="f1 number voter-amt-' + (rowCount + 1) + '-link f-link" value="" name="row[' + (rowCount + 1) + '][link]" cus="voter-amt-' + (rowCount + 1) + '-link" id="link"/><a style="display:none; padding:0px 0px !important;" id="voter-amt-' + (rowCount + 1) + '-link" class="fa-submit fa-check-voter-amt-' + (rowCount + 1) + '-link" href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> </td> <td class="hidden_td fa-click" id="voter-amt-' + (rowCount + 1) + '-select"> <input type="checkbox" class="select-' + (rowCount + 1) + ' sel" value="" /> </td> </tr>');
      $(".hover-edit tbody tr th:first-child").addClass("task_left_fix");
      $(".hover-edit tbody tr th:first-child th").wrapAll("<div class='heading-box'></div>");
      $(".hidden_td").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
        var amount = $('.' + id).val();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
      $(".hidden_th").hover(function() {
        var id = $(this).attr('id');
        $('.fa-' + id).show();
      }, function() {
        var id = $(this).attr('id');
        $('.fa-' + id).hide();
      });
    });
  });
</script> 
<script>
$(function(){
$(document).on('click', '.remove-link', function() {
  var id = $(this).attr('id');
  var cus = $(this).attr('cus');
  if(id!='')
  {
  var check_verify_one = confirm("Are you sure to delete the link?");
  if (check_verify_one) {
  
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
		  $('#s-pan-amt-'+cus+'-link').html('');
		  $('.input-pan-amt-'+cus+'-link').val('');
		  $('.ldrive-pan-amt-'+cus+'-link').show();
		  $('.gdrive-pan-amt-'+cus+'-link').show();
          $.ajax({
            type: "GET",
            url: "{{ url('document/dataLinkRemove')}}/" + id,
            data: {
              id: id
            },
            success: function(response) {
              //alert(response); return false;
              //$('#remove-' + row_chk).remove();
            }
          });
        
  }
  }
});
});
</script> 
<script>
  $(function() {
    $(document).on('click', '.remove', function() {
      var row_chk = $(this).attr('cus');
      var id = $(this).attr('id');
      if (id == '') {
        var check_verify_one = confirm("Are you sure to delete the row?");
        if (check_verify_one) {
          //alert(row_chk); return false;
          $('#remove-' + row_chk).remove();
        }
      } else {
        var check_verify = confirm("Are you sure to delete the row?");
        if (check_verify) {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
		  $('#remove-' + row_chk).remove();
          $.ajax({
            type: "GET",
            url: "{{ url('document/dataRemove')}}/" + id,
            data: {
              id: id
            },
            success: function(response) {
              //alert(response); return false;
              $('#remove-' + row_chk).remove();
            }
          });
        }
      }
    });
  });
</script> 
<script>
  $(".hidden_td").hover(function() {
    var id = $(this).attr('id');
    $('.fa-' + id).show();
    // $('#s-'+id).hide();
    //$('#f-'+id).hide();
    var amount = $('.' + id).val();
  }, function() {
    var id = $(this).attr('id');
    $('.fa-' + id).hide();
    //$('#s-'+id).show();
    //$('#f-'+id).show();
  });
</script> 
<script>
  $(".hidden_th").hover(function() {
    var id = $(this).attr('id');
    $('.fa-' + id).show();
  }, function() {
    var id = $(this).attr('id');
    $('.fa-' + id).hide();
  });
</script> 
<script>
  $(function() {
    $(document).on('keyup', '.number', function() {
      var amount = $(this).val();
      var cus = $(this).attr('cus');
      var id = $(this).attr('id');
      //alert(cus); return false;
      $('#s-' + cus).html(amount);
      $('#f-' + cus).html(amount);
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('keyup', '.attribute', function() {
      var attribute_val = $(this).val();
      var id = $(this).attr('cus');
      $('.sp-' + id).html(attribute_val);
	  
    });
  });
</script> 
<script>
$(function() {
$(document).on('click', '.gdrive-icon', function() {
  var id = $(this).attr('id');
  $('.gdrive-' + id).show();
   $('.ldrive-' + id).show();
  $('.gdrive-icon-' + id).hide();
  //$(".gdrive-" + id + "option[value='']").attr('selected', true);
  //$('.fa-check-' + id).show();
	  $('.' + id).focus();
	  $('.' + id).show();
	  $('#f-' + id).hide();
});
});
</script> 
<script>
  $(function() {
    $(document).on('dblclick', '.fa-click', function() {
      var id = $(this).attr('id');
      //$('.' + id).show();
	  //$('.gdrive-' + id).show();
	  //$('.gdrive-icon-' + id).show();
	  //$('.ldrive-icon-' + id).show();
     // $('.' + id).select();
     // $('.' + id).focus();
      //$('#s-' + id).hide();
     // $('#f-' + id).hide();
      //$(this).remove();
      //$('.fa-check-' + id).show();
    });
  });
</script> 
<script>
  $(function() {
    $(document).on('dblclick', '.a-fa-click', function() {
      var id = $(this).attr('id');
      $('.' + id).show();
      $('.' + id).select();
      $('.' + id).focus();
      $('.sp-' + id).hide();
      //$(this).remove();
      $('.fa-check-' + id).show();
    });
  });
</script> 
<script>
  $(document).on('keypress', '.number', function(e) {
    if (e.which == 13) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $("table.table.fixed_table tr td span").each(function() {
        var combat = $(this).html();
        //alert(combat); return false;
        if (!isNaN(combat) && combat.length !== 0) {
          //alert(Number(combat).toLocaleString('en-IN')); return false;
          $(this).html(Number(combat).toLocaleString('en-IN'));
        }
      });
      var id = $(this).attr('cus');
      //var cus = $(this).attr('cus');
	  var sd = id.replace(/[^0-9]/gi, ''); 
      var number = parseInt(sd, 10);
	  //alert(number); return false;
      $('.fa-check-' + id).hide();
      $('.input-' + id).hide();
	  $('.gdrive-' + id).hide();
      $('#s-' + id).show();
      $('#f-' + id).show();
      var name_val = $(this).val();
      var column_name = $(this).attr('id');
      var id_rel = $(this).attr('rel');
      var id_db = $('#h-' + id_rel).val();
      var type = $('#type-' + id_rel).val();
      var cat_id = $('#cat-type-' + id_rel).val();
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  
		  cat_id:cat_id
        },
        success: function(response) {
          //alert(response);
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id_rel).val(data['pan_cards_id']);
              $('.d-' + id_rel).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
			  $('.gdrive-icon-' + id).show();
            }
            if (type == 'passports') {
              $('#h-' + id_rel).val(data['passports_id']);
              $('.d-' + id_rel).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id_rel).val(data['aadhar_card_id']);
              $('.d-' + id_rel).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id_rel).val(data['driving_licence_id']);
              $('.d-' + id_rel).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id_rel).val(data['voter_id']);
              $('.d-' + id_rel).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
          }
        }
      });
    }
  });
</script> 
<script>
  $(document).on('keypress', '.attribute', function(e) {
    if (e.which == 13) {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var id = $(this).attr('cus');
      //alert(id); 
	  var sd = id.replace(/[^0-9]/gi, ''); 
      var number = parseInt(sd, 10);
	  //alert(number); return false;
      $('.fa-check-' + id).hide();
      $('.' + id).hide();
      $('.sp-' + id).show();
      $('#s-' + id).show();
      $('#f-' + id).show();
      var name_val = $(this).val();
      var id_db = $('#h-' + id).val();
      var column_name = 'name';
      var type = $('#type-' + id).val();
      var cat_id = $('#cat-type-' + id).val();
	  
	  var field_id = $('#field-id-pan-amt-'+number+'-link').val();
      // alert(type); return false;
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "{{ url('document/dataSubmit') }}",
        type: "POST",
        data: {
          name_val: name_val,
          column_name: column_name,
          id_db: id_db,
          type: type,
		  
		  cat_id:cat_id,
		  field_id:field_id
        },
        success: function(response) {
          //alert(id); return false;
          if (response != '') {
            data = JSON.parse(response);
            if (type == 'pan_cards') {
              $('#h-' + id).val(data['pan_cards_id']);
              $('.d-' + id).attr('id', data['pan_cards_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
			  $('.select-' + number).val(data['pan_cards_id']);
			  $('.remove-link-'+ number).attr('id', data['pan_cards_id']);
            }
            if (type == 'passports') {
              $('#h-' + id).val(data['passports_id']);
              $('.d-' + id).attr('id', data['passports_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'aadhar_card') {
              $('#h-' + id).val(data['aadhar_card_id']);
              $('.d-' + id).attr('id', data['aadhar_card_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'driving_licence') {
              $('#h-' + id).val(data['driving_licence_id']);
              $('.d-' + id).attr('id', data['driving_licence_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
            if (type == 'voter_id') {
              $('#h-' + id).val(data['voter_id']);
              $('.d-' + id).attr('id', data['voter_id']);
			  $('.select-' + number).attr('id', data['chk_id']);
            }
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
      $(this).css({
        "left": x.left - 0 + "px"
      });
    });
    $("table.table.fixed_table tr.htf1 th").each(function() {
      var y = $(this).offset();
      $(this).css({
        "top": 0 + "px"
      });
    });
    $("table.table.fixed_table tr.htf2 th").each(function() {
      var y = $(this).offset();
      $(this).css({
        "top": 37 + "px"
      });
    });
  });
</script> 
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
<script>
  $(function() {
    $(document).on('click', '.sel', function() {
      var numberOfChecked = $('.sel:checked').length;
      if (numberOfChecked > 0) {
        $('#email-send-btn').show();
      } else {
        $('#email-send-btn').hide();
      }
    });
  });
</script>
<style type="text/css">
/*  .page-content { padding: 0; }*/
  table.table.fixed_table tr.blue-box th,
  table.table.fixed_table tr.blue-box td {
    text-align: center;
  }
  span.link {
    cursor: pointer;
    text-decoration: underline;
  }
</style>
@if(@$_GET['file']=='error') 
<script>
$(function(){
setTimeout(function(){ alert('File not found your google drive.');
return false; }, 1000);
});
</script> 
@endif 
<script>
    $(function() {
        $(document).on('click','.mail-send',function(){
            var favorite = [];
            $.each($("input[type='checkbox']:checked"), function(){
                favorite.push($(this).val());
            });
            $('#attach-file').val(favorite.join(", "));
        });
    });
</script> 
<script>
    $(function() {
        $(document).on('click','.chk',function(){
            $('.chk').prop('checked',false);
			$(this).prop('checked',true);
			var id = $(this).attr('cus');
			$('.btn-save').hide();
			$('.sel-data-'+id).show();
        });
    });
</script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script>
  $(document).on("click", ".ldrive",function () {     
	var html_data='<div class="modal-body upload-img-box"> <img id="blah" style="display:none;" src="#" height="200" width="200" alt="local-image" /></div><div class="modal-body  progress-bar-box" id="pg-bar" style="display:none;"><div class="progress"><div class="progress-bar"></div></div></div><div class="modal-body uploadStatus-box"><div id="uploadStatus"></div></div> <div class="modal-footer"> <button type="submit" name="submit" class="btn btn-info btn-upload" >Upload</button><button type="button" class="btn btn-success btn-select-local" data-dismiss="modal" style="display:none;">Select</button> </div>';
	  $('#form-results').html(html_data);
 });
$('#myModal-Google-Drive').modal({
    backdrop: 'static',
    keyboard: false
});
$('#myModal-Local-Drive').modal({
    backdrop: 'static',
    keyboard: false
});
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var name = input.files[0].name;
    var lastDot = name.lastIndexOf('.');
    var fileName = name.substring(0, lastDot);
    var ext = name.substring(lastDot + 1);
	$('.btn-select-local').attr('name',name);
	if(ext=='png' || ext=='PNG' || ext=='jpeg' || ext=='JPEG' || ext=='jpg' || ext=='JPG')
	{
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
	  $('#blah').show();
    }
	}
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}
$(document).on('change',"#imgInp",function() {
  readURL(this);
});
</script> 
<script>
$(document).ready(function(){
    // File upload via Ajax
    $(document).on('submit', "#uploadForm",function(e){
        e.preventDefault();
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.ceil((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: '{{ url("document/imageUploads") }}',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
			    $('#pg-bar').show();
                $(".progress-bar").width('0%');
                $('#uploadStatus').html('<img src="{{ url("public/theme/assets/images/loadingAnimation.gif") }}"/>');
            },
            error:function(){
                $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
            },
            success: function(resp){
			//alert(resp); return false;
                if(resp == 'ok'){
                    $('#uploadForm')[0].reset();
                    $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
					$('.btn-upload').hide();
					$('.btn-select-local').show();
					//$('.btn-select-local').trigger('click');
					//$('.modal-backdrop').remove();
                }else if(resp == 'err'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }
            }
        });
    });
	
  
});
</script>
<button data-toggle="modal" class="g-drive-pop-up" data-backdrop="static" data-keyboard="false" data-target="#myModal-Google-Drive" type="button" style="display:none;">File choose from google drive</button>
<button data-toggle="modal" class="g-local-pop-up" data-backdrop="static" data-keyboard="false" data-target="#myModal-Local-Drive" type="button" style="display:none;">File choose from local drive</button>
<div class="modal fade" id="myModal-Local-Drive" role="dialog">
  <div class="modal-dialog modal-dialog-custom"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close bt-cl" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Local File</h4>
      </div>
      <form id="uploadForm" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-body">
          <input type="file" name="local_upload_file" id="imgInp" />
        </div>
        <span id="form-results">
        <div class="modal-body upload-img-box"> <img id="blah" style="display:none;" src="#" height="200" width="200" alt="local-image" /> </div>
        <div class="modal-body  progress-bar-box" id="pg-bar" style="display:none;">
          <div class="progress">
            <div class="progress-bar"></div>
          </div>
        </div>
        <div class="modal-body uploadStatus-box">
          <div id="uploadStatus"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-info btn-upload" >Upload</button>
          <button type="button" class="btn btn-success btn-select-local" data-dismiss="modal" style="display:none;">Select</button>
        </div>
        </span>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-dialog-custom"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
      </div>
      <form id="attchment_file" action="{{ url('document/emailSend') }}" method="post">
        @csrf
        <input type="hidden" id="attach-file" name="attachment_file" />
        <div class="modal-body">
          <ul class="form-box">
            <li>
              <label>Subject</label>
              <input type="text" autocomplete="off" required name="email_subject">
            </li>
            <li>
              <label>Name</label>
              <input type="text" autocomplete="off" required  name="email_name">
            </li>
            <li>
              <label>Email</label>
              <input type="email" autocomplete="off" required  name="email">
            </li>
            <li>
              <label>Message</label>
              <input type="text" autocomplete="off" required  name="message">
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" >Send Email Now</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal-Google-Drive" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width:930px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Google Drive Connect</h4>
      </div>
      <div class="modal-body">
        <div id="transparent-wrapper"></div>
        <div id="login-box" class="hide1">
          <p>Please login on your google account.</p>
          <button id="btnLogin" onClick="handleAuthClick()" class="button">Login with your google drive account</button>
        </div>
        <div id="drive-box" class="hide1">
          <div id="drive-breadcrumb"> <span class='breadcrumb-arrow'></span> <a data-id='root' data-level='0'>Home</a> <span id="span-navigation"></span> </div>
          
          <!-- <div id="drive-info" class="hide1">
        <div class="user-item">Welcome <span id="span-name">sdfsdfsd</span></div>
        <div class="user-item">Total Quota: <span id="span-totalQuota"></span></div>
        <div class="user-item">Used Quota: <span id="span-usedQuota"></span></div>
		<div class="user-item">Share Mode: <span id="span-sharemode">OFF</span></div>
        <div class="user-item"><a id="link-logout" class="logout-link" onClick="handleSignoutClick()">Logout</a></div>
    </div>-->
          
          <div id="drive-menu">
            <div id="button-reload" title="Refresh"><i class="fa fa-refresh" aria-hidden="true"></i></div>
            <div id="button-upload" title="Upload to Google Drive" class="button-opt"><i class="fa fa-cloud-upload" aria-hidden="true"></i></div>
            <div id="button-addfolder" title="Add Folder" class="button-opt"><i class="fa fa-folder" aria-hidden="true"></i></div>
            <div id="button-share" title="Show shared files only"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
          </div>
          <div id="drive-content"></div>
          <div id="error-message" class="flash hidden"></div>
          <div id="status-message" class="flash hidden"></div>
        </div>
        <input type="file" id="fUpload" class="hide"/>
        <div class="float-box" id="float-box">
          <div class="folder-form">
            <div class="close-x"><img id="imgClose" class="imgClose" src="{{ url('public/gdrive/images/button_close.png') }}" alt="close" /></div>
            <h3 class="clear">Add New Folder</h3>
            <div>
              <input type="text" id="txtFolder" class="text-input" />
            </div>
            <button id="btnAddFolder" value="Save" class="button">Add</button>
            <button id="btnClose" value="Close" class="button btnClose">Close</button>
          </div>
        </div>
        <div id="float-box-info" class="float-box">
          <div class="info-form">
            <div class="close-x"><img id="imgCloseInfo" class="imgClose" src="{{ url('public/gdrive/images/button_close.png') }}" alt="close" /></div>
            <h3 class="clear">File information</h3>
            <table cellpadding="0" cellspacing="0" class="tbl-info">
              <tr>
                <td class="label">Created Date</td>
                <td><span id="spanCreatedDate"></span></td>
              </tr>
              <tr>
                <td class="label">Modified Date</td>
                <td><span id="spanModifiedDate"></span></td>
              </tr>
              <tr>
                <td class="label">Owner</td>
                <td><span id="spanOwner"></span></td>
              </tr>
              <tr>
                <td class="label">Title</td>
                <td><span id="spanTitle"></span></td>
              </tr>
              <tr>
                <td class="label">Size</td>
                <td><span id="spanSize"></span></td>
              </tr>
              <tr>
                <td class="label">Extension</td>
                <td><span id="spanExtension"></span></td>
              </tr>
            </table>
            <button id="btnCloseInfo" value="Close" class="button btnClose">Close</button>
          </div>
        </div>
        <div id="float-box-text" class="float-box">
          <div class="info-form">
            <div class="close-x"><img id="imgCloseText" class="imgClose" src="{{ url('public/gdrive/images/button_close.png') }}" alt="close" /></div>
            <h3 class="clear">Text Content</h3>
            <div id="text-content"></div>
            <button id="btnCloseText" value="Close" class="button btn-danger btnClose">Close</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-close-pop" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal-Lebel" role="dialog">
  <div class="modal-dialog modal-dialog-custom"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Label</h4>
      </div>
      <form id="aa-label-form" action="{{ url('document/addLabel') }}" method="post">
        @csrf
        <div class="modal-body">
          <ul class="form-box">
            <li>
              <label>Label Name</label>
              <input type="text" autocomplete="off" required name="label_name">
            </li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" >Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal-add-document" role="dialog">
  <div class="modal-dialog modal-dialog-custom"> 
    
    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Document</h4>
      </div>
      <div class="modal-body">
        <ul class="form-box">
          <li>
            <label>Select Label</label>
            <select class="select_document" required>
              <option>-- Select Label --</option>
              
              
              
              
              
              
			  @foreach($category as $cal_all)
			  
              
              
              
              
              
              <option value="{{ $cal_all['_id'] }}">{{ $cal_all['label_name'] }}</option>
              
              
              
              
              
              
			  @endforeach
			  
            
            
            
            
            
            </select>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success add-pan-cards" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-danger add-doc" data-dismiss="modal">Close</button>
      </div>
    </div>
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
			url: "{{ url('document/ajaxItemQuantityUpdateData')}}/"+qty_val+"/"+order_number+"/"+item_number+"/"+order,
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