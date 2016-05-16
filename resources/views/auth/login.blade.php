@extends('auth.base')

@section('title', 'Login')

@section('content')
	<div class="container" id="login-form">
		<a href="index.html" class="login-logo"><img src="{{ asset('assets/backend/img/logo.png') }}"></a>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				@if (Session::has('error'))
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<p>{{ Session::get('error') }}</p>
					</div>
				@endif
				@if (count($errors) > 0)
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>Login Form</h2>
					</div>
					<?php
					$action = '';

					if (Request::is('auth-customers/login')) {
						$action = url('auth-customers/login');
					}
					elseif (Request::is('noncust-ads/login')) {
						$action = url('noncust-ads/login');
					}
					else {
						$action = url('app-admin/auth/login');
					}
					?>
					<form method="post" action="{{ $action }}" class="form-horizontal" id="validate-form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-body">
							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">							
										<span class="input-group-addon">
											<i class="ti ti-user"></i>
										</span>
										<input type="text" name="<?php echo $action == url('noncust-ads/login') ? 'ads_id' : 'email'; ?>" class="form-control" placeholder="<?php echo $action == url('noncust-ads/login') ? 'Ads ID' : 'Email'; ?>" data-parsley-minlength="6" placeholder="At least 6 characters" required value="{{ old('email') }}">
									</div>
		                        </div>
							</div>

							<div class="form-group mb-md">
		                        <div class="col-xs-12">
		                        	<div class="input-group">
										<span class="input-group-addon">
											<i class="ti ti-key"></i>
										</span>
										<input type="password" name="password" class="form-control" placeholder="Password">
									</div>
		                        </div>
							</div>

							@if ($action !== url('noncust-ads/login'))
								<div class="form-group mb-n">
									<div class="col-xs-12">
										<a href="{{ url('password/email') }}" class="pull-left">Forgot password?</a>
										<div class="checkbox-inline icheck pull-right p-n">
											<label for="">
												<input type="checkbox" name="remember"></input>
												Remember me
											</label>
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="panel-footer">
							<div class="clearfix">
								<button type="submit" class="btn btn-primary pull-right">Login</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop