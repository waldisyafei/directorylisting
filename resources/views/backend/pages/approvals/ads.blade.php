@extends('backend.base')

@section('title', 'Item Approvals')

@section('content')
	<h3 class="page-title">Ads Approval</h3>
	<ol class="breadcrumb">
		<li><a href="{{ url('app-admin') }}">Dashboard</a></li>
		<li class="active">Ads Approvals</li>
	</ol>

	<div class="container-fluid">
		
		@include('backend.partials.errors')

		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Items List</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body no-padding">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="40">ID</th>
										<th>Title</th>
										<th>Customer ID</th>
										<th>Customer Name</th>
										<th>Status</th>
										<th width="150">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($ads as $ad)
										<tr>
											<td><?php echo $ad->id ?></td>
											<td><?php echo $ad->title ?></td>
											<td><?php echo $ad->customer ? $ad->customer_id : 'Non Customer' ?></td>
											<td><?php echo $ad->customer ? $ad->customer->customer_name : $ad->address->company ?></td>
											<td>
												@if ($ad->status == 2)
													<label class="label label-warning tooltips" title="<?php echo $ad->adStatus->info ?>"><?php echo $ad->adStatus->display_name ?></label>
												@endif
											</td>
											<td>
												<a class="btn btn-primary btn-sm tooltips" title="View Details Item" href="<?php echo url('app-admin/approvals/ads/view', $ad->id) ?>" role="button"><i class="ti ti-eye"></i></a>
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