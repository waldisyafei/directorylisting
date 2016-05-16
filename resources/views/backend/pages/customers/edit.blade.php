@extends('backend.base')

@section('title', 'Edit Customer')

@section('content')
	<h3 class="page-title">Edit Customer</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li><a href="{{ url('app-admin/customers') }}">Customers</a></li>
	    <li class="active"><span>Edit Customer</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('success'))
					<div class="alert alert-dismissable alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="ti ti-check"></i>&nbsp; <strong>Well done!</strong> {{ Session::get('success') }}.
					</div>
				@endif
				@if (Session::has('error'))
					<div class="alert alert-dismissable alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
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
						<h2>Edit Customer Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('app-admin/customers/edit', $customer->id) }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label for="customer_name" class="col-sm-2 control-label">Customer Name <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Customer Name" value="{{ $customer->customer_name }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address 1<small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="address_1" class="form-control" value="{{ $customer->address->address_1 }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Address 2</label>
								<div class="col-sm-8">
									<input type="text" name="address_2" class="form-control" value="{{ $customer->address->address_2 }}">
								</div>
							</div>
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
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Province<small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<select class="form-control" name="province">
										<option{{ $customer->address->zone_id == '' ? ' selected' : null }} disabled>-- SELECT PROVINCE--</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">City <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="city" class="form-control" placeholder="City" value="{{ $customer->address->city }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Post Code</label>
								<div class="col-sm-8">
									<input type="text" name="postcode" class="form-control" placeholder="Post Code" value="{{ $customer->address->postcode }}">
								</div>
							</div>
							<div class="form-group">
								<label for="phone-input" class="col-sm-2 control-label">Phone <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="phone" class="form-control" id="phone-input" placeholder="Phone" value="{{ $customer->phone }}">
								</div>
							</div>
							<div class="form-group">
								<label for="fax-input" class="col-sm-2 control-label">FAX</label>
								<div class="col-sm-8">
									<input type="text" name="fax" class="form-control" id="fax-input" placeholder="FAX" value="{{ $customer->fax }}">
								</div>
							</div>

							<div class="form-group">
								<label for="pic-input" class="col-sm-2 control-label">PIC <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="pic" class="form-control" id="pic-input" placeholder="PIC" value="{{ $customer->pic }}">
								</div>
							</div>

							<div class="form-group">
								<label for="picphone-input" class="col-sm-2 control-label">PIC Phone <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="picphone" class="form-control" id="picphone-input" placeholder="PIC Phone" value="{{ $customer->pic_phone }}">
								</div>
							</div>

							<div class="form-group">
								<label for="picmobile1-input" class="col-sm-2 control-label">PIC Mobile 1 <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="picmobile1" class="form-control" id="picmobile1-input" placeholder="PIC Mobile 1" value="{{ $customer->pic_mobile1 }}">
								</div>
							</div>

							<div class="form-group">
								<label for="picmobile2-input" class="col-sm-2 control-label">PIC Mobile 2</label>
								<div class="col-sm-8">
									<input type="text" name="picmobile2" class="form-control" id="picmobile2-input" placeholder="PIC Mobile 2" value="{{ $customer->pic_mobile2 }}">
								</div>
							</div>

							<div class="form-group">
								<label for="picemail-input" class="col-sm-2 control-label">PIC Email <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="picemail" class="form-control" id="picemail-input" placeholder="PIC Email" value="{{ $customer->pic_email }}">
								</div>
							</div>

							<div class="form-group">
								<label for="picpassword-input" class="col-sm-2 control-label">PIC Password <small style="color: red;">*</small></label>
								<div class="col-sm-4">
									<input type="password" name="password" class="form-control" id="picpassword-input" placeholder="PIC Password">
									<span class="label label-default" id="generate-info" style="display: none;text-align: left;margin-top: 5px;text-transform: capitalize;padding: 3px 9px;">Please copy the password before save!</span>
								</div>
								<div class="col-sm-4">
									<button type="button" class="btn btn-primary" id="generate-pass">Generate Password</button>
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('app-admin/customers') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Update</button>
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
    <link type="text/css" href="{{ asset('assets/backend/plugins/form-select2/select2.css') }}" rel="stylesheet">                        <!-- Select2 -->
@stop

@section('page-scripts')
<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-select2/select2.min.js') }}"></script> 
@stop

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#generate-pass').click(function(){
			var randomstring = Math.random().toString(36).slice(-8);

			$('#picpassword-input').attr('type', 'text').val(randomstring);
			$('#generate-info').show(0);

		});

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

		$.ajax({
			method: 'get',
			url: '{{ url('app-admin/geo/getZone') }}',
			data: {
				_token: '{{ csrf_token() }}',
				country_id: $('select[name="country"]').find(':selected').val()
			},
			success: function(res) {
				if (res.status === 'success') {
					var output = '';
					var results = res.results;
					var inputProvince = $('select[name="province"]');
					var selectedVal = '{{ $customer->address->zone_id }}';

					for (var i = 0; i < results.length; i++) {
						if (results[i].zone_id === selectedVal) {
							output += '<option value="' + results[i].zone_id + '" selected>' + results[i].name + '</option>';
						} else {
							output += '<option value="' + results[i].zone_id + '">' + results[i].name + '</option>';
						}
					}
					inputProvince.find('option').remove();
					inputProvince.append(output);
				}
			}
		});

		$('select[name="country"]').select2({width: '100%'});
	});
	</script>
@stop