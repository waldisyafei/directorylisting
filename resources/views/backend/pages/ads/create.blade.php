@extends('backend.base')

@section('title', 'Create New Ad')

@section('content')
	<h3 class="page-title">Create New Ad</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li><a href="{{ url('app-admin/ads') }}">Ads</a></li>
	    <li class="active"><span>Create New Ad</span></li>
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
						<h2>New Non Customer Ads Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('app-admin/ads/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div role="tabpanel">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#ads" aria-controls="ads" role="tab" data-toggle="tab">Ads Fields</a>
									</li>
									<li role="presentation">
										<a href="#acc-info" aria-controls="acc-info" role="tab" data-toggle="tab">Account Info</a>
									</li>
								</ul>
							
								<!-- Tab panes -->
								<div class="tab-content" style="padding-top: 20px;">
									<div role="tabpanel" class="tab-pane active" id="ads">
										<div class="form-group">
											<label class="col-xs-2 control-label">Days</label>
											<div class="col-xs-8">
												<div class="row">
													<div class="col-xs-2">
														<input type="number" name="days" class="form-control" value="{{ old('days') ? old('days') : '1' }}">
													</div>
													<label class="col-xs-7 control-label" style="text-align: left;">Days</label>
												</div>
											</div>
										</div>
										<div class="form-group" id="set-addpass">
											<label for="address-input" class="col-sm-2 control-label">Set Ad Password <small style="color: red;">*</small></label>
											<div class="col-sm-8">
												<input type="text" name="password" placeholder="Ad Password" class="form-control">
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="acc-info">
										<div class="form-group">
											<label for="customer_name" class="col-sm-2 control-label">Customer Name <small style="color: red;">*</small></label>
											<div class="col-sm-8">
												<input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Customer Name" value="{{ old('customer_name') }}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Address 1<small style="color: red;">*</small></label>
											<div class="col-sm-8">
												<input type="text" name="address_1" class="form-control" value="{{ old('address_1') }}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Address 2</label>
											<div class="col-sm-8">
												<input type="text" name="address_2" class="form-control" value="{{ old('address_2') }}">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Country<small style="color: red;">*</small></label>
											<div class="col-sm-4">
												<select name="country">
													<option{{ old('country') == '' ? ' selected' : null }} disabled>-- SELECT COUNTRY--</option>
													@foreach (App\Models\Country::all() as $country)
														<option value="{{ $country->country_id }}"{!! old('country') == $country->country_id ? ' selected' : null !!}>{{ $country->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Province<small style="color: red;">*</small></label>
											<div class="col-sm-4">
												<select class="form-control" name="province">
													<option{{ old('province') == '' ? ' selected' : null }} disabled>-- SELECT PROVINCE--</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">City <small style="color: red;">*</small></label>
											<div class="col-sm-8">
												<input type="text" name="city" class="form-control" placeholder="City">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Post Code</label>
											<div class="col-sm-8">
												<input type="text" name="postcode" class="form-control" placeholder="Post Code">
											</div>
										</div>
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
    <link type="text/css" href="{{ asset('assets/backend/plugins/form-select2/select2.css') }}" rel="stylesheet">
@stop

@section('page-scripts')
	<!-- Datepicker -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-select2/select2.min.js') }}"></script>
@stop

@section('inline-script')
	<script type="text/javascript">
	$(function(){

		$('select[name="country"]').change(function(){
			var thisEl = $(this);
			var thisVal = thisEl.find(':selected').val();

			$.ajax({
				method: 'get',
				url: '{{ url('app-admin/geo/getZone') }}',
				data: {
					_token: '{{ csrf_token() }}',
					country_id: thisVal
				},
				success: function(res) {
					if (res.status === 'success') {
						var output = '';
						var results = res.results;
						var inputProvince = $('select[name="province"]');

						for (var i = 0; i < results.length; i++) {
							output += '<option value="' + results[i].zone_id + '">' + results[i].name + '</option>';
						}
						inputProvince.find('option').remove();
						inputProvince.append(output);
					}
				}
			});
		});

		$('select[name="country"]').select2({width: '100%'});
	});
	</script>
@stop