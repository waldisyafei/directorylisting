@extends('backend.base')

@section('title', 'Edit Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('account/listings') }}">My Listings</a></li>
	    <li>Edit Listings</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			@if (Session::has('error'))
				<div class="col-md-12">
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-check"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				</div>
			@endif
			@if (Session::has('success'))
				<div class="col-md-12">
					<div class="alert alert-dismissable alert-success">
						<i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> {{ Session::get('success') }}.
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				</div>
			@endif
			@if ($errors->has())
				<div class="col-md-12">
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				</div>
			@endif

			<form method="post" action="{{ url('app-admin/listings/edit', $listing->id) }}" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-12">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<h2>Edit Listing Form</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" value="{{ $listing->title }}" class="form-control">
								</div>
							</div>
							<?php
							$categories = \App\Models\ListingCategory::all();
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Main Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="category">
										<option value="choose-category"{{ $listing->category == null ? ' selected' : null }} disabled>-- SELECT MAIN CATEGORY --</option>
										@foreach ($categories as $category)
											@if ($category->parent == 0)
												<option value="{{ $category->id }}">
												{{ $category->title }}
												</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Sub Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="sub_category">
										<option value="choose-category"{{ $listing->category == null ? ' selected' : null }}>-- SELECT SUB CATEGORY --</option>
									</select>
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
										<div class="form-group">
											<div class="col-sm-10">
												<textarea id="listing-content" name="content" rows="10">{!! $listing->content !!}</textarea>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="review" style="padding: 20px;">
										<div class="form-group">
											<div class="col-sm-10">
												<textarea id="listing-review" name="review" rows="10">{!! $listing->review !!}</textarea>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="custom" style="padding: 20px;">
										<div class="form-group">
											<label class="col-sm-2 control-label">Custom Title</label>
											<div class="col-sm-10">
												<input type="text" name="custom_title" value="{!! $listing->custom_tab_title !!}" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-10">
												<textarea id="listing-custom" name="custom" rows="10">{!! $listing->custom_tab !!}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Keywords</label>
								<div class="col-sm-8">
									<input type="text" name="keywords" value="{{ $listing->keywords }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-8">
									<input type="text" name="tags" value="{{ $listing->tags }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">URL Website</label>
								<div class="col-sm-8">
									<input type="text" name="url" value="{{ $listing->url }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Price Range</label>
								<div class="col-sm-4">
									<input type="text" name="price_from" value="{{ $listing->price_from }}" class="form-control">
								</div>
								<div class="col-sm-4">
									<input type="text" name="price_to" value="{{ $listing->price_to }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Images</label>
								<div class="col-sm-8">
									<input type="file" name="image">
									<div class="images-list">
										<div class="row">
											<?php $images = json_decode($listing->assets); ?>

											@if ($images)
												@foreach ($images as $image)
												<div class="col-sm-3">
													<div class="thumbnail image-entry">
														<?php
														$filename = substr($image, strrpos($image, '/') + 1);
														$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $image);
														?>
														<img src="{{ url($img_entry) }}" alt="">
													</div>
												</div>
												@endforeach
											@endif
												
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('account/listings') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Update</button>
								</div>
							</div>
						</div>
						<!-- ./End Panel Footer -->
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@section('page-styles')
<!-- Summernote -->
<link type="text/css" href="{{ asset('assets/backend/plugins/summernote/dist/summernote.css') }}" rel="stylesheet">
@endsection

@section('page-scripts')
<!-- Summernote -->
<script type="text/javascript" src="{{ asset('assets/backend/plugins/summernote/dist/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#listing-content, #listing-review, #listing-custom').summernote({
			height: 300
		});

		$('input[name="show_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});

		$('select[name="category"]').change(function(){
			var thisVal = $(this).find(':selected').val();
			var subCatEl = $('select[name="sub_category"]');

			$.ajax({
				method: 'get',
				url: '{{ url('account/listings/get_sub_categories') }}',
				data: {
					_token: '{{ csrf_token() }}',
					main_id: thisVal
				},
				success: function(res) {
					if (res.status === 'success') {
						var output = '';
						var categories = res.categories;

						for (var i = 0; i < categories.length; i++) {
							output += '<option value="' + categories[i].id + '">' + categories[i].title + '</option>';
						}

						subCatEl.find('option').remove();
						subCatEl.append(output);
					}
				}
			});
		});

		if ($('select[name="category"]').find(':selected').val() != '') {
			var subCatEl = $('select[name="sub_category"]');
			$.ajax({
				method: 'get',
				url: '{{ url('account/listings/get_sub_categories') }}',
				data: {
					_token: '{{ csrf_token() }}',
					main_id: $('select[name="category"]').find(':selected').val()
				},
				success: function(res) {
					if (res.status === 'success') {
						var output = '';
						var categories = res.categories;
						var currentCat = '{{ $listing->category }}';

						for (var i = 0; i < categories.length; i++) {
							if (currentCat === categories[i].id) {
								output += '<option value="' + categories[i].id + ' selected">' + categories[i].title + '</option>';
							} else {
								output += '<option value="' + categories[i].id + '">' + categories[i].title + '</option>';
							}
						}

						subCatEl.find('option').remove();
						subCatEl.append(output);
					}
				}
			});
		}
	});
	</script>
@endsection

@section('inline-style')
<style type="text/css">
.image-entry {
    position: relative;
    height: 120px;
    text-align: center;
}
.image-entry #add-image {
    position: absolute;
    font-size: 53px;
    width: 100%;
    height: 100%;
    text-align: center;
    left: 0px;
    top: 0px;
}
.image-entry #add-image i {
    margin-top: 20px;
    display: inline-block;
}
.image-entry {
	margin-bottom: 15px;
}
</style>
@stop