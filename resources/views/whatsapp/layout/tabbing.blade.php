@php

$url = explode('/',url()->current());

$new_url = end($url);

@endphp



<div class="right-tab">
<a class="add-label btn btn-primary waves-effect waves-classic" href="{{ url('whatsapp/add-message') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Message Template </a>
</div>

