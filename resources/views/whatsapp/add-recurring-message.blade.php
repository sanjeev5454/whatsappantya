@extends('whatsapp.layout.app')
@section('title', 'Add Message Planner')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid">
    <div class="pane">
      <div class="pane-body">
        <div class="new-form">
          <h2>Add Message Planner</h3>
        
        <div class="row">
          <div class="col-md-10 col-lg-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="{{ url('whatsapp/savesendmessage') }}" antocomplete="on" id="form-recurring" enctype="multipart/form-data" onsubmit="return itemDataPostValidate();">
                  @csrf
                  <div id="formsteps" class="form-group col-lg-12 col-md-12">                      
                    <div class="form-group row">
                    <div class=" col-lg-12">
                    <label>Scheduling Task Name</label>
                    <input type="text" maxlenth="500" required antocomplete="off" id="recurring_task_name" name="recurring_task_name" value="{{ old('recurring_task_name') }}" class="form-control required">
                    <span class="error error-recurring-task-name" style="display:none;">Recurring task name is required.</span>
                    </div>
                    </div>
                    
                    
                    <div class="form-group row">
                    <div class=" col-lg-12">
                    <label>Select Contact(s)</label>
                    <br/>
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" value="1"> Add Mobile Number Manually
                    </label>
                    
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" value="2"> Select Group
                    </label>
                    
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" value="3"> Choose Contacts
                    </label>
                    
                    <span class="error error-name-of-sender" style="display:none;">Please select choose contact.</span>
                    </div>
                    </div>
                    
                    <div class="form-group group row" style="display:none;">
                    <div class=" col-lg-12">
                    <select name="name_of_contact" class="form-control" id="name_of_contact">
                    <option value=""> Select Group Contact</option>
                    @foreach(ContactList() as $group_contact)
                    <option value="{{ $group_contact['_id'] }}">{{ $group_contact['name_of_contact'] }}</option>
                    @endforeach
                    </select>
                    <span class="error error-name-of-contact" style="display:none;">Please select group contact.</span>
                    </div>
                    </div>
                      
                    <div class="form-group input row" style="display:none;">
                    <div class="col-lg-12">                   
                    <input type="text" class="form-control" id="receiver_mobile_number_manually" name="receiver_mobile_number_manually" autocomplete="off" value="{{ old('receiver_mobile_number_manually') }}">
                    <small><em>(Add multiple mobile numbers separated by a comma (,). For e.g 9811XXXXXX, 9812XXXXXX)</em></small>
                    <br/>
                    <span class="error error-receiver-mobile-number-manually" style="display:none;">Receiver mobile number is required.</span>
                    </div>
                    </div>
    
                    <div class="form-group contact row" style="display:none;">
                    <div class="col-lg-12">                    
                    <div class="rec-mob">
                    <div id="con-data"></div>
                    <input type="text" style="display:none;" class="form-control" name="receiver_mobile_number_contact" autocomplete="off" value="{{ old('receiver_mobile_number_contact') }}" id="receiver_mobile_number_contact">
                    <div class="add-msg-btn"><a class="add-label btn btn-success waves-effect waves-classic" data-toggle="modal" data-target="#myModal" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i>Add Contact(s)</a></div>
                    <span class="error error-receiver-mobile-number-contact" style="display:none;">Receiver mobile number is required.</span>
                    </div>
                    
                    </div>
                    </div>
                  
            <div class="form-group row recurring-task" style="display:none;">
            <div class="col-lg-12">
            <div class="center-radio">   
            <label class="radio-inline">
            <input type="radio" name="is_recurring" value="0"> One Time Message
            </label>
            <label class="radio-inline">
            <input type="radio" required name="is_recurring" value="1"> Recurring Message
            </label>
            </div>
            <!--<small>Recurring Tasks re-occur on certain days or dates of every week, month or year. </small>-->
            
            
            
            
            <div class="recurring_type_box normal_hide recurring_option_hide" style="display:none;">
              <table class="table table-bordered table-striped table-condensed cf recurring_type inner-table task-table-new">
                <tr>
                  <td data-title="Select Type">
                  <label><input type="radio" name="recurring_type" value="5"> <span class="label-span">On a particular date every year</span></label>
                  <br>
                  <span class="error error-recurring-type" style="display:none">This field is required.</span>
                  </td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_yearly" name="date_of_yearly" disabled="disabled">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-yearly" style="display: none;">This field is required.</span>
                    </div>
                    <div class="half-box">
                    <select id="month_of_yearly" name="month_of_yearly" disabled="disabled">
                      <option value="">Month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                    <span class="error error-month-of-yearly" style="display: none;">This field is required.</span>
                    </div></div>
                    </td>
                </tr>
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" name="recurring_type" value="4">
                      <span class="label-span">On a particular date every quarter</span></label></td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_quaterly" name="date_of_quaterly" disabled="disabled">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-quaterly" style="display: none;">This field is required.</span>
                    </div>
                    <div class="half-box">
                    <select id="month_of_quaterly" name="month_of_quaterly" disabled="disabled">
                      <option value="">Month</option>
                      <option value="01/04/07/10">Jan/Apr/Jul/Oct</option>
                      <option value="02/05/08/11">Feb/May/Aug/Nov</option>
                      <option value="03/06/09/12">Mar/Jun/Sep/Dec</option>
                    </select>
                    <span class="error error-month-of-quaterly" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" name="recurring_type" value="3">
                      <span class="label-span">On a particular date of month</span></label></td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_month" name="date_of_month" disabled="disabled">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-month" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" name="recurring_type" value="2">
                      <span class="label-span">On particular day(s) of week</span></label></td>
                  <td data-title="Choose Option">
                      <div class="half-boxwrap">
                          <div class="half-box">
                    <select id="day_of_week" name="day_of_week[]" multiple="multiple" disabled="disabled">
                      <!--<option value="">Day of week</option>-->
                      <option value="Monday">Monday</option>
                      <option value="Tuesday">Tuesday</option>
                      <option value="Wednesday">Wednesday</option>
                      <option value="Thursday">Thursday</option>
                      <option value="Friday">Friday</option>
                      <option value="Saturday">Saturday</option>
                      <option value="Sunday">Sunday</option>
                    </select>
                    <small>Press CTRL to choose multiple values.</small>
                    <span class="error erro-day-of-week" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                <tr>
                  <td data-title="Select Type" colspan="2"><label>
                      <input type="radio" name="recurring_type" value="1">
                      <span class="label-span">Everyday</span></label>
                      </td>
                </tr>
              </table>
              
              
            </div>
            </div>
          </div>
                <div class="form-group row send_now" style="display:none;">
                  <div class=" col-lg-12">
                      <div class="center-radio"> 
                      <label class="radio-inline">
                    <input type="radio" name="send_now" value="1"> Send Now
                    </label>
                    <label class="radio-inline">
                    <input type="radio" name="send_now" value="2"> Schedule
                    </label>
                     </div>
                     </div>
                 </div>
                 <div class="form-group row time-field half-row" style="display:none;">
                 <div class="col-lg-6">
                   <label>Time</label>
                    <select name="recurring_time" required class="form-control" id="recurring_time">
                    <option value="">Select Time</option>
                    @for($i=1;$i<=24;$i++)
                    @if($i<=9)
                    @php
                    $i='0'.$i;
                    @endphp
                    @endif
                    <option value="{{ $i }}">{{ $i.':00' }}</option>
                    @endfor
                    </select>
					@if ($errors->has('recurring_time'))
					<span class="error">{{ $errors->first('recurring_time') }}</span>
					@endif
                  </div>
                  <div class="col-lg-6 msg-start-date">
                   <label>Date</label>
                    <input type="text" class="form-control" readonly name="message_start_date" disabled="disabled" autocomplete="off" value="{{ old('message_start_date') }}" id="message_start_date">
					@if ($errors->has('message_start_date'))
					<span class="error">{{ $errors->first('message_start_date') }}</span>
					@endif
                  </div>
                    
                </div>
                
                 
                
                    <div class="form-group row template-field" style="display:none;">
                  <div class=" col-lg-12">
                    <label>Message Template</label>
                    <select name="message_template" required class="form-control" id="message_template">
					<option value=""> Select Message Template</option>
					@foreach($message_template as $message_template)
					<option value="{{ $message_template['_id'] }}">{{ $message_template['name_of_template'] }}</option>
					@endforeach
					<option value="custom">Custom</option>
					</select>
                  </div>
                </div>
                
                <span id="result-template" style="display:none;">
                    
                </span>
                
                <div id="append-text" class="add-box" style="display:none;">
                      <div class="add-row"> 
                        <div class="form-group row">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="upload-button">
                            <img class="img-remove-btn remove-attachment-0" id="0" style="display:none;" src="{{ url('assets/images/icon-delete.png') }}">
                              <label>
                              <img id="blah-0" style="display:none;" src="#" alt="" />                             
                              <input type="file" name="gdrive_name" value="" class="form-control gdrive-data-0 imgInp" cus="0">
                                <span class="upload-btn btn-primary btn waves-effect waves-classic"><i class="fa fa-upload" aria-hidden="true"></i>File Upload</span></label>
                            </div>
                            <div class="text-area-box">
                              <textarea class="form-control" placeholder="Message Text" name="message_text" autocomplete="off" value="" id="address">{{ old('message_text') }}</textarea>
                             <small> Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ ) </small></div>
                          </div>
                          @if ($errors->has('message_text'))
					<span class="error">{{ $errors->first('message_text') }}</span>
					@endif
                        </div>
                      </div>
                    </div>
                
                    <div class="form-group row creat-fms-btn" style="display:none;">
                      <div class="col-md-12 pl-0 pr-0">
                        <button type="submit" class="btn btn-success waves-classic waves-effect msg-send"> Save Message</button>
                        <a href="{{ url('whatsapp/recurring-message-listing') }}" title="Back">
                        <!--<button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>-->
                        </a> </div>
                    </div>
                  </div>
                  <input type="hidden" value="" id="gdrive-pop-val" />
                </form>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<input type="text" style="display:none;" class="form-control" autocomplete="off"  id="receiver_mobile_number_contact_temp">

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form action="{{ url('whatsapp/message-recurring-update-date') }}" method="post">
          @csrf 
          <input type="hidden" id="message-id" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact List </h4>
        </div>
        
        <div class="modal-body">
            <input type="text" id="myInput" style="width:50%; margin-left:140px;" autocomplete="off" class="form-control" placeholder="Search here ... ...">
            <br/>
          <table id="myTable" class="table table-hover table-bordered mobile-number">
    <thead>
      <tr>
        <th class="list">#</th>
        <th>Company Name</th>
        <th>Name</th>
        <th>Mobile Number</th>
        </tr>
        <tbody>
            @foreach(ContactListDetails() as $list)
            <tr>
                <td><input type="checkbox" contact_id="{{ $list['_id'] }}" cus="{{ $list['company_name'] }} ({{$list['name_of_contact']}})" value="{{ $list['receiver_mobile_number'] }}" class="chk"></td>
                <td>{{ $list['company_name'] }}</td>
                <td>{{ $list['name_of_contact'] }}</td>
                <td>{{ $list['receiver_mobile_number'] }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        </div>
        <div class="modal-footer small-btn">
            <button type="button" class="btn btn-success add-contact">Add Contact</button>
        </div>
      </div>
      </form>
    </div>
    </div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script> 
  

    <!-- Initialize the plugin: -->
<!--<script type="text/javascript">-->
<!--	$(function(){		-->
	<!--	$('#message_template').multiselect();-->
<!--	    $('#message_template').select2({-->
<!--			 placeholder: "Select Message Template",-->
<!--			 closeOnSelect: false-->
<!--	    });-->
<!--	});-->
<!--</script>-->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
     $("#append-text").sortable({
    update: function(event, ui) {
        // i need to get the class text that is being dragged i.e 
        var order = $(this).sortable("serialize");
        /*alert(order);*/
    }
    });
});
</script>
 
 
  
  
  <script>
