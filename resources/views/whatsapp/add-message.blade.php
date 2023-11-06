@extends('whatsapp.layout.app')
@section('title', 'Add a Template')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
        <!--<header class="panel-heading">
          <h3 class="panel-title" style="padding:20px 36px 0;">Add Message Template</h3>
        </header>-->
          <div class="new-form">
        <h2>Add a Template</h2>
        <div class="row">
          <div class="col-md-10 col-lg-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" id="" action="{{ url('whatsapp/savemessage') }}" enctype="multipart/form-data" onsubmit="return itemDataPostValidate();">
                  @csrf
                  <div id="formsteps" class="form-group col-lg-12 col-md-12">
                    <div class="form-group row">
                      <div class=" col-lg-12">
                      <label>Name of Template</label>
                        <input type="text" class="form-control"  name="name_of_template" autocomplete="off" value="{{ old('name_of_template') }}" id="name_of_template">
                        @if ($errors->has('name_of_template')) <span class="error">{{ $errors->first('name_of_template') }}</span> @endif </div>
                    </div>
                    <div class="add-row"> 
                        <div class="form-group row message-text-one">
                          <div class="col-lg-12 msg-tamplate ramdom-tpl">
                            <div class="text-area-box">
                              <textarea class="form-control" placeholder="Message Text" name="message_text_single" autocomplete="off" value="" id="address">{{ old('message_text_single') }}</textarea>
                              @if ($errors->has('message_text_single')) <span class="error">{{ $errors->first('message_text_single') }}</span> @endif <small> Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ ) </small></div>
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" name="random" value="1">
                            <label class="form-check-label" for="check1">Send the message order</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div id="append-text" class="add-box">
                      
                    </div>
                    
                    <div class="add-template add-more-contact"><a id="{{$key}}" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i> Add Image With Caption</a></div>
                    
                    <div class="form-group row creat-fms-btn">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect save-temp waves-classic waves-effect waves-classic"> Save Template</button>
                        <!--<a href="{{ url('whatsapp') }}" title="Back">
                        <button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>
                        </a>--> </div>
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
<style>
    .no-box{ width: 25px; text-align:center; display: block; padding: 0 5px 0 0; }
</style>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
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
var i = $('.data').length;
   $(document).on('click','.add-template',function(){
       var j = $('.msg-tamplate').length;
       var hi_da = '<?php echo rand(1000000000,9999999999);?>';
   i++;
      $('#append-text').append('<div class="add-row"><div class="form-group row del-temp-'+i+'"><div class="col-lg-12 msg-tamplate"><input type="hidden" id="hidden_id_image-'+i+'" name="hidden_id_image[]" value="'+hi_da+'"><span class="no-box" style=""></span><div class="upload-button"> <img class="img-remove-btn remove-attachment-'+i+'" id="'+i+'" style="display:none;" src="{{ url('assets/images/icon-delete.png') }}"><label><img id="blah-'+i+'" style="display:none;" src="#" alt="" /><input type="file" name="gdrive_name[]" value="" id="gdrive-data-'+i+'" class="form-control gdrive-data-'+i+' imgInp" cus="'+i+'"><span class="upload-btn btn-primary btn waves-effect waves-classic"><i class="fa fa-upload" aria-hidden="true"></i>File Upload</span></label><div class="loader-box" id="loader-'+i+'" style="display:none;"><input type="hidden" name="hidden_gdrive_id[]" id="hidden_gdrive_id_'+i+'" value=""><input type="hidden" id="hidden_gdrive_'+i+'" name="hidden_gdrive[]" value=""><input type="hidden" id="hidden_original_name_'+i+'" name="hidden_original_name[]" value=""><div class="loader">Loading...</div></div></div><div class="text-area-box"><textarea class="form-control" name="message_text[]" placeholder="Caption type here..." autocomplete="off" value="" id="address"></textarea><small>Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ )</small></div><div class="add-row-btn"><a id="'+i+'" class="add-label btn btn-danger delete-template" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div></div></div></div>');
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
		   var id = $(this).attr('cus'); 
		   $('#gdrive-pop-val').val(id);
        });
    });
