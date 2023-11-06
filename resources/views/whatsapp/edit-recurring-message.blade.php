@extends('whatsapp.layout.app')
@section('title', 'Edit Message Planner')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid">
    <div class="pane">
      <div class="pane-body">
        <header class="panel-heading">
          <h3 class="panel-title" style="padding:20px 36px 0;">Edit Message Planner</h3>
        </header>
        <div class="new-form"> 
        <h2>Edit Message Planner</h2>
        <div class="row">
          <div class="col-md-10 col-lg-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="{{ url('whatsapp/updatesendmessage') }}" enctype="multipart/form-data" onsubmit="return itemDataPostValidate();">
			<input type="hidden" value="{{ $data['_id'] }}" name="id" />
               @csrf  
                  <div id="formsteps" class="form-group col-lg-12 col-md-12">
                    
                    
                    <div class="form-group row">
                    <div class=" col-lg-12">
                    <label>Scheduling Task Name
                    </label>
                    <input type="text" maxlenth="500" required name="recurring_task_name" value="{{ $data['recurring_task_name'] }}" class="form-control">
                    @if ($errors->has('recurring_task_name'))
                    <span class="error">{{ $errors->first('recurring_task_name') }}</span>
                    @endif
                    </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class=" col-lg-12">
                    <label>Select Contact(s)</label>
                    <br/>
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" @if($data['name_of_sender']==1) checked="checked" @endif value="1"> Add Mobile Number Manually
                    </label>
                    
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" @if($data['name_of_sender']==2) checked="checked" @endif value="2"> Select Group
                    </label>
                    
                    <label class="radio-inline">
                    <input type="radio" required name="name_of_sender" @if($data['name_of_sender']==3) checked="checked" @endif value="3"> Choose Contacts
                    </label>
                    
                    <span class="error error-name-of-sender" style="display:none;">Please select choose contact.</span>
                    </div>
                    </div>
                    
                    
                    <div class="form-group group row" style=" @if($data['name_of_sender']==2) '' @else display:none; @endif">
                    <div class=" col-lg-12">
                    <select name="name_of_contact" class="form-control" id="name_of_contact">
                    <option value=""> Select Group Contact</option>
                   @foreach(ContactList() as $group_contact)
					<option @if($data['name_of_contact']==$group_contact['_id']) selected="selected" @endif value="{{ $group_contact['_id'] }}">{{ $group_contact['name_of_contact'] }}</option>
					@endforeach
                    </select>
                    <span class="error error-name-of-contact" style="display:none;">Please select group contact.</span>
                    </div>
                    </div>
                    
                     <div class="form-group input row" style=" @if($data['name_of_sender']!=1) display:none; @endif">
                    <div class="col-lg-12">                   
                    <input type="text" class="form-control" id="receiver_mobile_number_manually" name="receiver_mobile_number_manually" autocomplete="off" value="{{ $data['receiver_mobile_number'] }}">
                    <small><em>(Add multiple mobile numbers separated by a comma (,). For e.g 9811XXXXXX, 9812XXXXXX)</em></small>
                    <br/>
                    <span class="error error-receiver-mobile-number-manually" style="display:none;">Receiver mobile number is required.</span>
                    </div>
                    </div>
    
                    <div class="form-group contact row" style=" @if($data['name_of_sender']==3) '' @else display:none; @endif">
                    <div class="col-lg-12">                    
                    <div class="rec-mob">
                    <div id="con-data">
                        @php
                        $rec_mob = explode(',',$data['receiver_mobile_number']);
                        @endphp
                        @foreach($rec_mob as $r_m)
                        <span id="san-{{$r_m}}">{{getContactName($r_m)['company_name']}}<span id="{{$r_m}}" class="remove-btn"></span></span>
                        @endforeach
                    </div>
                    <input type="text" style="display:none;" class="form-control" name="receiver_mobile_number_contact" autocomplete="off" value="{{ $data['receiver_mobile_number'] }}" id="receiver_mobile_number_contact">
                    <div class="add-msg-btn"><a class="add-label btn btn-success waves-effect waves-classic" data-toggle="modal" data-target="#myModal" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i>Add Contact(s)</a></div>
                    <span class="error error-receiver-mobile-number-contact" style="display:none;">Receiver mobile number is required.</span>
                    </div>
                    
                    </div>
                    </div>
                    
                    <div class="form-group row recurring-task">
            <div class="col-lg-12">    
            <div class="center-radio">
            <label class="radio-inline">
            <input type="radio" required checked @if($data['is_recurring']==0) checked @endif name="is_recurring" value="0"> One Time Message
            </label>
            <label class="radio-inline">
            <input type="radio" required name="is_recurring" @if($data['is_recurring']==1) checked @endif value="1"> Recurring Message
            </label>
            </div>
            <div class="recurring_type_box normal_hide recurring_option_hide" style=" @if($data['is_recurring']==1) '' @else display:none; @endif">
              <table class="table table-bordered table-striped table-condensed cf recurring_type inner-table task-table-new">
                <tr>
                  <td data-title="Select Type">
                  <label><input type="radio" @if($data['recurring_type']==5) checked @endif name="recurring_type" value="5"> <span class="label-span">On a particular date every year</span></label>
                  <br>
                  <span class="error error-recurring-type" style="display:none">This field is required.</span>
                  </td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_yearly" name="date_of_yearly">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option @if($data['date_of_yearly']==$i) selected @endif value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-yearly" style="display: none;">This field is required.</span>
                    </div>
                    <div class="half-box">
                        
                    <select id="month_of_yearly" name="month_of_yearly">
                      <option value="">Month</option>
                      <option @if($data['month_of_yearly']=="01") selected @endif value="01">January</option>
                      <option @if($data['month_of_yearly']=="02") selected @endif value="02">February</option>
                      <option @if($data['month_of_yearly']=="03") selected @endif value="03">March</option>
                      <option @if($data['month_of_yearly']=="04") selected @endif value="04">April</option>
                      <option @if($data['month_of_yearly']=="05") selected @endif value="05">May</option>
                      <option @if($data['month_of_yearly']=="06") selected @endif value="06">June</option>
                      <option @if($data['month_of_yearly']=="07") selected @endif value="07">July</option>
                      <option @if($data['month_of_yearly']=="08") selected @endif value="08">August</option>
                      <option @if($data['month_of_yearly']=="09") selected @endif value="09">September</option>
                      <option @if($data['month_of_yearly']=="10") selected @endif value="10">October</option>
                      <option @if($data['month_of_yearly']=="11") selected @endif value="11">November</option>
                      <option @if($data['month_of_yearly']=="12") selected @endif value="12">December</option>
                    </select>
                    <span class="error error-month-of-yearly" style="display: none;">This field is required.</span>
                    </div></div>
                    </td>
                </tr>
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" @if($data['recurring_type']==4) checked @endif name="recurring_type" value="4">
                      <span class="label-span">On a particular date every quarter</span></label></td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_quaterly" name="date_of_quaterly">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option @if($data['date_of_quaterly']==$i) selected @endif value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-quaterly" style="display: none;">This field is required.</span>
                    </div>
                    <div class="half-box">
                    <select id="month_of_quaterly" name="month_of_quaterly">
                      <option value="">Month</option>
                      <option @if($data['month_of_quaterly']=="01/04/07/10") selected @endif value="01/04/07/10">Jan/Apr/Jul/Oct</option>
                      <option @if($data['month_of_quaterly']=="02/05/08/11") selected @endif value="02/05/08/11">Feb/May/Aug/Nov</option>
                      <option @if($data['month_of_quaterly']=="03/06/09/12") selected @endif value="03/06/09/12">Mar/Jun/Sep/Dec</option>
                    </select>
                    <span class="error error-month-of-quaterly" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" @if($data['recurring_type']==3) checked @endif  name="recurring_type" value="3">
                      <span class="label-span">On a particular date of month</span></label></td>
                  <td data-title="Choose Option">
                  <div class="half-boxwrap">
                  <div class="half-box">
                  <select id="date_of_month" name="date_of_month">
                      <option value="">Date of month</option>
                      <?php for($i = 1;$i<=31;$i++) { ?>
                      <option @if($data['date_of_month']==$i) selected @endif value="<?=$i;?>">
                      <?=$i;?>
                      </option>
                      <?php } ?>
                    </select>
                    <span class="error error-date-of-month" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                @php
                $day_of_week = explode(',',$data['day_of_week']);
                @endphp
                <tr>
                  <td data-title="Select Type"><label>
                      <input type="radio" @if($data['recurring_type']==2) checked @endif name="recurring_type" value="2">
                      <span class="label-span">On particular day(s) of week</span></label></td>
                  <td data-title="Choose Option"><div class="half-boxwrap"><div class="half-box"><select id="day_of_week" name="day_of_week[]" multiple="multiple">
                      <option @if(in_array("Monday",$day_of_week)) selected @endif value="Monday">Monday</option>
                      <option @if(in_array("Tuesday",$day_of_week)) selected @endif value="Tuesday">Tuesday</option>
                      <option @if(in_array("Wednesday",$day_of_week)) selected @endif value="Wednesday">Wednesday</option>
                      <option @if(in_array("Thursday",$day_of_week)) selected @endif value="Thursday">Thursday</option>
                      <option @if(in_array("Friday",$day_of_week)) selected @endif value="Friday">Friday</option>
                      <option @if(in_array("Saturday",$day_of_week)) selected @endif value="Saturday">Saturday</option>
                      <option @if(in_array("Sunday",$day_of_week)) selected @endif value="Sunday">Sunday</option>
                    </select>
                    <small>Press CTRL to choose multiple values.</small>
                    <span class="error erro-day-of-week" style="display: none;">This field is required.</span>
                    </div></div></td>
                </tr>
                <tr>
                  <td data-title="Select Type" colspan="2"><label>
                      <input type="radio" @if($data['recurring_type']==1) checked @endif name="recurring_type" value="1">
                      <span class="label-span">Everyday</span></label>
                      </td>
                </tr>
              </table>
              
              
            </div>
            </div>
          </div>
                
                 <div class="form-group row time-field half-row">
                 <div class=" col-lg-6">
                   <label>Time</label>
                    <select name="recurring_time" required class="form-control" id="recurring_time">
                    <option value="">Select Time</option>
                    @for($i=1;$i<=24;$i++)
                    @if($i<=9)
                    @php
                    $i='0'.$i;
                    @endphp
                    @endif
                    <option @if($data['recurring_time']==$i) selected @endif value="{{ $i }}">{{ $i.':00' }}</option>
                    @endfor
                    </select>
					@if ($errors->has('recurring_time'))
					<span class="error">{{ $errors->first('recurring_time') }}</span>
					@endif
                  </div>
                  <div class="col-lg-6 msg-start-date" style=" @if($data['is_recurring']==1) display:none; @endif">
                   <label>Date</label>
                    <input type="text" class="form-control" name="message_start_date" disabled="disabled" autocomplete="off" value="{{ $data['message_start_date'] }}" id="message_start_date">
					<input type="hidden" name="message_start_date_hidden" autocomplete="off" value="{{ $data['message_start_date'] }}">
					@if ($errors->has('message_start_date'))
					<span class="error">{{ $errors->first('message_start_date') }}</span>
					@endif
                  </div>
                </div>
                
                <!--<div class="form-group template-field">-->
                <!--  <div class=" col-lg-12">-->
                <!--      <label class="radio-inline">-->
                <!--    <input type="checkbox" name="send_now" value="1"> Send Now-->
                <!--    </label>-->
                <!--     </div>-->
                <!-- </div>-->
                
                    <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Message Template</label>
                    <select name="message_template" class="form-control" id="message_template">
					<option value=""> Select Message Template</option>
					@foreach($message_template as $message_template)
					<option @if($data['message_template']==$message_template['_id']) selected="selected" @endif value="{{ $message_template['_id'] }}">{{ $message_template['name_of_template'] }}</option>
					@endforeach
					<option @if($data['message_template']=="custom") selected="selected" @endif value="custom">Custom</option>
					</select>
                  </div>
                </div>
                
                <span id="result-template" @if($data['message_template']=="custom") style="display:none;" @endif>
                  <div class="add-box" >
                    @foreach($message_data as $key=>$msg_data1)
                      @if($msg_data1['gdrive_name']!='')
                      <div class="add-row">
                        <div class="form-group row @if($key!=0) data del-temp-{{ $key }} @endif ">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="upload-button upload-box"> @if($msg_data1['gdrive_name']!='') <a href="{{ url('public/uploads/thumbnail/') }}/{{ $msg_data1['gdrive_name'] }}" target="_blank"><img src="{{ url('public/uploads/thumbnail/') }}/{{ $msg_data1['gdrive_name'] }}" title="{{ $msg_data1['original_name'] }}"></a> @endif </div>
                            <div class="text-area-box">
                              <div class="msg-box">{!! nl2br($msg_data1['message_text']) !!}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @else
                      <div class="add-row">
                        <div class="form-group row @if($key!=0) data del-temp-{{ $key }} @endif ">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="text-area-box">
                              <div class="msg-box">{!! nl2br($msg_data1['message_text']) !!}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                      @endforeach
                     </div> 
                </span>
                
                
                
                <div id="append-text" class="add-box" @if($data['message_template']!="custom") style="display:none;" @endif>
                      <div class="add-row"> 
                        <div class="form-group row">
                          <div class="col-lg-12 msg-tamplate">
                            <div class="upload-button">
                            <img class="img-remove-btn remove-attachment-0" id="0" style="@if($msg_data['gdrive_name']=='') display:none; @endif" src="{{ url('assets/images/icon-delete.png') }}">
                              <label>
                              @if($msg_data['gdrive_name']!='') 
                                 <a href="{{ url('public/uploads/thumb/') }}/{{ $msg_data['gdrive_name'] }}" target="_blank">
                                 <img id="blah-0" @if($msg_data['gdrive_name']=='') style="display:none;" @endif src="{{ url('public/uploads/thumb/') }}/{{ $msg_data['gdrive_name'] }}" title="{{ $msg_data['original_name'] }}"></a>
                                <input type="hidden" name="hidden_gdrive" value="{{ $msg_data['gdrive_name'] }}">
                                <input type="hidden" name="hidden_original_name" value="{{ $msg_data['original_name'] }}">
                                @endif
                              <input type="file" name="gdrive_name" value="" class="form-control gdrive-data-0 imgInp @if($msg_data['gdrive_name']!='')  hide-input  @endif " cus="0">
                              <span class="upload-btn btn-primary btn waves-effect waves-classic"><i class="fa fa-upload" aria-hidden="true"></i>File Upload</span></label>
                            </div>
                            <div class="text-area-box">
                              <textarea class="form-control" placeholder="Message Text" name="message_text" autocomplete="off" value="" id="address">{{ $msg_data['message_text'] }}</textarea>
                             <small> Formatting Options ( Italic:_text_, Bold:*text*, Strikethrough:~text~ ) </small></div>
                          </div>
                          @if ($errors->has('message_text'))
					<span class="error">{{ $errors->first('message_text') }}</span>
					@endif
                        </div>
                      </div>
                    </div>
                    
                <div class="form-group row">
                  <div class=" col-lg-12">
                    <label>Status</label>
                    <select name="pause_task" class="form-control" id="pause_task">
					<option value="">Select Status</option>
					<option id="option-1" <?php if($data['pause_task']==0){echo 'selected="selected"';}?> value="0">Active</option>
					<option id="option-2" <?php if($data['pause_task']==1){echo 'selected="selected"';}?> value="1">Paused</option>
					</select>
                  </div>
                </div>
                    
                    <div class="form-group row creat-fms-btn">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Update Message</button>
                        <!--<a href="{{ url('whatsapp/recurring-message-listing') }}" title="Back">-->
                        <!--<button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>-->
                        <!--</a> </div>-->
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
          <h4 class="modal-title">Contact List</h4>
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
                <td><input type="checkbox" cus="{{ $list['company_name'] }} ({{$list['name_of_contact']}})" value="{{ $list['receiver_mobile_number'] }}" class="chk"></td>
                <td>{{ $list['company_name'] }}</td>
                <td>{{ $list['name_of_contact'] }}</td>
                <td>{{ $list['receiver_mobile_number'] }}</td>
            </tr>
            @endforeach
        </tbody>
        </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success add-contact">Add Contact</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
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
$(function(){
$(document).on('paste keyup', '#receiver_mobile_number_manually',function(e){
    $(this).val($(this).val().replace(/[^\d,]/g,''));
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
      }else if(jQuery("input[name='is_recurring']:checked" ).val() === "0"){
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeIn();
      jQuery('.template-field').fadeOut();
      } else {
      jQuery('.msg-start-date').fadeIn();
      jQuery('.recurring_option_hide').fadeOut();
      jQuery('.time-field').fadeOut();
      //jQuery('.template-field').fadeOut();
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
            if(result[i].length==10){
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
          //alert(receiver_mobile_number_contact[0]); return false;
             receiver_mobile_number_contact = jQuery.grep(receiver_mobile_number_contact, function(value) {
             return value != removeItem;
            //alert(value);
             });
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

@stop 