$(function(){
$(document).on('paste keyup', '#receiver_mobile_number_manually',function(e){
    //$(this).val($(this).val().replace(/[^\d,]/g,''));
  });
});
</script>
  <script>
  $( function() {
    $(document).on('change','#recurring_time',function(){
       var time = $(this).val();
       var date = '{{date('H')}}';
       if(time!='')
       {
       if(date>=time){
           $("#message_start_date").datepicker("destroy");
         $( "#message_start_date" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: +1 });
         $("#message_start_date").prop("disabled",false); 
       }else{
           $("#message_start_date").datepicker("destroy");
         $( "#message_start_date" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: 0 }); 
         $("#message_start_date").prop("disabled",false); 
       }
       }else{
          $("#message_start_date").prop("disabled",true); 
       }
    });
  } );
  </script>
  <script>
  $( function() {
    //$( "#message_start_date" ).datepicker({ dateFormat: 'yy-mm-dd',minDate: +1 });
  } );
  </script>
<script>
$(function(){
var i = $('.data').length;;
   $(document).on('click','.add-template',function(){
   i++;
      $('#append-text').append('<div class="add-row"><div class="form-group row del-temp-'+i+'"><div class="col-lg-12 msg-tamplate"><div class="upload-button"> <img class="img-remove-btn remove-attachment-'+i+'" id="'+i+'" style="display:none;" src="{{ url('assets/images/icon-delete.png') }}"><label><img id="blah-'+i+'" style="display:none;" src="#" alt="" /><input type="file" name="gdrive_name[]" value="" class="form-control gdrive-data-'+i+' imgInp" cus="'+i+'"><span class="upload-btn btn-primary btn waves-effect waves-classic"><i class="fa fa-upload" aria-hidden="true"></i>File Upload</span></label></div><div class="text-area-box"><textarea class="form-control" name="message_text[]" autocomplete="off" value="" id="address"></textarea><small>Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ )</small></div><div class="add-row-btn"><a id="'+i+'" class="add-label btn btn-danger delete-template" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div></div></div></div>');
   });
});
</script> 

