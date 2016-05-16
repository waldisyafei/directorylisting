@extends('backend.base')

@section('title', 'Users')

@section('content')
	<h3 class="page-title">Users Management</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li class="active"><a href="{{ url('app-admin/users') }}">Users</a></li>
	</ol>

	<div class="container-fluid">
		@if (Session::has('success'))
			<div class="alert alert-dismissable alert-success">
				<i class="ti ti-check"></i>&nbsp; <strong>Well done!</strong> {{ Session::get('success') }}.
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			</div>
		@endif

		@if (Session::has('error'))
			<div class="alert alert-dismissable alert-danger">
				<i class="ti ti-check"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
		
		<div class="row">
			<div class="action-menu col-md-12">
				<a class="btn btn-primary" href="{{ url('app-admin/users/create') }}" role="button"><i class="ti ti-plus"></i> Add new User</a>
			</div>
		</div>

		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Users List</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body no-padding">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="50">ID</th>
										<th>Name</th>
										<th>Role</th>
										<th>Status</th>
										<th>Created</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($users as $user)
										<tr>
											<td>{{ $user->id }}</td>
											<td>{{ $user->name }}</td>
											<td>{{ $user->roles[0]->display_name }}</td>
											<td>{{ $user->status }}</td>
											<td>{{ date('d-m-Y H:i', strtotime($user->created_at)) }}</td>
											<td>
												<div class="btn-group">
			                                        <button type="button" class="btn btn-midnightblue-alt dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			                                            <i class="ti ti-settings"></i> <span class="caret"></span>
			                                        </button>
			                                        <ul class="dropdown-menu" role="menu">
			                                            <li><a href="{{ url('app-admin/users/profile', $user->id) }}">Profile</a></li>
			                                            <li><a href="{{ url('app-admin/users/edit', $user->id) }}">Edit</a></li>
			                                            <li class="divider"></li>
			                                            <li><a href="{{ url('app-admin/users/delete', $user->id) }}">Delete</a></li>
			                                        </ul>
			                                    </div>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="5">
												No records we are found
											</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<div class="panel-footer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

@section('page-styles')
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.themify.css') }}" rel="stylesheet">
@stop

@section('page-scripts')
	<!-- Load page level scripts-->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/demo/demo-datatables.js') }}"></script>
	<!-- End loading page level scripts-->
@stop