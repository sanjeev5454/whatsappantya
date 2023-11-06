@if($data['type']=='user_account_information')
<p> {!! $data['message'] !!}</p>
<p> Thanks & Regards </p>
@endif

@if($data['type']=='user_account_information_from_admin')
<p> {!! $data['message'] !!}</p>
<p> Thanks & Regards </p>
@endif

@if($data['type']=='user_account_information_to')
<p> {!! $data['message'] !!}</p>
<p> Thanks & Regards </p>
@endif
