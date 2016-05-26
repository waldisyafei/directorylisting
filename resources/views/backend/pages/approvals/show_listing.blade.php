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
									<label class="control-label"><strong><?php echo $listing->title ?></strong></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Main Category</label>
								<div class="col-sm-8">
									<label class="control-label"><strong><?php echo $listing->listingCategory->parentCat->title ?></strong></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-8">
									<label class="control-label"><strong><?php echo $listing->listingCategory->title ?></strong></label>
								</div>
							</div>
							<div role="tabpanel" style="margin: 0 60px 40px;">
								<!-- Nav tabs -->
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active">
										<a href="#description" aria-controls="description" role="tab" data-toggle="tab">Description</a>
									</li>
									<li role="presentation">
										<a href="#review" aria-controls="tab" role="tab" data-toggle="tab">Review</a>
									</li>
									<li role="presentation">
										<a href="#custom" aria-controls="tab" role="tab" data-toggle="tab">Custom</a>
									</li>
								</ul>
							
								<!-- Tab panes -->
								<div class="tab-content" style="border: 1px solid #E2E2E2; border-top-width: 0;">
									<div role="tabpanel" class="tab-pane active" id="description" style="padding: 20px;">
										{!! $listing->content !!}
									</div>
									<div role="tabpanel" class="tab-pane" id="review" style="padding: 20px;">
										{!! $listing->review !!}
									</div>
									<div role="tabpanel" class="tab-pane" id="custom" style="padding: 20px;">
										Custom Title: {{ $listing->custom_tab_title }}
										<br><br>
										{!! $listing->custom_tab !!}
									</div>
								</div>
							</div>
							<?php $images = json_decode($listing->assets) ?>
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
								<a class="btn btn-danger" href="<?php echo url('app-admin/approvals/listings/view/'. $listing->id . '/reject') ?>" role="button">Reject</a>&nbsp;&nbsp;
								<a class="btn btn-primary" href="<?php echo url('app-admin/approvals/listings/view/'. $listing->id . '/approve') ?>" role="button">Approve</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop