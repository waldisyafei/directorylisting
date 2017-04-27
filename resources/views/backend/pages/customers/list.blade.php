@extends('backend.base')

@section('title', 'Customers')

@section('content')
	<h3 class="page-title">Customers Management</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li class="active"><a href="{{ url('app-admin/customers') }}">Customers</a></li>
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
			<div class="action-menu col-md-6">
				<a class="btn btn-primary" href="{{ url('app-admin/customers/create') }}" role="button"><i class="ti ti-plus"></i> Add new Customer</a>
			</div>
			<div class="action-menu col-md-6">
				<a style="float: right;" class="btn btn-primary" href="{{ url('app-admin/customers/export') }}" role="button"><i class="ti ti-export"></i>  Export</a>
			</div>
		</div>

		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Customers List</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body no-padding">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="120">Customer ID</th>
										<th>Name</th>
										<th>PIC</th>
										<th>Created</th>
										<th>Updated</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($customers as $customer)
										<tr>
											<td style="text-align: center; font-weight: bold;">{{ $customer->customer_id }}</td>
											<td>{{ $customer->customer_name }}</td>
											<td>{{ $customer->pic }}</td>
											<td width="120">{{ date('d-m-Y H:i', strtotime($customer->created_at)) }}</td>
											<td width="120">{{ date('d-m-Y H:i', strtotime($customer->updated_at)) }}</td>
											<td width="70" style="text-align: center;">
												<div class="btn-group">
			                                        <button type="button" class="btn btn-midnightblue-alt btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			                                            <i class="ti ti-settings"></i> <span class="caret"></span>
			                                        </button>
			                                        <ul class="dropdown-menu" role="menu">
			                                            <li><a href="{{ url('app-admin/customers/profile', $customer->id) }}">Profile</a></li>
			                                            <li><a href="{{ url('app-admin/customers/edit', $customer->id) }}">Edit</a></li>
			                                            <li class="divider"></li>
			                                            <li><a href="{{ url('app-admin/customers/delete', $customer->id) }}">Delete</a></li>
			                                        </ul>
			                                    </div>
											</td>
										</tr>
									@endforeach
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