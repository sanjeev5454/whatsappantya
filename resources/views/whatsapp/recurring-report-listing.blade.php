@extends('whatsapp.layout.app')
@section('title', 'Reports')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="container-fluid1">
    <div class="panel">
      
      <div class="panel">
       
        <div class="container1 demo1">
		<?php if(@Session::get('success')!=''){?>
			<div class="alert alert-success">
			<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
			<?php echo Session::get('success');?>
			</div>
		<?php } ?>
		<div class="search-box-tab">
 <h3 class="panel-title">Reports</h3>
  </div>
  <div class="tab-table-fix table-layout-fixed message-planner-box report-box">
  <table class="table responsive-table dataTable">
    <thead>
      <tr>
        <th class="list list-th">#</th>
        <th class="messages-th center">Messages</th>
        <th class="contact-th center">Receiver Mobile Number</th>
        <th class="date_width center">Message Send Date</th>
		<th class="message-status-th center">Message Status</th>
      </tr>
    </thead>
    <tbody>
	@php
	$i= 1;
	@endphp
	@foreach($data as $all_data)
      <tr>
	    <td class="list" data-table="#">{{ $i }}</td>
	    <td data-table="Messages">{{ $all_data['recurring_message'] }}</td>
        <td data-table="Receiver Mobile" class="contact-no-box center"><span>{{ str_replace(',',', ',$all_data['receiver_mobile_number']) }}</span></td>
        <td data-table="Send Date"  class="center">{{ date('Y-m-d h:i A',strtotime($all_data['message_send_date'])) }}</td>
        @if($all_data['message_status']!='SENT')
        <td data-table="Message Status" class="center">{{ messageStatus($all_data['msg_id']) }}</td>
        @else
        <td data-table="Message Status" class="center">{{ $all_data['message_status'] }}</td>
        @endif
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