<script>
    $(function(){
        $(document).on('click','.add-contact',function(){
            var chk = $('.chk:checked').map(function(_, el) {
            return $(el).val();
            }).get();
            
            var chk1 = $('.chk:checked').map(function(_, el) {
            return $(el).attr('cus');
            }).get();
            
            var rec_mob_num = $('#receiver_mobile_number_contact').val();
            var rec_con_data = $('#con-data').html();
            if(rec_mob_num==''){
            $('#receiver_mobile_number_contact_temp').val(chk);
            var str = $('#receiver_mobile_number_contact_temp').val().split(',');
            //alert(str.length);
            var t='';
            for(var i=0;i<str.length;i++){
                t +='<span id="san-'+str[i]+'">'+chk1[i]+'<span id="'+str[i]+'" class="remove-btn"></span></span>';
            }
            $('#con-data').append(t);
            $('#receiver_mobile_number_contact').val(rec_mob_num+','+chk);
            $('.recurring-task').show();
            }else{
            var str = $('#receiver_mobile_number_contact_temp').val().split(',');
            //alert(str.length);
                //alert(str[0]); return false;
            //$('#receiver_mobile_number_contact').val(rec_mob_num+','+chk);
            var t='';
            for(var i=0;i<str.length;i++){
                t +='<span id="san-'+str[i]+'">'+chk1[i]+'<span id="'+str[i]+'" class="remove-btn"></span></span>';
            }
            $('#con-data').append(t);
            $('#receiver_mobile_number_contact').val(rec_mob_num+','+chk);
            //$('#con-data').html(rec_con_data+'<span id="san-'+str+'">'+', '+chk1+'<span id="'+str+'" class="remove-btn"></span></span>');
            $('.recurring-task').show();
            }
            $('.chk').prop('checked',false);
            $('#receiver_mobile_number_contact_temp').val('');
            $('.close').trigger('click');
        });
    });
   
