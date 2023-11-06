@extends('whatsapp.layout.app')
@section('title', 'Add Send Message')
@section('content')
@include('whatsapp.layout.partials.sidebar') 

<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
    <div class="panel">
      <div class="panel-body">
	  <!--<header class="panel-heading">-->
   <!--     <h3 class="panel-title">Add Send Message</h3>-->
   <!--   </header>-->
      <div class="new-form">
        <h2>Add Send Message</h2>
        <div class="row">
          <div class="col-md-10 col-lg-6">
            <div class="card">
          <div class="card-body">
            <form method="POST" action="{{ url('whatsapp/sendmessagesave') }}" enctype="multipart/form-data">
               @csrf        
			   <div id="formsteps" class="form-group col-lg-12 col-md-12">
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Name of Sender</label>
					<select name="name_of_sender" required class="form-control" id="name_of_sender">
					<option value="1"> Select Mobile Number</option>
					<option value="2"> Select From Group</option>
					</select>
				</div>
                </div>
				
				<div class="form-group group row" style="display:none;">
                  <div class=" col-lg-12">
					<select name="name_of_contact" class="form-control" id="name_of_contact">
					<option value=""> Select Group Contact</option>
					@foreach($group_contact as $group_contact)
					<option value="{{ $group_contact['_id'] }}">{{ $group_contact['name_of_contact'] }}</option>
					@endforeach
					</select>
				</div>
                </div>
				
                <div class="form-group input row">
                  <div class=" col-lg-12">
                    <label>Receiver mobile no(s)
					</label>
                    <textarea class="form-control" name="receiver_mobile_number" autocomplete="off" value="" id="receiver_mobile_number">{{ old('receiver_mobile_number') }}</textarea>
					<small><em>(Seperate multiple no by comma)</em></small>
					@if ($errors->has('receiver_mobile_number'))
					<span class="error">{{ $errors->first('receiver_mobile_number') }}</span>
					@endif
                  </div>
                </div>
				
				<div class="form-group row half-row">
                  <div class=" col-lg-6">
                    <label>Date</label>
                    <input type="text" class="form-control" required name="message_date" autocomplete="off" value="{{ old('message_date') }}" id="message_date">
					@if ($errors->has('message_date'))
					<span class="error">{{ $errors->first('message_date') }}</span>
					@endif
                  </div>
                  <div class=" col-lg-6">
                    <label>Time</label>
                    <select name="message_time" required class="form-control" id="message_time">
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
                  </div>
                </div>
				
				
				
				<!--<div class="form-group row">-->
    <!--              <div class=" col-lg-12">-->
    <!--                <label>Message Template</label>-->
    <!--                <select name="message_template" class="form-control" id="message_template">-->
				<!--	<option value=""> Select Message Template</option>-->
				<!--	@foreach($message_template as $message_template)-->
				<!--	<option value="{{ $message_template['_id'] }}">{{ $message_template['name_of_template'] }}</option>-->
				<!--	@endforeach-->
				<!--	</select>-->
    <!--              </div>-->
    <!--            </div>-->
    
    <div id="append-text" class="add-box">
                      <div class="add-row"> 
                       
                        <div class="form-group row">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="upload-button">
                            <img class="img-remove-btn remove-attachment-0" id="0" style="display:none;" src="{{ url('assets/images/icon-delete.png') }}">
                              <label>
                              <img id="blah-0" style="display:none;" src="#" alt="" />                             
                              <input type="file" name="gdrive_name[]" value="" class="form-control gdrive-data-0 imgInp" cus="0">
                                <span class="upload-btn btn-primary btn waves-effect waves-classic"><i class="fa fa-upload" aria-hidden="true"></i>File Upload</span></label>
                            </div>
                            <div class="text-area-box">
                              <textarea class="form-control" placeholder="Message Text" name="message_text[]" autocomplete="off" value="" id="address">{{ old('message_text') }}</textarea>
                              @if ($errors->has('message_text')) <span class="error">{{ $errors->first('message_text') }}</span> @endif <small> Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ ) </small></div>
                            <div class="add-row-btn"><a class="add-label btn btn-success add-template" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
                          </div>
                        </div>
                      </div>
                    </div>
				
				
				
				
				
				
              <div class="form-group row creat-fms-btn">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Save Message</button>
				  <!--<a href="{{ url('whatsapp/send-message-listing') }}" title="Back"><button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button></a>-->
                  </div>
              </div>
			  </div>
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
            <div id="button-reload" title="Refresh"></div>
            <div id="button-upload" title="Upload to Google Drive" class="button-opt"></div>
            <div id="button-addfolder" title="Add Folder" class="button-opt"></div>
            <div id="button-share" title="Show shared files only"></div>
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
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#message_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
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
<script>
    $(function() {
        $(document).on('click','.gdrive',function(){
           $('#button-reload').trigger('click');
        });
    });
</script>
<script>
    $(function() {
        $(document).on('click','.btn-save',function(){
		   var name = $(this).attr('name');
		   var id = $(this).attr('id');
		   $('.gdrive-data').val(name);
		   $('.gdrive-data-id').val(id);
        });
    });
</script>
<script>
$(function(){
    $(document).on('change','#name_of_sender',function(){
	  var name_of_sender_val = $(this).val();
	  if(name_of_sender_val==1)
	  {
	  $('.input').show();
	  $('.group').hide();
	  }
	  else
	  {
	  $('.input').hide();
	  $('.group').show();
	  }
	});
});
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
$(document).on('click','.delete-template',function(){
     var id = $(this).attr('id');
	 $('.del-temp-'+id).remove();
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


@stop 