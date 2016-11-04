@extends('backend.base')

@section('title', 'Ads')

@section('content')
	<ol class="breadcrumb">
		<li class="active">Ads</li>
	</ol>
	<div class="container-fluid">

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
						<h2>My Ads List</h2>
					</div>
					<div class="panel-body">
						<table id="table-ads" class="table table-striped table-hover">
							<thead>
								<tr>
									<th width="80">Ad ID</th>
									<th width="100">Image</th>
									<th width="100">Title</th>
									<th width="100">Status</th>
									<th>Sisa Tampil</th>
									<th width="100">URL Link</th>
									<th width="100">Expired Date</th>
									<th width="150">Action</th>
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
									<td><a href="{{ url('nonsubs/ads/edit', $ad->id) }}">{{ $ad->title }}</a></td>
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
									<td>
										<?php if ($ad->status != 5 && $ad->status != 1  && $ad->status != 6): ?>
											<?php if ($ad->expired_date != ''): ?>
												<?php
												$now_date = date('Y-m-d H:i:s');
												$now_time = strtotime($now_date);
												$show_datetime = strtotime($ad->show_date);
												$show_date = new DateTime($ad->show_date);
												$current_date = new DateTime($now_date);
												$expired_date = new DateTime($ad->expired_date);

												if ($now_time >= $show_datetime) {
													$remainings = $expired_date->diff($current_date);
												} else {
													$remainings = $expired_date->diff($show_date);
												}
												echo $remainings->format("%a days, %h hours, %i minutes, %s seconds");
												?>
											<?php endif ?>
										<?php endif ?>
											
									</td>
									<td><?php if( $ad->link )echo $ad->link; ?></td>
									<td>
										<?php if ($ad->status != 1 && $ad->status != 5 && $ad->status != 6): ?>
											<?php echo date('d M Y H:i', strtotime($ad->expired_date)) ?>
										<?php endif ?>
									</td>
									<td>
                                        <a href="{{ url('app-admin/ads/edit', $ad->id) }}" class="btn btn-primary-alt btn-sm"><i class="ti ti-pencil"></i>&nbsp;Edit</a>
                                        <a href="{{ url('app-admin/ads/renew', $ad->id) }}" class="btn btn-primary-alt btn-sm"><i class="ti ti-pencil"></i>&nbsp;Renew</a>
									</td>
								</tr>
							<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection