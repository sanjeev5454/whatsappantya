@extends('whatsapp.layout.app')
@section('title', 'Send Message Listing')
@section('content')
@include('whatsapp.layout.partials.sidebar') 
<!-- Page -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid1">
    <div class="panel">
      <header class="panel-heading">
        <h3 class="panel-title">WhatsappX Send Message Listing</h3>
      </header>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-15">
              <div class="right-tab"> <a class="add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-send-message') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Message Listing </a> </div>
            </div>
          </div>
        </div>
        <div class="container1 demo1">
          <?php if(@Session::get('success')!=''){?>
          <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
          <?php } ?>
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th class="list">#</th>
                <th>Name of Group/Mobile Number</th>
                <th>Message Date</th>
                <th>Image</th>
		        <th>Message Text</th>
                <th class="action-box">Action</th>
              </tr>
            </thead>
            <tbody>
            
            @php
            
            $i= 0;
            
            @endphp
            
            @foreach($data as $all_data)
            @php
            $id = $all_data['_id'];
            $oid = (array) $id;
            $id = $oid['oid'];
            $template_message_data = DB::table('tbl_template_multiple_message_data')->where('template_id',$id)->first();
            @endphp
            <tr>
              <td>{{ $i+1 }}</td>
              <td>@if($all_data['name_of_contact']==''){{ $all_data['receiver_mobile_number'] }} @else {{ nameOfContact($all_data['name_of_contact']) }} @endif</td>
              <td>{{ $all_data['message_date'] }}</td>
              <td data-table="Image" class="img-td">@if($template_message_data['gdrive_name']!='')
                      <a href="{{ url('public/uploads/thumbnail/') }}/{{ $template_message_data['gdrive_name'] }}" target="_blank"><img src="{{ url('public/uploads/thumb/') }}/{{ $template_message_data['gdrive_name'] }}" title="{{ $template_message_data['original_name'] }}"></a>
                      @endif</td>
        <td data-table="Message Text">{!! nl2br($template_message_data['message_text']) !!}</td>
              <td><a href="{{ url('whatsapp/edit-send-message/'.$all_data['_id']) }}"><i class="fa fa-edit" style="font-size:16px" aria-hidden="true"></i></a><a onclick="return confirm('Are you sure to delete the data?');" href="{{ url('whatsapp/delete-send-message/'.$all_data['_id']) }}"><i class="fa fa-trash" aria-hidden="true" style="font-size:16px; color:red;"></i></a></td>
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
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<style>

//TO-DO: tidy up style



.wrapper {

  margin-top: 5vh;

}



.dataTables_filter {

  float: right;

}



.table-hover > tbody > tr:hover {

    background-color: lighten(cyan, 40%);

}

//important if we want to add ellipsis

//to cells with content longer than width

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

  /*

	Label the data

	*/

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