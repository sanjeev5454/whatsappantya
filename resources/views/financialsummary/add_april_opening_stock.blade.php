@extends('layouts.fms_admin_layouts')
@section('pageTitle', 'Add April Opening Stock')
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
	<form class="form-horizontal" method="post" action="{{ url('admin/AddAprilOpeningStock') }}">
	@csrf
  <div class="form-group">
    <label class="control-label col-sm-2" for="email">Stock & Purchase-B:</label>
    <div class="col-sm-5">
      <input type="text" class="form-control number" autocomplete="off" value="{{ $add_april_opening_stock['stock_purchase_b'] }}" id="stock_purchase_b" name="stock_purchase_b">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Stock & Purchase-X:</label>
    <div class="col-sm-5">
      <input type="type" class="form-control number" autocomplete="off" value="{{ $add_april_opening_stock_x['stock_purchase_x'] }}" id="stock_purchase_x" name="stock_purchase_x">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-info">Add</button>
    </div>
  </div>
</form>
	</div>
	</div>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
<script>
$(function(){
$(document).on('paste keyup', '.number',function(e){
    $(this).val($(this).val().replace(/[^-\d]/g, ''));
  });
});
</script>
@endsection
