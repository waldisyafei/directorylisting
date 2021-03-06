@extends('backend.base')

@section('title', 'Ads')

@section('content')
	<h3 class="page-title">Ads Management</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li class="active">Ads</li>
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
							<h2>Ads List</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body no-padding">
							<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th width="80">Ad ID</th>
										<th width="100">Image</th>
										<th width="100">Title</th>
										<th width="100">Status</th>
										<th>Non Customer Link Ads</th>
										<th width="150">Show Date</th>
										<th width="130">Actions</th>
										<!-- <th>Action</th> -->
									</tr>
								</thead>
								<tbody>
									<?php foreach ($ads as $ad): ?>
									<?php
									$assets = json_decode($ad->assets);
									$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
									$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $assets[0]);
									?>
									<tr>
										<td class="text-center">{{ $ad->ad_id }}</td>
										<td class="text-center">
											<?php if ($img_entry != ''): ?>
												<img class="img-thumbnail" src="{{ asset($img_entry) }}" width="70" height="70">
											<?php endif ?>
										</td>
										<td><a href="{{ url('app-admin/ads/edit', $ad->id) }}">{{ $ad->title }}</a></td>
										<td>
											<?php $status = $ad->adStatus->id; ?>
											@if ($status == 1)
												<label class="label label-default tooltips" title="<?php echo $ad->adStatus->info ?>">{{ $ad->adStatus->display_name }}</label>
											@endif

											@if ($status == 2)
												<label class="label label-warning tooltips" title="<?php echo $ad->adStatus->info ?>">{{ $ad->adStatus->display_name }}</label>
											@endif

											@if ($status == 3)
												<label class="label label-success">{{ $ad->adStatus->display_name }}</label>
											@endif

											@if ($status == 4)
												<label class="label label-danger tooltips" title="<?php echo $ad->adStatus->info ?>">{{ $ad->adStatus->display_name }}</label>
											@endif

											@if ($status == 5)
												<label class="label label-default tooltips" title="<?php echo $ad->adStatus->info ?>">{{ $ad->adStatus->display_name }}</label>
											@endif

											@if ($status == 6)
												<label class="label label-info tooltips" title="<?php echo $ad->adStatus->info ?>">{{ $ad->adStatus->display_name }}</label>
											@endif
										</td>
										<td><?php if( $ad->link )echo $ad->link; ?></td>
										<td>{{ $ad->show_date != '' ? date('d M Y H:i', strtotime($ad->show_date)) : null }}</td>
										<td>
												<?php $auth_user = Auth::user()->get(); ?>

												@if ($auth_user->can('can_approve_ads'))
													@if ($ad->status == 3)
														<a href="{{ url('app-admin/ads/suspend', $ad->id) }}" class="btn btn-warning-alt btn-sm tooltips" title="Suspend Listing"><i class="ti ti-close"></i></a>&nbsp;&nbsp;
													@elseif($ad->status == 2)
														<a href="{{ url('app-admin/approvals/ads/view/'. $ad->id . '/approve') }}" class="btn btn-success-alt btn-sm tooltips" title="Approve this ad"><i class="ti ti-check-box"></i></a>&nbsp;&nbsp;
													@endif
												@endif

												@if ($auth_user->can('can_edit_ads'))
													<a href="{{ url('app-admin/ads/edit', $ad->id) }}" class="btn btn-primary-alt btn-sm tooltips" title="Edit this ad"><i class="ti ti-pencil"></i></a>&nbsp;&nbsp;
												@endif
												
												@if ($auth_user->can('can_delete_ads'))
													<a href="{{ url('app-admin/ads/delete', $ad->id) }}" class="btn btn-danger-alt btn-sm tooltips" title="Delete this ad"><i class="ti ti-trash"></i></a>
												@endif
											</td>
									</tr>
								<?php endforeach ?>
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

	<style type="text/css">
	table tr td {
		vertical-align: middle;
	}
	</style>
@stop

@section('page-scripts')
@stop
