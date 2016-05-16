@extends('backend.base')

@section('title', 'Listings Settings')

@section('content')
	<ol class="breadcrumb">
		<li>Settings</li>
		<li>Ads Settings</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('success'))
					<div class="alert alert-success">
						{{ Session::get('success') }}
					</div>
				@endif
				@if ($errors->has())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="panel panel-blue">
					<form method="post" action="{{ url('app-admin/settings/ads-price') }}" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
							<h2>Ads Price Settings</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Price Per Day</label>
								<div class="col-sm-5">
									<input type="text" name="price" class="form-control" value="{{ Setting::get('ads.price_per_day') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount</label>
								<div class="col-sm-5">
									<input type="number" name="discount" class="form-control" value="{{ Setting::get('ads.price_discount') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Notes/Info</label>
								<div class="col-sm-5">
									<textarea class="form-control" name="notes" rows="4">{{ Setting::get('ads.price_notes') }}</textarea>
								</div>
							</div>
						</div>

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<button class="btn-primary btn">Save</button>
								</div>
							</div>
						</div>
						<!-- ./End Panel Footer -->
					</form>
				</div>

				<br><br>
				<div class="panel panel-blue">
					<form method="post" action="{{ url('app-admin/settings/noncust-ads-price') }}" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
							<h2>Non Customer Ads Price Settings</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Price Per Day</label>
								<div class="col-sm-5">
									<input type="text" name="price" class="form-control" value="{{ Setting::get('ads.noncust.price_per_day') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Discount</label>
								<div class="col-sm-5">
									<input type="number" name="discount" class="form-control" value="{{ Setting::get('ads.noncust.price_discount') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Notes/Info</label>
								<div class="col-sm-5">
									<textarea class="form-control" name="notes" rows="4">{{ Setting::get('ads.noncust.price_notes') }}</textarea>
								</div>
							</div>
						</div>

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
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