@extends('whatsapp.layout.app')
@section('title', 'Edit Contact')
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
          <h3 class="panel-title">Edit Contact </h3>
        </header>
        <div class="new-form">
        <h2>Edit Contact</h2>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="{{ url('whatsapp/updatecontactdetails') }}" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="{{ $data['_id'] }}">
                  @csrf
                  <div id="formsteps" class="form-group col-lg-12 col-md-12"> <span id="result_data">
                    <div class="form-group row">
                        <div class="col-lg-12">
                          <label>Company Name</label>
                        <input type="text" class="form-control"  name="company_name[]" autocomplete="off" value="{{ $data['company_name'] }}" id="company_name">
                      </div></div>
                      <div class="form-group row">
                        <div class="col-lg-12">
                          <label>Name</label>
                        <input type="text" class="form-control" required name="name_of_contact[]" autocomplete="off" value="{{ $data['name_of_contact'] }}" id="name_of_contact">
                      </div></div>
                      <div class="form-group row">
                        <div class="col-lg-12">
                          <label>Mobile Number</label>
                        <input type="text" class="form-control" required name="receiver_mobile_number[]" autocomplete="off" value="{{ $data['receiver_mobile_number'] }}" id="receiver_mobile_number">
                      </div></div>
                    </div>
                    </span>
                    <div class="add-more-contact"> 
 <a id="add-row" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Contact</a>
                      
                    </div>
                    <div class="form-group row creat-fms-btn">
                      <div class="col-md-12" style="text-align: center;">
                        <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Update Contact</button>
                        <!--<a href="{{ url('whatsapp/contact-details-listing') }}" title="Back">
                        <button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>
                        </a>--> </div>
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

<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <form action="{{ url('whatsapp/importContactDetails') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Import Contact</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="usr">Import Contact File:</label>
            <input type="file" name="import_contact" class="form-control" required id="import_contact" accept=".csv">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
    $(function(){
        //alert();
        var i = 0;
        $(document).on('click','#add-row',function(){
            i++;
            var html = '<div class="add-form-group r-'+i+'"><div class="form-group row"><div class="col-lg-12"><label>Company Name</label><input type="text" class="form-control" name="company_name[]" autocomplete="off" value="" id="company_name"></div></div><div class="form-group row"><div class="col-lg-12"><label>Name</label><input type="text" class="form-control" required name="name_of_contact[]" autocomplete="off" value="" id="name_of_contact"></div></div><div class="form-group row"><div class="col-lg-12"><label>Mobile Number</label><input type="text" class="form-control" required name="receiver_mobile_number[]" autocomplete="off" value="" id="receiver_mobile_number"></div></div><div class="minus-box"><a id="delete-row" cus="'+i+'" href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a></div></div>';
            $('#result_data').append(html);
            //alert(i);
        });
    });
</script> 
<script>
    $(function(){
        $(document).on('click','#delete-row',function(){
           var id = $(this).attr('cus');
           $('.r-'+id).remove();
        });
    });
</script> 
@stop 