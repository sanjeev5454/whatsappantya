@extends('financialsummary.layouts.fms_admin_layouts')
@section('pageTitle', 'Add Company')
@section('pagecontent')
@php
error_reporting(0);
@endphp
<style>
table.table td {
   line-height: 0px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<div class="page creat-fms-box1">
	<div class="page-content container-fluid1">
	<form class="form-horizontal" method="post" action="{{ url('financialsummary/AddCompany') }}">
	@csrf
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Company Name</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" autocomplete="off" required value="" id="company_name" name="company_name">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Add</button>
    </div>
  </div>
</form>
	</div>
	</div> 
@endsection
