@extends('layout.app')
@section('title', 'Forgot Password')
@section('content')
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
		<div class="page-content vertical-align-middle">
			<div class="panel">
				<div class="panel-body">
					<div class="brand">
						<!--<img class="brand-img" src="{{ url('assets/images/logo-colored.png') }}" alt="...">-->
						<h2 class="brand-text font-size-18">Forgot Your Password?</h2>
					</div>
					<?php if(@Session::get('error')!=''){ ?>
					<div class="alert alert-danger">
						<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
						<?php echo Session::get('error'); ?>
					</div>
					<?php } ?>
					<form method="post" action="{{ url('forgot_password')}}" autocomplete="off">
						@csrf
						<div class="form-group form-material floating" data-plugin="formMaterial">
							<input type="email" id="email" class="form-control" value="" name="email" />
							<label class="floating-label">Enter your registered email here</label>
							@if ($errors->has('email'))
								<span class="error">{{ $errors->first('email') }}</span>
							@endif
						</div>
						<button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Send</button>
					</form>
				</div>
			</div>
			<footer class="page-copyright page-copyright-inverse">
				<p>© {{ date('Y') }}. All RIGHT RESERVED.</p>
			</footer>
		</div>
    </div><!-- End Page -->
@endsection