@extends('customer.base')

@section('title', 'Edit Ad')

@section('content')
	<h3 class="page-title">Edit Ad</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('account') }}">Dashboard</a></li>
	    <li><a href="{{ url('account/ads') }}">Ads</a></li>
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
						<h2>Edit Ad Form</h2>
					</div>
					<!-- ./End panel heading -->

					<?php
					$action = '';

					if (Request::is('noncust-ads*')) {
						$action = $ad->noncust_ad_link;
					} else {
						$action = url('account/ads/edit', $ad->id);
					}
					?>

					<form class="form-horizontal row-border" method="post" action="{{ $action }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label class="col-sm-2 control-label">Ad Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" class="form-control" value="{{ $ad->title }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">URL Link</label>
								<div class="col-sm-8">
									<input type="text" name="link" class="form-control" value="{{ $ad->link }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Days</label>
								<div class="col-sm-8">
									<input type="text" name="link" class="form-control" value="{{ $ad->days }} days left" disabled>
								</div>
							</div>
							<div class="row form-inline">
								<label class="col-sm-2 control-label">Show Date</label>
								<div class="col-sm-8">
									<input type="text" name="show_date" value="{{ $ad->show_date }}" class="form-control"> 
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Images</label>
								<div class="col-sm-8">
									<input type="file" name="image">
									<div class="images-list">
										<div class="row">
											<?php $images = json_decode($ad->assets); ?>

											<?php if (count($images) > 0): ?>
												<?php foreach ($images as $image): ?>
													<div class="col-sm-3">
														<div class="thumbnail image-entry">
															<?php
															$filename = substr($image, strrpos($image, '/') + 1);
															$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $image);
															?>
															<img src="{{ url($img_entry) }}" alt="">
														</div>
													</div>
												<?php endforeach ?>
											<?php endif ?>
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
									@if (!Request::is('noncust-ads*'))
										<a href="{{ url('nonsubs/ads') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									@endif
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

		$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));

		$('#package-id').change(function(){
			dataPrice = parseInt($('#package-id').find(':selected').data('price'));

			$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));
		});

		$('input[name="show_date"]')
			.datetimepicker({
				format: 'yyyy-mm-dd 00:00:00',
				autoclose: true,
				minView:2
			});
	});

	$(function(){
		var dataPrice = parseInt($('#package-id').find(':selected').data('price'));

		$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));

		$('#package-id').change(function(){
			dataPrice = parseInt($('#package-id').find(':selected').data('price'));

			$('.package-info').html('<i class="ti ti-info-alt"></i>&nbsp;'+$('#package-id :selected').data('notes'));
		});

		$('input[name="expired_date"]')
			.datetimepicker({
				format: 'yyyy-mm-dd 00:00:00',
				autoclose: true,
				minView:2
			});
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