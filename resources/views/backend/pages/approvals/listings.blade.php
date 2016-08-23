@extends('backend.base')

@section('title', 'Item Approvals')

@section('content')
	<h3 class="page-title">Listings Approval</h3>
	<ol class="breadcrumb">
		<li><a href="{{ url('app-admin') }}">Dashboard</a></li>
		<li class="active">Listings Approvals</li>
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
										<th>Listing ID</th>
										<th>Customer ID</th>
										<th>Customer Name</th>
										<th>Status</th>
										<th width="150">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($listings as $listing)
										<?php
											$listing_up_id = explode('-', $listing->listing_id);
											$up_id = $listing_up_id[0];
											if ($up_id !== 'up') {
												continue;
											}
										?>
										<tr>
											<td><?php echo $listing->id ?></td>
											<td><?php echo $listing->title ?></td>
											<td><?php echo $listing->listing_id ?></td>
											<td><?php echo $listing->customer_id ?></td>
											<td><?php echo $listing->customer->customer_name ?></td>
											<td>
												@if ($listing->status == 2)
													<label class="label label-warning tooltips" title="<?php echo $listing->listingStatus->info ?>"><?php echo $listing->listingStatus->display_name ?></label>
												@endif
											</td>
											<td>
												<a class="btn btn-primary btn-sm tooltips" title="View Details Item" href="<?php echo url('app-admin/approvals/listings/view', $listing->id) ?>" role="button"><i class="ti ti-eye"></i></a>
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