@extends('whatsapp.layout.app')
@section('title', 'View a Template')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
    <div class="panel">
      <div class="panel-body">
        <header class="panel-heading">
          <h3 class="panel-title" style="padding:20px 36px 0;">View Message Template</h3>
        </header>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="{{ url('whatsapp/updatemessage') }}" enctype="multipart/form-data" onsubmit="return itemDataPostValidate();">
                  <input type="hidden" name="id" value="{{ $data['_id'] }}" />
                  @csrf
                  <div id="formsteps" class="form-group col-lg-12 col-md-12">
                    <div class="form-group row name-of-template">
                      <div class="col-lg-12">
                        <label>Name of Template :</label>
                        {{ $data['name_of_template'] }}</div>
                    </div>
                    <div id="append-text" class="add-box"> @foreach($message_data as $key=>$msg_data)
                      @if($msg_data['gdrive_name']!='')
                      <div class="add-row">
                        <div class="form-group row @if($key!=0) data del-temp-{{ $key }} @endif ">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="upload-button upload-box"> @if($msg_data['gdrive_name']!='') <a href="{{ url('public/uploads/thumb/') }}/{{ $msg_data['gdrive_name'] }}" target="_blank"><img src="{{ url('public/uploads/thumb/') }}/{{ $msg_data['gdrive_name'] }}" title="{{ $msg_data['original_name'] }}"></a> @endif </div>
                            <div class="text-area-box">
                              <div class="msg-box">{!! nl2br($msg_data['message_text']) !!}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @else
                      <div class="add-row">
                        <div class="form-group row @if($key!=0) data del-temp-{{ $key }} @endif ">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="text-area-box">
                              <div class="msg-box">{!! nl2br($msg_data['message_text']) !!}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                      
                      
                      @endforeach </div>
                    <div class="form-group row creat-fms-btn">
                      <div class="col-md-12"> <a href="{{ url('whatsapp/templates') }}" title="Back">
                        <button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>
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
<script>
$(function(){
var i = $('.data').length;
   $(document).on('click','.add-template',function(){
   i++;
      $('#append-text').append('<div class="form-group data row del-temp-'+i+'"><div class="col-lg-12"><label>File to send '+i+'</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text gdrive" style="cursor:pointer;" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Google-Drive" cus="'+i+'" id="basic-addon3">Click with google drive </span></div><input type="text" name="gdrive_name[]" value="" readonly="" class="form-control gdrive-data-'+i+'" id="basic-url" aria-describedby="basic-addon3"><input type="hidden" name="gdrive_id[]" value="" class="gdrive-data-id-'+i+'">&nbsp;<a id="'+i+'" class="add-label btn btn-danger delete-template" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div></div><div class="form-group row del-temp-'+i+'"> <div class=" col-lg-11"> <label>Message Text '+i+'</label> <textarea class="form-control" name="message_text[]" autocomplete="off" value="" id="address"></textarea></div> </div>');
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
@stop 