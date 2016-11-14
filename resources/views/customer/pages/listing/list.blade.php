@extends('customer.base')

@section('title', 'My Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class="">My Listings</li>
	</ol>
	<div class="container-fluid">

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
							<div class="panel-ctrls">
								{!! $listings->render() !!}
							</div>
						</div>
						<div class="panel-body">
							<table id="listings-list" class="table table-striped table-hover">
								<thead>
									<tr>
										<th width="120">Listing ID</th>
										<th>Title</th>
										<th width="80">Image</th>
										<th>Category</th>
										<th>Expired Date</th>
										<th>Status</th>
										<th width="150">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($listings as $listing)
										<?php
											$listing_up_id = explode('-', $listing->listing_id);
											$up_id = $listing_up_id[0];
											if ($up_id == 'up') {
												continue;
											}
										$assets = json_decode($listing->assets);
										$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
										$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $assets[0]);
										?>
										<tr>
											<td class="text-center">{{ $listing->listing_id }}</td>
											<td><a href="{{ url('account/listings/edit', $listing->id) }}">{{ $listing->title }}</a></td>
											<td class="text-center">
												@if ($img_entry != '')
													<img class="img-thumbnail" src="{{ asset($img_entry) }}" width="70" height="70">
												@endif
											</td>
											<td>{{ $listing->listingCategory ? $listing->listingCategory->title : null }}</td>
											<td>{{ $listing->expired_date ? date('d M Y H:i', strtotime($listing->expired_date)) : null }}</td>
											<td>
												<?php $status = $listing->listingStatus->id; ?>
												@if ($status == 1)
													<label class="label label-default tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 2)
													<label class="label label-warning tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 3)
													<label class="label label-success">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 4)
													<label class="label label-danger tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 5)
													<label class="label label-default tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 6)
													<label class="label label-info tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif
											</td>
											<td>
	                                            <a href="{{ url('account/listings/edit', $listing->id) }}" class="btn btn-primary-alt btn-sm"><i class="ti ti-pencil"></i>&nbsp;Edit</a>&nbsp;&nbsp;
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

						<div class="panel-footer text-right">
							{!! $listings->render() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./End Listings Table -->
	</div>
@endsection

@section('page-styles')
@endsection

@section('page-scripts')
	<!-- Load page level scripts-->
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
	});
	</script>
@endsection

@section('inline-style')
<style type="text/css">
	#listings-list tr td {
		vertical-align: middle;
	}
</style>
@stop