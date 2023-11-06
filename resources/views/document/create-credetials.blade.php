@extends('layouts.fms_admin_layouts')
@section('pageTitle', 'Create Credential')
@section('pagecontent')
<style>
  table.table td {
    line-height: 0px;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="page creat-fms-box col-lg-6 offset-lg-3">
  <div class="page-content container-fluid">
  @if(@Session::get('success')!='')
				<div class="alert alert-success">
				<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
				<strong>Success!</strong> {{ Session::get('success') }}
				</div>
				@endif
    <form action="{{ url('admin/CredentialSubmit') }}" name="create_credential" id="create_credential" method="post">
      @csrf
      <div class="table-scrollable">
        <div class="form-group">
    <label for="email">Client Id :</label>
    <input type="text" class="form-control" id="client_id" name="client_id">
	@if ($errors->has('client_id'))
	<div class="error">{{ $errors->first('client_id') }}</div>
	@endif
  </div>
  <div class="form-group">
    <label for="pwd">Secret Key :</label>
    <input type="text" class="form-control" id="client_secret" name="client_secret">
	@if ($errors->has('client_secret'))
	<div class="error">{{ $errors->first('client_secret') }}</div>
	@endif
  </div>
  <button type="submit" class="btn btn-success">Submit</button>
  <a href="{{ url('/admin') }}"><button type="button" class="btn btn-primary">Back</button></a>    
      </div>
    </form>
	<div style="margin-top:20px;">
  <small><em>Please follow the below link how to create the google credential.</em></small>
  <br/>
  <a target="_blank" href="https://www.youtube.com/watch?v=sGLEcsRg0IM">Youtube link</a> &nbsp;&nbsp; <a target="_blank" href="
https://www.iperiusbackup.net/en/how-to-enable-google-drive-api-and-get-client-credentials/">Google Blog url</a>
  </div>
  </div>
  
</div>
 <style>
 .error{color:red;}
 </style>
@endsection