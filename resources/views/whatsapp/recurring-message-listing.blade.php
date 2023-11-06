@extends('whatsapp.layout.app')
@section('title', 'Message Planner')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="container-fluid1">
    <div class="panel">
      <!--<header class="panel-heading" style="display:block !important;">
        <h3 class="panel-title">Scheduled Messages</h3>
      </header>-->
      <div class="panel">
      <!--  <div class="row">
          <div class="col-md-6">
            <div class="mb-15">
                <div class="right-tab">
<a class="add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-recurring-message') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add a Schedule </a>
</div>
                </div>
          </div>
        </div> -->
        <div class="container1 demo1">
		<?php if(@Session::get('success')!=''){?>
			<div class="alert alert-success">
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
			<?php echo Session::get('success');?>
			</div>
		<?php } ?>
<div class="search-box-tab">
 <h3 class="panel-title">Message Planner</h3>
 <div class="search-box-right">
 <div class="select-box">
      <select class="form-control" id="select-template-name">
          <option value="">Sort By Template</option>
          @foreach($temp as $temp)
          <option value="{{$temp['_id']}}">{{$temp['name_of_template']}}</option>
          @endforeach
          <option value="custom">Custom</option>
      </select>
  </div>
    <div class="form-check">
    <input type="checkbox" class="form-check-input" value="1" id="exampleCheck2">
    <label class="form-check-label" for="exampleCheck2">Show Only Paused</label>
  </div>    
  <div class="form-check">
    <input type="checkbox" class="form-check-input" value="1" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Show Only Active</label>
  </div> 
  <div class="schedule-check-btn"><a class="orange-btn add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-message-planner') }}"><i class="fa fa-plus" aria-hidden="true"></i> ADD</a></div>
 </div>
  </div>
  <div class="tab-table-fix table-layout-fixed message-planner-box">
 <div id="loader-ajax" style="display:none;"><img src="{{ url('assets/images/save_loader.png')}}"></div>
  <table class="table responsive-table dataTable t1">
    <thead>
      <tr>
        <th class="list center">#</th>
        <th class="sort ta center name-th" style="cursor:pointer;" id="heder_po_all">Name</th>
        <th class="center contact-th">Contact #</th>
        <th class="center interval-th">Interval</th>
        <th class="center schedule-date-th">Schedule Date</th>
        <th class="sort ta center date_width" style="cursor:pointer;" id="heder_vendor_all">Next Schedule</th>
		<th class="center template-th">Template</th>
		<th class="sort ta center date_width" style="cursor:pointer;" id="heder_date_all">Last Message Sent</th>
		<th class="action-box center">Action</th>
      </tr>
    </thead>
    <tbody id="results">
	@php
	$i= 1;
	
	@endphp
	@foreach($data as $all_data)
	@php
	$id = $all_data['_id'];
	$oid = (array) $id;
	$id = $oid['oid'];
	$template_message_data = DB::table('tbl_recurring_image_data')->where('recurring_id',$id)->first();
	@endphp
      <tr class="center san @if($all_data['pause_task']=="1") h-1 @endif @if($all_data['pause_task']=="0") h-0 @endif @if($all_data['message_template']!='custom') t-{{$all_data['message_template']}} @else t-custom @endif" id="del-<?php echo $all_data['_id'];?>">
	    <td class="list center" data-table="#">{{ $i }}</td>
	    <td class="name-box name-th" data-table="Name"><span>{{ $all_data['recurring_task_name'] }}</span></td>
        <td class="contact-no-box center" data-table="Contact #"><span>@if($all_data['name_of_contact']==''){{ str_replace(',',', ',$all_data['receiver_mobile_number']) }} @else {{ nameOfContact($all_data['name_of_contact']) }} @endif</span></td>
        <td class="center"  data-table="Interval">@if($all_data['recurring_type']=='5' && $all_data['is_recurring']==1) Yearly @elseif($all_data['recurring_type']=='4' && $all_data['is_recurring']==1) Quaterly @elseif($all_data['recurring_type']=='3' && $all_data['is_recurring']==1) Monthly @elseif($all_data['recurring_type']=='2' && $all_data['is_recurring']==1) Weekly @elseif($all_data['recurring_type']=='1' && $all_data['is_recurring']==1) Everyday @elseif($all_data['is_recurring']==0) One Time @elseif($all_data['recurring_type']=='')  @endif</td>
        <td class="center date_width schedule-date-th"  data-table="Schedule Date">
        @if($all_data['recurring_type']=='5' && $all_data['is_recurring']==1) 
        <span>{{ $all_data['date_of_yearly'].'-'.$all_data['month_of_yearly']}}</span>&nbsp;&nbsp;<span style="color:gray;">{{$all_data['recurring_time'] }}:00</span>
        @elseif($all_data['recurring_type']=='4' && $all_data['is_recurring']==1) 
        <span>{{ $all_data['date_of_quaterly'].'-'.$all_data['month_of_quaterly']}}</span>&nbsp;&nbsp;<span style="color:gray;">{{$all_data['recurring_time'] }}:00</span>
        @elseif($all_data['recurring_type']=='3' && $all_data['is_recurring']==1) 
        <span>{{ $all_data['date_of_month']}}</span>&nbsp;&nbsp;<span style="color:gray;">{{$all_data['recurring_time'] }}:00</span>
        @elseif($all_data['recurring_type']=='1' && $all_data['is_recurring']==1) 
        <span style="color:gray;">{{ $all_data['recurring_time'] }}:00</span> 
        @elseif($all_data['is_recurring']==0) 
        <span>{{ date('d-m',strtotime($all_data['message_start_date']))}}</span>&nbsp;&nbsp;<span style="color:gray;">{{$all_data['recurring_time'] }}:00</span> 
        @endif
        </td>
        @php
        $d = explode('-',$all_data['message_start_date']);
        $k = $d[2].'-'.$d[1].'-'.$d[0];
        $c = date('Y-m-d');
        @endphp
        @if($c<=$k && $all_data['pause_task']=="0")
        <td class="center date_width " data-table="Next Schedule">{{ $all_data['message_start_date'].' '.$all_data['recurring_time'] }}:00</td>
        @else
        <td class="center" data-table="Next Schedule"></td>
        @endif
        @if($all_data['message_template']!='custom')
        <td class="template-name-box center" data-table="Template"><span>{{ messageTemplate($all_data['message_template']) }}</span></td>
        @else
        <td class="template-name-box center" data-table="Template"><span>Custom</span></td>
        @endif
        <td align="center" class="center date_width " data-table="Last Message Sent">
        @if($all_data['report_id']!='' && $all_data['last_message_sent']!='01-01-1970 05:30')
        {{ $all_data['last_message_sent'] }}
        @else
        Not sent yet.
        @endif
        </td>
		<td class="actions white-space" data-table="Action">
		    @if($all_data['pause_task']=="0")
		    <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('whatsapp/whatsapp-message-planner/'.$all_data['_id']) }}" title="Resend"><i class="fa fa-whatsapp @if($c<=$k)green @endif" aria-hidden="true"></i></a>
		    @endif
		    <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('whatsapp/edit-message-planner/'.$all_data['_id']) }}" title="Edit"><i class="fa fa-edit" style="font-size:16px" aria-hidden="true"></i></a>
		    
		    <a @if($all_data['pause_task']=="1") style="display:none" @endif href="javascript:void(0);" cus="{{ $all_data['pause_task'] }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic pause-task pau-{{ $all_data['_id'] }}" id="{{ $all_data['_id'] }}" title="Pause"><i class="fa fa-pause" aria-hidden="true"></i></a>
		    @if($all_data['is_recurring']==0)
		    <a href="javascript:void(0);" @if($all_data['pause_task']=="0") style="display:none" @endif data-toggle="modal" data-target="#myModal" cus="{{ $all_data['pause_task'] }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic play-task pal-{{ $all_data['_id'] }} hid" id="{{ $all_data['_id'] }}" title="Play"><i class="fa fa-play" aria-hidden="true"></i></a>
		    @else
		    <a href="javascript:void(0);" @if($all_data['pause_task']=="0") style="display:none" @endif cus="{{ $all_data['pause_task'] }}" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic play-task-d pal-{{ $all_data['_id'] }} hid" id="{{ $all_data['_id'] }}" title="Play"><i class="fa fa-play" aria-hidden="true"></i></a>
		    @endif
		<a class="delete-row btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic " id="<?php echo $all_data['_id'];?>" title="Delete"  href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true" style="font-size:16px; color:red;"></i></a>
		<a href="{{ url('whatsapp/copy-message-planner/'.$all_data['_id']) }}" title="Copy" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic"><i style="font-size:16px" class="fa fa-files-o" aria-hidden="true"></i></a>
		</td>
      </tr>
	@php
	$i++;
	@endphp
	 @endforeach
    </tbody>
  </table>
  </div>