</script>


<script>
$(function(){
    $(document).on('click','input[name=name_of_sender]:checked',function(){
	  var name_of_sender_val = $(this).val();
	  if(name_of_sender_val==1)
	  {
	  $('.input').show();
	  $('.group').hide();
	  $('.contact').hide();
	  }else if(name_of_sender_val==2){
	  $('.input').hide();
	  $('.group').show();
	  $('.contact').hide();    
	  }
	  else if(name_of_sender_val==3)
	  {
	  $('.input').hide();
	  $('.group').hide();
	  $('.contact').show(); 
	  }
	  else
	  {
	  $('.input').hide();
	  $('.group').hide();
	  $('.contact').hide();
	  }
	});
});
</script>

<script>
    $(function(){
        $(document).on('change','#message_template',function(){
            var temp_val = $(this).val();
            if(temp_val!='')
            {
            $('.creat-fms-btn').show();
            if(temp_val=='custom')
            {
            $('#append-text').show();   
            $('#result-template').html('');
            $('#result-template').hide();
            }
            else
            {
            
            $.ajax({
                    type: "GET",
                    url: "{{ url('whatsapp/ajaxTemplate/')}}/"+temp_val,
                    data: {temp_val:temp_val},
                    success: function(msg){
                    //alert(msg); return false;
                    if(msg!='')
                    {
                     $('#result-template').html(msg); 
                     $('#append-text').hide();
                     $('#result-template').show();
                    }
                    }
                    });
            
            
            }
            }else{
            $('.creat-fms-btn').hide();
            $('#append-text').hide();
            $('#result-template').hide();
            $('#result-template').html('');  
            }
        });
    });
