@extends('nonSubscriber.base')

@section('title', 'Edit Ad')

@section('content')
	<h3 class="page-title">Edit Ad</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li><a href="{{ url('app-admin/ads') }}">Ads</a></li>
	    <li class="active"><span>Edit Ad</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('error'))
					<div class="alert alert-dismissable alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="ti ti-check"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
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
				
				<div class="panel panel-blue" data-widget='{"draggable": "false"}'>
					<!-- Panel heading -->
					<div class="panel-heading">
						<h2>Edit Ad Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('app-admin/ads/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label for="ad_name" class="col-sm-2 control-label">Customer <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<?php $customers = App\Models\Customer::all(); ?>
									<select class="form-control" name="customer_id" id="customer-id">
										<option value="choose-customer">-- Select Customer --</option>
										<option value="non-customer"{{ ($ad->customer_id == null ? ' selected' : null) }}>Non Customer</option>
										@foreach ($customers as $customer)
											<option value="{{ $customer->id }}"{{ ($ad->customer_id == $customer->id ? ' selected' : null) }}>{{ $customer->customer_name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group" id="set-addpass" style="display: none;">
								<label for="address-input" class="col-sm-2 control-label">Set Ad Password <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="add_password" placeholder="Ad Password" class="form-control" value="{{ $ad->password }}">
								</div>
							</div>

							<div class="form-group">
								<label for="address-input" class="col-sm-2 control-label">Days to show <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="days_to_show" class="form-control" value="{{ $ad->days }}">
								</div>
							</div>
							<div class="form-group">
								<label for="phone-input" class="col-sm-2 control-label">Expired Date <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<div class="input-group date" id="expire-date">
										<span class="input-group-addon"><i class="ti ti-calendar"></i></span>
										<input type="text" class="form-control" name="expire_date" value="{{ date('Y-m-d', strtotime($ad->expire_date)) }}" readonly>
									</div>
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('app-admin/ads') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
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
    <!-- DateRangePicker -->
    <link type="text/css" href="{{ asset('assets/backend/plugins/form-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
@stop

@section('page-scripts')
	<!-- Datepicker -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
@stop

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#expire-date').datepicker({
			todayHighLight: true,
			startDate: "+0d",
			format: 'yyyy-mm-dd',
			endDate: "+" + $('input[name="days_to_show"]').val() + "d"
		});

		$('input[name="days_to_show"]').change(function(){
			var val = $(this).val();

			$('#expire-date').datepicker('setEndDate', '+' + val + 'd');
		});

		$('#customer-id').change(function(){
			if ($(this).val() == 'non-customer') {
				$('#set-addpass').css('display', 'block');
			} else {
				$('#set-addpass').css('display', 'none');
			}
		});

		if ($('#customer-id').val() == 'non-customer') {
			$('#set-addpass').css('display', 'block');
		} else {
			$('#set-addpass').css('display', 'none');
		}
	});
	</script>
@stop