</div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
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
          <h4 class="modal-title">Assign Message Date</h4>
        </div>
        <div class="modal-body">
          Date : <input type="text" name="created_date" autocomplete="off" id="message_date" required class="form-control">
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
    </div>
    
    </div>

 <script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  

  <script>
  $( function() {
    $( "#message_date" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: 0 });
  } );
  </script>
<script type="text/javascript">
$('.delete-row').on('click', function() {
var id = $(this).attr('id');
if(id!='')
{
var check = confirm('Are you sure to delete the data?');
if(check){
$.ajax({
type: "GET",
url: "{{ url('whatsapp/recurring-delete-message/')}}/"+id,
data: {id:id},
success: function(msg){
//alert(msg); return false;
if(msg==1)
{
$('#del-'+id).remove();
}
}
});
}
}
});
</script>
<script>
    $(function(){
        $(document).on('click','.play-task',function(){
            var id = $(this).attr('id');
            $('#message-id').val(id);
        });
    });
</script>
<script>
    $(function(){
         $(document).on('click','.pause-task',function(){
            var id = $(this).attr('id');
            var status = $(this).attr('cus');
            //alert(status); //return false;
            if(id!='')
            {
                if(status==0){
                var verify = confirm('Are you sure to pause the task?');
                }else{
                var verify = confirm('Are you sure to play the task?');    
                }
                if(verify)
                {
                    $.ajax({
                    type: "GET",
                    url: "{{ url('whatsapp/recurring-pause-task/')}}/"+id+'/'+status,
                    data: {id:id,status:status},
                    success: function(msg){
                    //alert(msg); return false;
                    if(msg==1)
                    {
                        if(status==0)
                        {
                            var st = 1;
                            var title = "Play";
                            //$('.pause-task').html('<i class="fa fa-play" aria-hidden="true"></i>');
                        }else{
                            var st = 0;
                            var title = "Pause";
                            //$('.pause-task').html('<i class="fa fa-pause" aria-hidden="true"></i>');
                        }
                        //alert(st);
                   // $("#"+id).attr('cus',st);
                   // $("#"+id).attr('title',title);
                    $('.pau-'+id).hide();
                    $('.pal-'+id).show();
                    $('#del-'+id).addClass('h-1');
                    $('#del-'+id).removeClass('h-0');
                    }
                    }
                    });
                }
            }
         }); 
    });
