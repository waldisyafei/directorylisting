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
			</div>
		</div>
	</div>
@endsection