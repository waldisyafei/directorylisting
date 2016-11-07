@extends('customer.base')

@section('title', 'Sub Accounts')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('subscriber') }}">Home</a></li>
	    <li class="active">Sub Accounts</li>
	</ol>
	<div class="container-fluid">
		<!-- Action menu -->
		<div class="row">
			<div class="action-menu col-md-12">
				<a class="btn btn-primary" href="{{ url('account/sub-account/create') }}" role="button"><i class="ti ti-plus"></i> Add Account</a>
			</div>
		</div>
		<!-- ./End Action menu -->

		<!-- Listings Table -->
		<div data-widget-group="group1">
			<div class="row">
				@if (Session::has('success'))
					<div class="col-md-12">
						<div class="alert alert-dismissable alert-success">
							<i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> {{ Session::get('success') }}.
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					</div>
				@endif
				@if (Session::has('error'))
					<div class="col-md-12">
						<div class="alert alert-dismissable alert-danger">
							<i class="ti ti-close"></i>&nbsp; <strong>Access denied!</strong> {{ Session::get('error') }}.
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					</div>
				@endif
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>My Listings list</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body">
							<table id="listings-list" class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Created</th>
										<th>Updated</th>
										<th>Status</th>
										<th width="150">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($accounts as $account)
										<tr>
											<td><a href="{{ url('account/listings/edit', $listing->id) }}">{{ $account->pic }}</a></td>
											<td><?php echo $account->pic_email ?></td>
											<td>{{ date('d M Y H:i', strtotime($account->created_at)) }}</td>
											<td>{{ date('d M Y H:i', strtotime($account->updated_at)) }}</td>
											<td>
	                                            <a href="{{ url('account/listings/edit', $listing->id) }}" class="btn btn-primary-alt btn-sm"><i class="ti ti-pencil"></i>&nbsp;Edit</a>&nbsp;&nbsp;
	                                            <a href="{{ url('account/listings/delete', $listing->id) }}" class="btn btn-danger-alt btn-sm"><i class="ti ti-trash"></i>&nbsp;Delete</a>
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
		<!-- ./End Listings Table -->
	</div>
@stop