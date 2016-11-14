@extends('backend.base')

@section('title', 'Listings')

@section('content')
	<ol class="breadcrumb">
	    <li class="">Listings</li>
	</ol>
	<div class="container-fluid">
		@if (Auth::user()->get()->can('can_create_listing'))
		<!-- Action menu -->
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

			<div class="action-menu col-md-12">
				<a class="btn btn-primary" href="{{ url('app-admin/listings/create') }}" role="button"><i class="ti ti-plus"></i> Add new Listing</a>
			</div>
		</div>
		<!-- ./End Action menu -->
		@endif

		<!-- Listings Table -->
		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Listings list</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body">
							<table id="listings-list" class="table table-striped table table-hover">
								<thead>
									<tr>
										<th>Title</th>
										<th width="80">Image</th>
										<th>Category</th>
										<th>Created</th>
										<th>Updated</th>
										<th>Status</th>
										<th width="130">Actions</th>
									</tr>
								</thead>
								<tbody>
								<?php $cate = null; ?>
									@foreach ($listings as $listing)
										<?php
										$assets = json_decode($listing->assets);
										$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
										$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $assets[0]);
										?>
										<tr>
											<td><a href="{{ url('app-admin/listings/edit', $listing->id) }}">{{ $listing->title }}</a></td>
											<td class="text-center"><img class="img-thumbnail" src="{{ asset($img_entry) }}" width="70" height="70"></td>
											<td>{{ $listing->listingCategory->title or null }}</td>
											<td>{{ date('d M Y H:i', strtotime($listing->created_at)) }}</td>
											<td>{{ date('d M Y H:i', strtotime($listing->updated_at)) }}</td>
											<td>
												<?php $status = $listing->listingStatus->id; ?>
												@if ($status == 1)
													<label class="label label-default tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 2)
													<label class="label label-warning tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 3)
													<label class="label label-success tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif

												@if ($status == 4)
													<label class="label label-danger tooltips" title="<?php echo $listing->listingStatus->info ?>">{{ $listing->listingStatus->display_name }}</label>
												@endif
											</td>
											<td>
												<?php $auth_user = Auth::user()->get(); ?>

												@if ($auth_user->can('can_approve_listing'))
													@if ($listing->status == 3)
														<a href="{{ url('app-admin/listings/suspend', $listing->id) }}" class="btn btn-warning-alt btn-sm tooltips" title="Suspend Listing"><i class="ti ti-close"></i></a>&nbsp;&nbsp;
													@elseif($listing->status == 2)
														<a href="{{ url('app-admin/approvals/listings/view/'. $listing->id . '/approve') }}" class="btn btn-success-alt btn-sm tooltips" title="Approve this listing"><i class="ti ti-check-box"></i></a>&nbsp;&nbsp;
													@endif
												@endif

												@if ($auth_user->can('can_edit_listing'))
													<a href="{{ url('app-admin/listings/edit', $listing->id) }}" class="btn btn-primary-alt btn-sm tooltips" title="Edit this listing"><i class="ti ti-pencil"></i></a>&nbsp;&nbsp;
												@endif
												
												@if ($auth_user->can('can_delete_listing'))
													<a href="{{ url('app-admin/listings/delete', $listing->id) }}" class="btn btn-danger-alt btn-sm tooltips" title="Delete this listing"><i class="ti ti-trash"></i></a>
												@endif
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