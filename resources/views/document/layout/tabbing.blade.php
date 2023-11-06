@php

$url = explode('/',url()->current());

$new_url = end($url);

@endphp



<div class="right-tab">
<a class="add-label btn btn-primary waves-effect waves-classic" href="javascript:void(0);" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-Lebel"><i class="fa fa-plus" aria-hidden="true"></i> Add Label </a>
<a class="add-document btn btn-primary waves-effect waves-classic" href="javascript:void(0);" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal-add-document"><i class="fa fa-plus" aria-hidden="true"></i> Add Document</a>
</div>