</script>
<script>
function readURL(input,m) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#blah-'+m).attr('src', e.target.result);
      $('#blah-'+m).show();
      $('.remove-attachment-'+m).show();
    }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$(document).on('change',".imgInp",function() {
   var id = $(this).attr('cus');
  readURL(this,id);
  $(this).addClass("hide-input");
});
</script>
<script>
    $(function(){
        $(document).on('click','.img-remove-btn',function(){
            var conf = confirm('Are you sure to delete the picture?');
            if(conf)
            {
            var id = $(this).attr('id');
            $('.gdrive-data-'+id).show();
            $('#blah-'+id).attr('src', '#');
            $('#blah-'+id).hide();
            $('.remove-attachment-'+id).hide();
            $('.gdrive-data-'+id).removeClass('hide-input');
            $('.gdrive-data-'+id).val('');
            }
        });
    });
</script>
<script>
    $(function(){
        $('#message_start_date').bind('copy paste',function(e) {
    e.preventDefault(); return false; 
});
        
    });
</script>
<script>
$('input[name="is_recurring"]').click(function(){

   if (jQuery("input[name='is_recurring']:checked" ).val() === "1") {
      jQuery('.msg-start-date').fadeOut();
      jQuery('.recurring_option_hide').fadeIn();
      jQuery('.time-field').fadeOut();
      jQuery('.template-field').fadeOut();
      jQuery('.send_now').fadeOut();
      }else if(jQuery("input[name='is_recurring']:checked" ).val() === "0"){
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeOut();
      jQuery('.template-field').fadeOut();
      jQuery('.send_now').fadeIn();
      } else {
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeOut();
      jQuery('.send_now').fadeOut();
      //jQuery('.template-field').fadeOut();
      }

});
</script>

<script>
$('input[name="send_now"]').click(function(){

   if (jQuery("input[name='send_now']:checked" ).val() === "1") {
      jQuery('.msg-start-date').fadeOut();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeOut();
      jQuery('.template-field').fadeIn();
      jQuery('.msg-send').html('Send Message');
      jQuery("#recurring_time").removeAttr("required"); 
      jQuery("#message_start_date").removeAttr("required");
      }else if(jQuery("input[name='send_now']:checked" ).val() === "2"){
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeIn();
      jQuery('.template-field').fadeOut();
      jQuery('.msg-send').html('Save Message');
      jQuery("#recurring_time").attr("required");
      jQuery("#message_start_date").attr("required");
      } else {
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeOut();
      jQuery('.msg-send').html('Save Message');
      jQuery("#recurring_time").attr("required");
      jQuery("#message_start_date").attr("required");
      }

});
</script>


