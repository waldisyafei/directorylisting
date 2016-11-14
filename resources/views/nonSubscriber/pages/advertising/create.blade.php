@extends('nonSubscriber.base')

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
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				
				<div class="panel panel-blue" data-widget='{"draggable": "false"}'>
					<!-- Panel heading -->
					<div class="panel-heading">
						<h2>New Ad Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('account/ads/create') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Ad Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" class="form-control" value="{{ old('title') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Ad Link</label>
								<div class="col-sm-8">
									<input type="text" name="link" class="form-control" value="{{ old('link') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Show Date</label>
								<div class="col-sm-8">
									<input type="text" name="show_date" value="{{ old('show_date') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Package</label>
								<div class="col-sm-3">
									<select id="package-id" class="form-control" name="package_id">
										<?php $packages = App\Models\Package::all(); ?>
										@foreach ($packages as $package)
											<option value="{{ $package->id }}" data-notes="{{ $package->notes }}" data-price="{{ $package->price }}"{!! old('package_id') == $package->id ? ' selected="selected"' : null !!}>{{ $package->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="clearfix col-sm-8">
									<div class="package-info-wrapper">
										<p class="package-info"></p>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Image</label>
								<div class="col-sm-8">
									<input type="file" name="image">
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
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
@stop

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		var dataPrice = parseInt($('#package-id').find(':selected').data('price'));
		var daysTotal = parseInt($('#count-days').val());
		var billTotal = dataPrice * daysTotal;

		$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));

		$('#package-id').change(function(){

			$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));
		});

		$('input[name="show_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
	});

	Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
	    j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };
	</script>
@endsection

@section('inline-style')
<style type="text/css">
.package-info-wrapper {
    display: block;
    margin-top: 10px;
    background: #f6f6f6;
    padding: 7px 10px;
    font-size: 12px;
    font-style: italic;
    color: #888;
}
.package-info-wrapper strong {
	color: #000;
}
</style>
@stop