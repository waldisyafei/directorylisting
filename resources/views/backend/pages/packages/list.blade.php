@extends('backend.base')

@section('title', 'Packages')

@section('content')
	<ol class="breadcrumb">
		<li>Packages</li>
	</ol>

	<div class="container-fluid">
		@if (Session::has('success'))
			<div class="alert alert-dismissable alert-success">
				<i class="ti ti-check"></i>&nbsp; <strong>Well done!</strong> {{ Session::get('success') }}.
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			</div>
		@endif

		<div class="row">
			<div class="action-menu col-md-12">
				<a class="btn btn-primary" href="{{ url('app-admin/packages/create') }}" role="button"><i class="ti ti-plus"></i> Add new Package</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-blue">
					<div class="panel-heading">
						<h2>Packages List</h2>
					</div>
					<div class="panel-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th width="50">#ID</th>
									<th>Name</th>
									<th>Price</th>
									<th>Active Days</th>
									<th>Discount</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($packages as $package)
									<tr>
										<td>{{ $package->id }}</td>
										<td>{{ $package->name }}</td>
										<td>IDR {{ number_format($package->price, 0, ',', '.') }}</td>
										<td>{{ $package->days }} days</td>
										<td>{{ $package->discount }}%</td>
										<td width="150">
											<a href="{{ url('app-admin/packages/edit', $package->id) }}" class="btn btn-primary-alt btn-sm"><i class="ti ti-pencil"></i>&nbsp;Edit</a>&nbsp;&nbsp;
											<a href="{{ url('app-admin/packages/delete', $package->id) }}" class="btn btn-danger-alt btn-sm"><i class="ti ti-trash"></i>&nbsp;Delete</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>


				<div class="panel panel-blue">
					<form method="post" action="{{ url('app-admin/settings/expiry') }}" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
							<h2>Expiry Days Settings</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Almost Expired Days of Listings/Ads Packages</label>
								<div class="col-sm-2">
									<input type="number" name="almost_expired" class="form-control" value="{{ Setting::get('site_settings.almost_expired') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Max Days Auto Suspend Expiry</label>
								<div class="col-sm-2">
									<input type="number" name="auto_suspend" class="form-control" value="{{ Setting::get('site_settings.auto_suspend') }}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Max Days Auto Delete For Expiry</label>
								<div class="col-sm-2">
									<input type="number" name="auto_delete" class="form-control" value="{{ Setting::get('site_settings.auto_delete') }}">
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
@endsection