</script>
<script>
    $(function(){
         $(document).on('click','.play-task-d',function(){
            var id = $(this).attr('id');
            var status = $(this).attr('cus');
            //alert(status); //return false;
            if(id!='')
            {
                if(status==0){
                var verify = confirm('Are you sure to pause the task?');
                }else{
                var verify = confirm('Are you sure to play the task?');    
                }
                if(verify)
                {
                    $.ajax({
                    type: "GET",
                    url: "{{ url('whatsapp/recurring-pause-task/')}}/"+id+'/'+status,
                    data: {id:id,status:status},
                    success: function(msg){
                    //alert(msg); return false;
                    if(msg==1)
                    {
                        if(status==0)
                        {
                            var st = 1;
                            var title = "Play";
                            //$('.pause-task').html('<i class="fa fa-play" aria-hidden="true"></i>');
                        }else{
                            var st = 0;
                            var title = "Pause";
                            //$('.pause-task').html('<i class="fa fa-pause" aria-hidden="true"></i>');
                        }
                        //alert(st);
                   // $("#"+id).attr('cus',st);
                   // $("#"+id).attr('title',title);
                    $('.pau-'+id).show();
                    $('.pau-'+id).attr('cus',0);
                    $('.pal-'+id).hide();
                    $('#del-'+id).addClass('h-0');
                    $('#del-'+id).removeClass('h-1');
                    }
                    }
                    });
                }
            }
         }); 
    });
</script>
<script>
    $(function(){
       $(document).on('click','#sorting',function(){
          var id = $.trim($(this).attr('cus'));
          //alert(id); return false;
          if(id=='asc'){
          var url = '<?php echo url();?>?col=asc';
          }else if(id=='desc'){
          var url = '<?php echo url();?>?col=desc';    
          }
          //alert(url);
          window.location.href=url;
       }); 
    });
