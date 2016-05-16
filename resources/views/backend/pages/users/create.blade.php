@extends('backend.base')

@section('title', 'Create New User')

@section('content')
	<h3 class="page-title">Create New User</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li><a href="{{ url('app-admin/users') }}">Users</a></li>
	    <li class="active"><span>Create New User</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('error'))
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-check"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				@endif
				@if ($errors->has())
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				@endif
				
				<div class="panel panel-midnightblue" data-widget='{"draggable": "false"}'>
					<!-- Panel heading -->
					<div class="panel-heading">
						<h2>New User Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('app-admin/users/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label for="fullname" class="col-sm-2 control-label">Full Name <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="name" class="form-control" id="fullname" placeholder="Full Name" value="{{ old('name') }}">
								</div>
							</div>
							<div class="form-group">
								<label for="email-input" class="col-sm-2 control-label">Email <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="email" name="email" class="form-control" id="email-input" placeholder="Email" value="{{ old('email') }}">
								</div>
							</div>
							<div class="form-group">
								<label for="password-input" class="col-sm-2 control-label">Password <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="password" name="password" class="form-control" id="password-input" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label for="password-confirm-input" class="col-sm-2 control-label">Confirm Password <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="password" name="password_confirmation" class="form-control" id="password-confirm-input" placeholder="Confirm Password">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Send Email Confirm?</label>
								<div class="col-sm-8">
									<ul class="demo-btns mb-n" style="margin-top: 3px;">
										<li class="mb-n"><input class="bootstrap-switch switch-alt" type="checkbox" checked="false" data-on-color="primary" data-off-color="default" data-on-text="YES" data-off-text="NO" data-size="small"></li>
									</ul>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label">Role <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<select name="role" class="form-control">
										<option value="choose-role">-- Select Role --</option>
										<?php $roles = App\Models\Role::all(); ?>
										@foreach ($roles as $role)
											<option value="{{ $role->id }}">{{ $role->display_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('app-admin/users') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Create</button>
								</div>
							</div>
						</div>
						<!-- ./End Panel Footer -->
					</form>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page-styles')
	<!-- Code Prettifier -->
    <link type="text/css" href="{{ asset('assets/backend/plugins/codeprettifier/prettify.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link type="text/css" href="{{ asset('assets/backend/plugins/iCheck/skins/minimal/blue.css') }}" rel="stylesheet">
@stop