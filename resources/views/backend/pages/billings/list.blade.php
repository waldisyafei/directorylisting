@extends('backend.base')

@section('title', 'Billings')

@section('content')
	<h3 class="page-title">Billings</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li class="active">Billings</li>
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

		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Billings List</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body no-padding">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="40">ID</th>
										<th>Customer ID</th>
										<th>Customer Name</th>
										<th>Invoice</th>
										<th>Item ID</th>
										<th>Item Type</th>
										<th>Created</th>
										<th>Status</th>
										<th width="80">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($billings as $billing)
										<tr>
											<td>{{ $billing->id }}</td>
											<td>{{ $billing->customer_id ? $billing->customer_id : 'Non Customer' }}</td>
											<td>
											<?php //dd($billing->customer);
												if ($billing->user_category == 1 ){
													echo $billing->customer->name;		
												} elseif ($billing->user_category == 2 ){
													echo $billing->customer->customer_name;
												}else{
													echo $billing->customer->nonsub_name;	
												}
												
											?>
											</td>
											<td>{{ $billing->get_invoice->invoice_number == null ? '' : $billing->get_invoice->invoice_number }}</td>
											<td>{{ $billing->item_id }}</td>
											<td>{{ $billing->item_type }}</td>
											<td>{{ date('d M Y H:i:s', strtotime($billing->created_at)) }}</td>
											<td>
												@if ($billing->status == 0)
													<label class="label label-default">Unpaid</label>
												@else
													<label class="label label-success">Paid</label>
												@endif
											</td>
											<td>
												<?php $auth_user = Auth::user()->get(); ?>
												@if ($auth_user->can('can_view_billing'))
	                                            	<a href="{{ url('app-admin/billings/' . $billing->item_type . '/view', $billing->id) }}" class="btn btn-success-alt btn-sm"><i class="ti ti-eye"></i>&nbsp;&nbsp;View</a>&nbsp;&nbsp;
	                                        	@endif
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
@endsection

@section('page-styles')

	<style type="text/css">
	table tr td {
		vertical-align: middle;
	}
	</style>
@endsection

@section('page-scripts')
@endsection