</script>
<style>
/*TO-DO: tidy up style*/
.wrapper {
  margin-top: 5vh;
}
.dataTables_filter {
  float: right;
}
.table-hover > tbody > tr:hover {
    background-color: lighten(cyan, 40%);
}
/*//important if we want to add ellipsis
//to cells with content longer than width*/
.table {
  @media only screen and (min-width: 768px) {
    table-layout: fixed;
    //this declaration overwrites 
    //the default plugin style
    max-width: 100% !important;
  }
}
thead {
  background: #ddd;
}
.table td:nth-child(2) {
  overflow: hidden;
  //white-space: nowrap;
  text-overflow: ellipsis;
}
.highlight {
  background: lighten(yellow,30%);
}
@media only screen and (max-width: 767px) {
  
  /* Force table to not be like tables anymore */
  table,
  thead,
  tbody,
  th,
  td,
  tr {
    display: block;
  }
  /* Hide table headers (but not display: none;, for accessibility) */
  thead tr,
  tfoot tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }
  td {
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 50% !important;
  }
  td:before {
    /* Now like a table header */
    position: absolute;
    /* Top/left values mimic padding */
    top: 6px;
    left: 6px;
    width: 45%;
    padding-right: 10px;
    white-space: nowrap;
  }
  
  .table td:nth-child(1) {
      background: #ccc;
      height: 100%;
      top: 0;
      left: 0;
      font-weight: bold;
  }
  /* Label the data */
  td:nth-of-type(1):before {
    content: "Name";
  }
  td:nth-of-type(2):before {
    content: "Position";
  }
  td:nth-of-type(3):before {
    content: "Office";
  }
  td:nth-of-type(4):before {
    content: "Age";
  }
  td:nth-of-type(5):before {
    content: "Start date";
  }
  td:nth-of-type(6):before {
    content: "Salary";
  }
  
  .dataTables_length {
    display: none;
  }
}
</style>


<script>
    $(function(){
       $(document).on('click','#exampleCheck2',function(){
           $('#loader-ajax').show();
           $('#exampleCheck1').prop("checked",false);
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var id = $('#select-template-name').val();
            if($('#exampleCheck1').is(':checked')) {
            var exampleCheck1 = $('#exampleCheck1').val();
            }else{
            var exampleCheck1 = '';
            }
            if($('#exampleCheck2').is(':checked')) {
            var exampleCheck2 = $('#exampleCheck2').val();
            }else{
            var exampleCheck2 = '';
            }
          
            $.ajax({
            url: "{{ url('whatsapp/ajaxmessageplanner') }}" ,
            type: "POST",
            data: {id:id,exampleCheck1:exampleCheck1,exampleCheck2:exampleCheck2},
            success: function( response ) {
            //alert(response);
             $('#loader-ajax').hide();
             $('#results').html(response);
            }
            });
       });
    });
</script>


<script>
    $(function(){
       $(document).on('click','#exampleCheck1',function(){
           $('#loader-ajax').show();
           $('#exampleCheck2').prop("checked",false);
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var id = $('#select-template-name').val();
            if($('#exampleCheck1').is(':checked')) {
            var exampleCheck1 = $('#exampleCheck1').val();
            }else{
            var exampleCheck1 = '';
            }
            if($('#exampleCheck2').is(':checked')) {
            var exampleCheck2 = $('#exampleCheck2').val();
            }else{
            var exampleCheck2 = '';
            }
          
            $.ajax({
            url: "{{ url('whatsapp/ajaxmessageplanner') }}" ,
            type: "POST",
            data: {id:id,exampleCheck1:exampleCheck1,exampleCheck2:exampleCheck2},
            success: function( response ) {
            //alert(response);
            $('#loader-ajax').hide();
             $('#results').html(response);
            }
            });
       });
    });
</script>

<script>
    $(function(){
       $(document).on('change','#select-template-name',function(){
           $('#loader-ajax').show();
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var id = $(this).val();
            if($('#exampleCheck1').is(':checked')) {
            var exampleCheck1 = $('#exampleCheck1').val();
            }else{
            var exampleCheck1 = '';
            }
            if($('#exampleCheck2').is(':checked')) {
            var exampleCheck2 = $('#exampleCheck2').val();
            }else{
            var exampleCheck2 = '';
            }
          
            $.ajax({
            url: "{{ url('whatsapp/ajaxmessageplanner') }}" ,
            type: "POST",
            data: {id:id,exampleCheck1:exampleCheck1,exampleCheck2:exampleCheck2},
            success: function( response ) {
            //alert(response);
            $('#loader-ajax').hide();
             $('#results').html(response);
            }
            });
       });
    });
</script>
@endsection 

@section('pagescript') 





<script src="https://rawgit.com/padolsey/jQuery-Plugins/master/sortElements/jquery.sortElements.js"></script>
<script>
$(function(){
    var table = $('.t1');
    $('#heder_po_all, #heder_vendor_all, #heder_date_all')
        .wrapInner('<span title=""/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                if(inverse==true){
				$('.ta').addClass('sort');
				$('.ta').removeClass('dsc');
				$('.ta').removeClass('asc');
				$(this).addClass('asc');
				$(this).removeClass('sort');
				$(this).removeClass('dsc');
				}else if(inverse==false){
				$('.ta').addClass('sort');
				$('.ta').removeClass('dsc');
				$('.ta').removeClass('asc');
				$(this).addClass('dsc');
				$(this).removeClass('sort');
				$(this).removeClass('asc');
				}
                    
            });
                
        });
});
</script>


@stop 