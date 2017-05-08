@extends('customer.base')

@section('title', 'Edit Profile')

@section('content')
	<h3 class="page-title">Edit Profile</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('account') }}">Dashboard</a></li>
	    <li class="active"><span>Edit Profile</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
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
				
				@if (Session::has('success'))
					<div class="alert alert-dismissable alert-success">
						<i class="ti ti-check"></i>&nbsp; <strong>Well done!</strong> {{ Session::get('success') }}.
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				@endif
				
				<div class="panel panel-midnightblue" data-widget='{"draggable": "false"}'>
					<!-- Panel heading -->
					<div class="panel-heading">
						<h2>Edit Profile Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('account/edit_info', Auth::customer()->get()->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<!-- <div class="form-group">
								<label for="fullname" class="col-sm-2 control-label">Full Name <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="name" class="form-control" id="fullname" placeholder="Full Name" value="{{ $customer->customer_name }}">
								</div>
							</div>
							<div class="form-group">
								<label for="email-input" class="col-sm-2 control-label">Email <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="email" name="email" class="form-control" id="email-input" placeholder="Email" value="{{ $customer->pic_email }}">
								</div>
							</div> -->
							<div class="form-group">
								<label for="customer_name" class="col-sm-2 control-label">Company Name <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Company Name" value="{{ $customer->customer_name }}">
								</div>
								<label for="pic-input" class="col-sm-2 control-label">PIC Name<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="pic" class="form-control" id="pic-input" placeholder="PIC Name" value="{{ $customer->pic }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address 1<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" placeholder="Address 1" name="address_1" class="form-control" value="{{ $customer->address->address_1 }}">
								</div>
								<label for="picphone-input" class="col-sm-2 control-label">PIC Phone / Ext</label>
								<div class="col-sm-4">
									<input type="text" name="picphone" class="form-control" id="picphone-input" placeholder="PIC Phone" value="{{ $customer->pic_phone }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address 2</label>
								<div class="col-sm-4">
									<input type="text" placeholder="Address 2" name="address_2" class="form-control" value="{{ $customer->address->address_2 }}">
								</div>
								<label for="picmobile1-input" class="col-sm-2 control-label">PIC Mobile <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="picmobile1" class="form-control" id="picmobile1-input" placeholder="PIC Mobile" value="{{ $customer->pic_mobile1 }}">
								</div>
							</div>
							<div class="form-group">
								<label for="phone-input" class="col-sm-2 control-label">Phone <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="phone" class="form-control" id="phone-input" placeholder="Phone" value="{{ $customer->phone }}">
								</div>
								<label for="picemail-input" class="col-sm-2 control-label">PIC Email <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="picemail" class="form-control" id="picemail-input" placeholder="PIC Email" value="{{ $customer->pic_email }}">
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-sm-2 control-label">Province<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<select class="form-control" name="province">
										<option{{ $customer->address->zone_id == '' ? ' selected' : null }} disabled>-- SELECT PROVINCE--</option>
									</select>
								</div>
							</div> -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Country<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<select name="country">
										<option{{ old('country') == '' ? ' selected' : null }} disabled>-- SELECT COUNTRY--</option>
										@foreach (App\Models\Country::all() as $country)
											<option value="{{ $country->country_id }}"{!! $customer->address->country_id == $country->country_id ? ' selected' : null !!}>{{ $country->name }}</option>
										@endforeach
									</select>
								</div>
								<label for="phone-input" class="col-sm-2 control-label">Membership<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<select name="membership" class="form-control">
										<option value="02" {{ $customer->membership == '02' ? 'selected' : '' }}>Member</option>
										<option value="01" {{ $customer->membership == '01' ? 'selected' : '' }}>Non Member</option>
									</select>
								</div>
								<!-- <label for="picpassword-input" class="col-sm-2 control-label">PIC Password <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="password" name="password" class="form-control" id="picpassword-input" placeholder="PIC Password">
									<span class="label label-default" id="generate-info" style="display: none;text-align: left;margin-top: 5px;text-transform: capitalize;padding: 3px 9px;">Please copy the password before save!</span>
								</div> -->
							</div>
							<!-- <div class="form-group">
								<label class="col-sm-2 control-label">Post Code</label>
								<div class="col-sm-4">
									<input type="text" name="postcode" class="form-control" placeholder="Post Code" value="{{ $customer->address->postcode }}">
								</div>
							</div> -->
							<div class="form-group">
								<label class="col-sm-2 control-label">City <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="text" name="city" class="form-control" placeholder="City" value="{{ $customer->address->city }}">
								</div>
								<!-- <label for="phone-input" class="col-sm-2 control-label"></label>
								<div class="col-sm-4">
									<button type="button" class="btn btn-primary" id="generate-pass">Generate Password</button>
								</div> -->
							</div>
							<!-- <div class="form-group">
								<label for="phone-input" class="col-sm-2 control-label">Membership<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<select name="membership" class="form-control">
										<option value="02" {{ $customer->membership == '02' ? 'selected' : '' }}>Member</option>
										<option value="01" {{ $customer->membership == '01' ? 'selected' : '' }}>Non Member</option>
									</select>
								</div>
							</div> -->
							<!-- <div class="form-group">
								<label for="password-input" class="col-sm-2 control-label">Password <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="password" name="password" class="form-control" id="password-input" placeholder="Password" value="">
								</div>
							</div>
							<div class="form-group">
								<label for="password-confirm-input" class="col-sm-2 control-label">Confirm Password <small style="color: red;"></small></label>
								<div class="col-sm-8">
									<input type="password" name="password_confirmation" class="form-control" id="password-confirm-input" placeholder="Confirm Password">
								</div>
							</div> -->

							<!-- <div class="form-group">
								<label class="col-sm-2 control-label">Send Email Confirm?</label>
								<div class="col-sm-8">
									<ul class="demo-btns mb-n" style="margin-top: 3px;">
										<li class="mb-n"><input class="bootstrap-switch switch-alt" type="checkbox" checked="false" data-on-color="primary" data-off-color="default" data-on-text="YES" data-off-text="NO" data-size="small"></li>
									</ul>
								</div>
							</div> -->
							
							<!--
							<div class="form-group">
								<label class="col-sm-2 control-label">Role <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<select name="role" class="form-control">
										<option value="choose-role">-- Select Role --</option>
										<?//php// $roles = App\Models\Role::all(); ?>
										@//foreach ($roles as $role)
											<option value="{//{ $role->id }}"{//{ $customer->roles[0]->id == $role->id ? ' selected' : null }}>{//{ $role->display_name }}</option>
										@//endforeach
									</select>
								</div>
							</div>
							-->
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('account/edit_info') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Save</button>
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