</script> 
<script>
    $(function() {
        $(document).on('click','.btn-save',function(){
		   var name = $(this).attr('name');
		   var id = $(this).attr('id');
		   var pop_data = $('#gdrive-pop-val').val();
		   $('.gdrive-data-'+pop_data).val(name);
		   $('.gdrive-data-id-'+pop_data).val(id);
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
  var hidden_id = document.getElementById("hidden_id_image-"+id).value;
  var hidden_gdrive_id = document.getElementById("hidden_gdrive_id_"+id).value;
  var name = document.getElementById("gdrive-data-"+id).files[0].name;
  var form_data = new FormData();
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("gdrive-data-"+id).files[0]);
  //alert(hidden_id);
  form_data.append("file", document.getElementById("gdrive-data-"+id).files[0]);
  form_data.append("hidden_id",hidden_id);
  form_data.append("hidden_gdrive_id",hidden_gdrive_id);
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      
      
      $.ajax({
        url: "{{ url('whatsapp/ajax_image_uploads') }}" ,
        type: "POST",
        data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     //$('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
     $("#loader-"+id).show();
     $('.save-temp').addClass('sa-tmp');
    },   
    success:function(data)
    {
        //alert(data);
        const myArr = JSON.parse(data);
        $("#loader-"+id).hide();
        $("#gdrive-data-"+id).val("");
        $('#hidden_gdrive_'+id).val(myArr.gdrive_name);
        $('#hidden_original_name_'+id).val(myArr.original_name);
        $('#hidden_gdrive_id_'+id).val(myArr.hidden_gdrive_id);
        $('.save-temp').removeClass('sa-tmp');
        //$('#uploaded_image').html(data);
    }
      });
      
      
});
</script>
<script>
    $(function(){
       $(document).on('click','.sa-tmp',function(){
          alert('Please wait image uploading progress...');
          return false;
       }); 
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
<style type="text/css">
@keyframes ldio-h58reziayag-1 {
  0% { top: 23.75px; height: 52.5px }
  50% { top: 32.5px; height: 35px }
  100% { top: 32.5px; height: 35px }
}
@keyframes ldio-h58reziayag-2 {
  0% { top: 25.9375px; height: 48.125px }
  50% { top: 32.5px; height: 35px }
  100% { top: 32.5px; height: 35px }
}
@keyframes ldio-h58reziayag-3 {
  0% { top: 28.125px; height: 43.75px }
  50% { top: 32.5px; height: 35px }
  100% { top: 32.5px; height: 35px }
}
.ldio-h58reziayag div { position: absolute; width: 11px }.ldio-h58reziayag div:nth-child(1) {
  left: 19.5px;
  background: #000000;
  animation: ldio-h58reziayag-1 1s cubic-bezier(0,0.5,0.5,1) infinite;
  animation-delay: -0.2s
}
.ldio-h58reziayag div:nth-child(2) {
  left: 44.5px;
  background: #000000;
  animation: ldio-h58reziayag-2 1s cubic-bezier(0,0.5,0.5,1) infinite;
  animation-delay: -0.1s
}
.ldio-h58reziayag div:nth-child(3) {
  left: 69.5px;
  background: #000000;
  animation: ldio-h58reziayag-3 1s cubic-bezier(0,0.5,0.5,1) infinite;
  animation-delay: undefineds
}

.loadingio-spinner-pulse-e0j5vfqkset {
  width: 78px;
  height: 78px;
  display: inline-block;
  overflow: hidden;
  background: none;
}
.ldio-h58reziayag {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(0.78);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-h58reziayag div { box-sizing: content-box; }
/* generated by https://loading.io/ */


.loader,
.loader:before,
.loader:after {
  border-radius: 50%;
  width: 1.2em;
  height: 1.2em;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation: load7 1.8s infinite ease-in-out;
  animation: load7 1.8s infinite ease-in-out;
}
.loader {
  color: #000;
  font-size: 10px;
  margin: 0 auto;
  position: relative;
  text-indent: -9999em;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
  top:-24px;
}
.loader:before,
.loader:after {
  content: '';
  position: absolute;
  top: 0;
}
.loader:before {
  left: -1.5em;
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}
.loader:after {
  left: 1.5em;
}
@-webkit-keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}
@keyframes load7 {
  0%,
  80%,
  100% {
    box-shadow: 0 2.5em 0 -1.3em;
  }
  40% {
    box-shadow: 0 2.5em 0 0;
  }
}



</style>
@stop 