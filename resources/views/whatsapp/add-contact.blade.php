@extends('whatsapp.layout.app')

@section('title', 'Create a Group')

@section('content')

@include('whatsapp.layout.partials.sidebar') 

<!-- Page -->

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="page creat-fms-box1">
  <div class="page-content container-fluid">
    <div class="panel">
      <div class="pane-body">
        <header class="panel-heading">
          <h3 class="panel-title">Create a Group</h3>
        </header>
        <div class="new-form">
          <h2>Create a Group</h2>
        <div class="row">
          <div class="col-md-6 col-lg-6">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="{{ url('whatsapp/savecontact') }}" enctype="multipart/form-data">
                  @csrf
                  <div id="formsteps" class="form-group col-lg-12 col-md-12">
                    <div class="form-group row">
                      <div class=" col-lg-12">
                        <label>Name of Groups</label>
                        <input type="text" class="form-control" name="name_of_contact" autocomplete="off" value="{{ old('name_of_contact') }}" id="name_of_contact">
                        @if ($errors->has('name_of_contact')) <span class="error">{{ $errors->first('name_of_contact') }}</span> @endif </div>
                    </div>
                    <div class="form-group row">
                      <div class=" col-lg-12">
                        <label>Receiver mobile no(s) </label>
                        <textarea class="form-control" name="receiver_mobile_number" autocomplete="off" value="" id="receiver_mobile_number">{{ old('receiver_mobile_number') }}</textarea>
                        <small><em>(Add multiple mobile numbers separated by a comma (,). For e.g 9811XXXXXX, 9812XXXXXX)</em></small> @if ($errors->has('receiver_mobile_number')) <span class="error">{{ $errors->first('receiver_mobile_number') }}</span> @endif </div>
                    </div>
                    <div class="form-group row creat-fms-btn">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Save Group</button>
                       <!-- <a href="{{ url('whatsapp/contact-listing') }}" title="Back">
                        <button type="button" class="btn btn-danger waves-effect waves-classic waves-effect waves-classic waves-effect waves-classic"> Back</button>
                        </a> --> </div>
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
<script src="https://code.jquery.com/jquery-2.2.4.js"></script> 
@stop 