<script>
    $(function(){
        $(document).on('change','#message_start_date',function(){
           var date =  $('#message_start_date').val();
           var time = $('#recurring_time').val();
           if(date!='' && time!='')
           {
            $('.template-field').fadeIn(); 
		
		
           }else{
            $('.template-field').fadeOut();  
           }
        });
    });
</script>
<script>
    $(function(){
        $(document).on('change','#recurring_time',function(){
           var date =  $('#message_start_date').val();
           var time = $('#recurring_time').val();
           if(date!='' && time!='' && $("input[name='is_recurring']:checked" ).val() == 0)
           {
            $('.template-field').fadeIn();   
           }else if(time!='' && $("input[name='is_recurring']:checked" ).val() == 1){
            $('.template-field').fadeIn();   
           }else{
            $('.template-field').fadeOut();  
           }
        });
    });
</script>
<script>
function filterTable(event) {
    var filter = event.target.value.toUpperCase();
    var rows = document.querySelector("#myTable tbody").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        var secondCol = rows[i].cells[2].textContent.toUpperCase();
        var thirdCol = rows[i].cells[3].textContent.toUpperCase();
        if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1 || thirdCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
}

document.querySelector('#myInput').addEventListener('keyup', filterTable, false);
</script>
<script>
    $(function(){
       $(document).on('keyup','#receiver_mobile_number_manually',function(){
           var data = $('#receiver_mobile_number_manually').val();
           
           if(data!='')
           {
            var result = data.split(',');
            var i;
            for (i = 0; i < result.length; ++i) {
            if(result[i].length>9){
            $('.recurring-task').show();
            }else{
            $('.recurring-task').hide();  
            }
            }
           }else{
            $('.recurring-task').hide();   
           }
       }); 
    });
</script>
<script>
    $(function(){
       $(document).on('keyup','#receiver_mobile_number_contact',function(){
           var data = $('#receiver_mobile_number_contact').val();
           if(data!='')
           {
            $('.recurring-task').show();
           }else{
            $('.recurring-task').hide();   
           }
       }); 
    });
</script>

<script>
    $(function(){
       $(document).on('change','#name_of_contact',function(){
           var data = $('#name_of_contact').val();
           if(data!='')
           {
            $('.recurring-task').show();
           }else{
            $('.recurring-task').hide();   
           }
       }); 
    });
</script>
<script>
    $(function(){
       $(document).on('click','.remove-btn',function(){
          var removeItem = $(this).attr('id');
          var receiver_mobile_number_contact = $('#receiver_mobile_number_contact').val().split(',');
             receiver_mobile_number_contact = jQuery.grep(receiver_mobile_number_contact, function(value) {
             return value != removeItem;
            //alert(value); return false;
             });
             //alert(receiver_mobile_number_contact); return false;
            $('#receiver_mobile_number_contact').val(receiver_mobile_number_contact);
            $('#san-'+removeItem).remove();
       });
    });
</script>

