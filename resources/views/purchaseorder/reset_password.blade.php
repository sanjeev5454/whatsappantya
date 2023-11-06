@extends('purchaseorder.layout.app')
@section('title', 'Reset Password')
@section('content')
<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
	<div class="page-content vertical-align-middle">
        <div class="panel">
			<div class="panel-body">
				<div class="brand">
					<h2 class="brand-text font-size-18"> PO Reset Password</h2>
				</div>
				<?php if(@Session::get('success')!=''){?>
					<div class="alert alert-success">
						<a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong> <?php echo Session::get('success');?>
					</div>
				<?php } ?>
				<form method="post" action="{!!url('resetPassword')!!}" autocomplete="off">
					@csrf
					<div class="form-group form-material floating" data-plugin="formMaterial">
						<input type="password" id="pass" class="form-control" value="{{ old('new_password') }}" name="new_password" placeholder="New Password" />
					</div>
					<div class="form-group form-material floating" data-plugin="formMaterial">
						<input type="password" id="password" class="form-control" value="{{ old('confirm_password') }}" name="confirm_password" placeholder="Confirm Password"  autofocus/>
					</div>
					<button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Sign in</button>
				</form>
			</div>
        </div>
		<footer class="page-copyright page-copyright-inverse">
			<p>© {{ date('Y') }}. All RIGHT RESERVED.</p>
        </footer>
	</div>
</div><!-- End Page -->
@endsection
