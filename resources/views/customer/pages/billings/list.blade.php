@extends('customer.base')

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
										<th>Item Name</th>
										<th>Item ID</th>
										<th>Item Type</th>
										<th>Amount</th>
										<th>Created</th>
										<th>Status</th>
										<th width="150">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($billings as $billing)
										<tr>
											<td>{{ $billing->id }}</td>
											<td>{{ $billing->item->title }}</td>
											<td>{{ $billing->item_id }}</td>
											<td>{{ $billing->item_type }}</td>
											<td>IDR {{ number_format($billing->amount, 0, ',', '.') }}</td>
											<td>{{ date('d M Y H:i:s', strtotime($billing->created_at)) }}</td>
											<td>
												@if ($billing->status > 0)
													<label class="label label-success">Paid</label>
												@else
													<label class="label label-default">Unpaid</label>
												@endif
											</td>
											<td>
												<a href="{{ url('account/billings/view', $billing->id) }}" class="btn btn-success-alt btn-sm"><i class="ti ti-eye"></i>&nbsp;&nbsp;View</a>
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