<script>
$('input[name="recurring_type"]').click(function(){
   if (jQuery("input[name='recurring_type']:checked" ).val() === "5") {
       $('.template-field').fadeOut();
      jQuery('#date_of_yearly').prop('disabled',false);
      jQuery('#month_of_yearly').prop('disabled',false);
      jQuery('#date_of_quaterly').prop('disabled',true);
      jQuery('#month_of_quaterly').prop('disabled',true);
      jQuery('#date_of_month').prop('disabled',true);
      jQuery('#day_of_week').prop('disabled',true);
      var date_of_yearly = $('#date_of_yearly').val();
           var month_of_yearly = $('#month_of_yearly').val();
           if(date_of_yearly!='' && month_of_yearly!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
      //jQuery('.time-field').fadeIn();
      }else if(jQuery("input[name='recurring_type']:checked" ).val() === "4"){
          $('.template-field').fadeOut();
      jQuery('#date_of_yearly').prop('disabled',true);
      jQuery('#month_of_yearly').prop('disabled',true);
      jQuery('#date_of_quaterly').prop('disabled',false);
      jQuery('#month_of_quaterly').prop('disabled',false);
      jQuery('#date_of_month').prop('disabled',true);
      jQuery('#day_of_week').prop('disabled',true);
      var date_of_quaterly = $('#date_of_quaterly').val();
           var month_of_quaterly = $('#month_of_quaterly').val();
           if(date_of_quaterly!='' && month_of_quaterly!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
      //jQuery('.time-field').fadeIn();
      }else if(jQuery("input[name='recurring_type']:checked" ).val() === "3"){
          $('.template-field').fadeOut();
      jQuery('#date_of_yearly').prop('disabled',true);
      jQuery('#month_of_yearly').prop('disabled',true);
      jQuery('#date_of_quaterly').prop('disabled',true);
      jQuery('#month_of_quaterly').prop('disabled',true);
      jQuery('#date_of_month').prop('disabled',false);
      jQuery('#day_of_week').prop('disabled',true); 
      var date_of_month = $('#date_of_month').val();
           if(date_of_month!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
     // jQuery('.time-field').fadeIn();
      }else if(jQuery("input[name='recurring_type']:checked" ).val() === "2"){
          $('.template-field').fadeOut();
      jQuery('#date_of_yearly').prop('disabled',true);
      jQuery('#month_of_yearly').prop('disabled',true);
      jQuery('#date_of_quaterly').prop('disabled',true);
      jQuery('#month_of_quaterly').prop('disabled',true);
      jQuery('#date_of_month').prop('disabled',true);
      jQuery('#day_of_week').prop('disabled',false);  
       var day_of_week = $('#day_of_week').val();
       //alert(day_of_week);
           if(day_of_week!='' && day_of_week!=null)
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
      //jQuery('.time-field').fadeIn();
      }else if(jQuery("input[name='recurring_type']:checked" ).val() === "1"){
          $('.template-field').fadeOut();
      jQuery('#date_of_yearly').prop('disabled',true);
      jQuery('#month_of_yearly').prop('disabled',true);
      jQuery('#date_of_quaterly').prop('disabled',true);
      jQuery('#month_of_quaterly').prop('disabled',true);
      jQuery('#date_of_month').prop('disabled',true);
      jQuery('#day_of_week').prop('disabled',true); 
      jQuery('.time-field').fadeIn();
      }

});
</script>
<script>
    $(function(){
        $(document).on('change','#date_of_yearly,#month_of_yearly',function(){
           var date_of_yearly = $('#date_of_yearly').val();
           var month_of_yearly = $('#month_of_yearly').val();
           if(date_of_yearly!='' && month_of_yearly!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
        });
    });
</script>
<script>
    $(function(){
        $(document).on('change','#date_of_quaterly,#month_of_quaterly',function(){
           var date_of_quaterly = $('#date_of_quaterly').val();
           var month_of_quaterly = $('#month_of_quaterly').val();
           if(date_of_quaterly!='' && month_of_quaterly!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
        });
    });
</script>

<script>
    $(function(){
        $(document).on('change','#date_of_month',function(){
           var date_of_month = $('#date_of_month').val();
           if(date_of_month!='')
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
        });
    });
</script>

<script>
    $(function(){
        $(document).on('change','#day_of_week',function(){
           var day_of_week = $('#day_of_week').val();
           if(day_of_week!='' && day_of_week!=null)
           {
            jQuery('.time-field').fadeIn();   
           }else{
            jQuery('.time-field').fadeOut();   
           }
        });
    });
</script>
<script>
    function itemDataPostValidate(){
        var name_of_contact = $('#name_of_contact').val();
        var receiver_mobile_number_manually = $('#receiver_mobile_number_manually').val();
        var receiver_mobile_number_contact = $('#receiver_mobile_number_contact').val();
        if(name_of_contact=='' && receiver_mobile_number_manually=='' && receiver_mobile_number_contact=='')
        {
            alert('You have add atleast one mobile number.');
            return false;
        }
    }
</script>
<script>
    
    $('form').submit(function(){
    $('#form-recurring').submit();
    $(this).find('button[type=submit]').prop('disabled', true);
    return false; // return false stops the from from actually submitting.. this is only for demo purposes
});
</script>
@stop 