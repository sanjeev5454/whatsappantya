@extends('whatsapp.layout.app')
@section('title', 'Templates')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="page creat-fms-box1">
  <div class="container-fluid1">
    <div class="panel">
      <!--<header class="panel-heading page-heading">-->
      <!--  <h3 class="panel-title">Message Templates</h3>-->
      <!--  <div class="page-header-actions">@include('whatsapp.layout.tabbing')</div>-->
      <!--</header>-->
      <div class="panel">
        <div class="container1 demo1">
            <?php if(@Session::get('success')!=''){?>
    <div class="alert alert-success custom-alert">
    <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
    <?php echo Session::get('success');?>
    </div>
<?php } ?>
	<div class="search-box-tab">
 <h3 class="panel-title">Templates</h3>
 <div class="search-box-right">
  <div class="schedule-check-btn"><a class="orange-btn add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-a-template') }}"><i class="fa fa-plus" aria-hidden="true"></i> ADD</a></div>
 </div>
  </div>
  <div class="tab-table-fix table-layout-fixed whats-app-dashboard-wrap last-row-wrap">	
  <table class="table responsive-table dataTable dashboard-table">
    <thead>
      <tr>
        <th class="list">#</th>
        <th class="name-of-template">Name of Template</th>
        <th class="image">Image</th>
		<th class="message-text">Message Text</th>
		<th class="action-box">Action</th>
      </tr>
    </thead>
    <tbody>
	@php
	$i= ($data->currentpage()-1)* $data->perpage();
	@endphp
	@foreach($data as $all_data)
	@php
	$id = $all_data['_id'];
	$oid = (array) $id;
	$id = $oid['oid'];
	$template_message_data = DB::table('tbl_template_data')->where('template_id',$id)->first();
	$ext = pathinfo($template_message_data['gdrive_name'], PATHINFO_EXTENSION);
	@endphp
        <tr>
        <td data-table="No.">{{ $i+1 }}</td>
        <td data-table="Template Name">{{ $all_data['name_of_template'] }}</td>
        <td data-table="Image" class="img-td">@if($template_message_data['gdrive_name']!='')
        <a href="{{ url('public/uploads/thumbnail/') }}/{{ $template_message_data['gdrive_name'] }}" target="_blank">
            @if($ext=='mp4')
            <img src="{{ url('public/uploads/mp4.png')}}" width="80" height="80" title="{{ $template_message_data['original_name'] }}">
            @else
            <img src="{{ url('public/uploads/thumbnail/') }}/{{ $template_message_data['gdrive_name'] }}" width="80" height="80" title="{{ $template_message_data['original_name'] }}">
            @endif
        </a>
        @endif</td>
        <td data-table="Message Text" class="message-td">{!! nl2br($template_message_data['message_text']) !!}</td>
        <td data-table="Action" class="actions white-space">
        <!--<a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('whatsapp/view-a-template/'.$all_data['_id']) }}"><i class="fa fa-eye" style="font-size:16px" aria-hidden="true"></i></a>-->
        <a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" href="{{ url('whatsapp/edit-a-template/'.$all_data['_id']) }}"><i class="fa fa-edit" style="font-size:16px" aria-hidden="true"></i></a><a class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row waves-effect waves-classic" onclick="return confirm('Are you sure to delete the data?');" href="{{ url('whatsapp/delete-message/'.$all_data['_id']) }}"><i class="fa fa-trash" aria-hidden="true" style="font-size:16px; color:red;"></i></a></td>
        </tr>
	@php
	$i++;
	@endphp
	 @endforeach
    </tbody>
  </table>
  </div>
  
  <span style="float:right;">{{ $data->links() }}</span>
</div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
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
@stop 