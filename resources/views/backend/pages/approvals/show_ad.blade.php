@extends('backend.base')

@section('title', "Review Listing")

@section('content')
	<ol class="breadcrumb">
		<li><a href="<?php echo url('app-admin/approvals') ?>">Approvals</a></li>
		<li class="active">Review Listing</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@include('backend.partials.errors')

				<div class="panel panel-blue">
					<div class="panel-heading">
						<h2>Review Listing</h2>
					</div>
					<div class="panel-body">
						<form class="form-horizontal">
							<div class="form-group">
								<span class="col-sm-2 control-label">Title</span>
								<div class="col-sm-8">
									<span><?php echo $ad->title ?></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Link</label>
								<div class="col-sm-8">
									<span><a href="http://<?php echo $ad->link ?>" target="_blank">{{ $ad->link }}</span>
								</div>
							</div>
							<?php $images = json_decode($ad->assets) ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Image</label>
								<div class="col-sm-8">
									<img src="{{ asset($images[0]) }}" alt="" class="img-rounded img-responsive">
								</div>
							</div>
						</form>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<a class="btn btn-danger" href="<?php echo url('app-admin/approvals/ads/view/'. $ad->id . '/reject') ?>" role="button">Reject</a>&nbsp;&nbsp;
								<a class="btn btn-primary" href="<?php echo url('app-admin/approvals/ads/view/'. $ad->id . '/approve') ?>" role="button">Approve</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop