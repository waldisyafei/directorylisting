@extends('auth.base')

@section('title', 'Request Reset Password')

@section('content')
<div class="container" id="forgotpassword-form">
	<a href="index.html" class="login-logo"><img src="{{ asset('assets/backend/img/logo.png') }}"></a>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Login Form</h2>
				</div>
				<form method="post" action="{{ url('/password/email') }}" class="form-horizontal">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="panel-body">
						@if (session('status'))
							<div class="alert alert-success">
								{{ session('status') }}
							</div>
						@endif

						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<div class="form-group mb-n">
	                        <div class="col-xs-12">
	                        	<p>Enter your email to reset your password</p>
	                        	<div class="input-group">							
									<span class="input-group-addon">
										<i class="ti ti-user"></i>
									</span>
									<input name="email" type="text" class="form-control" placeholder="Email Address">
								</div>
	                        </div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="clearfix">
							<a href="{{ url('auth/login') }}" class="btn btn-default pull-left">Go Back</a>
							<button type="submit" class="btn btn-primary pull-right">Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection