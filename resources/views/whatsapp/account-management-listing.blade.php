@extends('whatsapp.layout.app')
@section('title', 'Settings')
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
          <div class="alert alert-success"> <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a> <?php echo Session::get('success');?> </div>
          <?php } ?>
          
        <div class="search-box-tab">
        <h3 class="panel-title">Settings</h3>
        <div class="search-box-right">
        <div class="schedule-check-btn"><a class="orange-btn add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-a-setting') }}"><i class="fa fa-plus" aria-hidden="true"></i> ADD</a></div>
        </div>
        </div>
          
          <table class="table responsive-table dataTable t1">
            <thead>
              <tr>
                <th class="list">#</th>
                <th>Username</th>
                <th>Password</th>
                <th>Mobile Number</th>
                <th>Make as Default</th>
                <th class="action-box">Action</th>
              </tr>
            </thead>
            <tbody>            
            @php            
            $i= ($data->currentpage()-1)* $data->perpage();            
            @endphp            
            @foreach($data as $all_data)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $all_data['username'] }}</td>
              <td>{{ $all_data['password'] }}</td>
              <td>{{ $all_data['mobile_number'] }}</td>
              <td><input type="checkbox" @if($all_data['make_as_default']==1) checked="checked" @endif value="1" id="{{ $all_data['_id'] }}" class="default-list" name="make_default"></td>
              <td><a href="{{ url('whatsapp/edit-a-setting/'.$all_data['_id']) }}"><i class="fa fa-edit" style="font-size:16px" aria-hidden="true"></i></a><a onclick="return confirm('Are you sure to delete the data?');" href="{{ url('whatsapp/delete-account-management/'.$all_data['_id']) }}"><i class="fa fa-trash" aria-hidden="true" style="font-size:16px; color:red;"></i></a></td>
            </tr>
            @php            
            $i++;            
            @endphp            
            @endforeach
              </tbody>            
          </table>
          <span style="float:right;">{{ $data->links() }}</span> </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script type="text/javascript">
$('.default-list').on('change', function() {
$('.default-list').not(this).prop('checked', false); 
var numberOfChecked = $('input:checkbox:checked').length;
var id = $(this).attr('id');
if(numberOfChecked>0)
{
$.ajax({
type: "GET",
url: "{{ url('ajaxaccountdefault')}}/"+id,
data: {id:id},
success: function(msg){
//alert(msg); return false;
if(msg!='')
{
    //alert(msg); return false;
window.location.reload(true);
}
}
});
}
});
</script>

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