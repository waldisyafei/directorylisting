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

			<form method="post" action="{{ url('app-admin/listings/edit', $listing->id) }}" class="form-horizontal">
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
							<div class="form-group">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="category">
										<option value="choose-category"{{ $listing->category == null ? ' selected' : null }}>-- SELECT CATEGORY --</option>
										<?php
										$categories = \App\Models\ListingCategory::all();
										?>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}"{{ $listing->category == $category->id ? ' selected' : null }}>{{ $category->title }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Content</label>
								<div class="col-sm-8">
									<textarea id="listing-content" name="content" rows="10">{!! $listing->content !!}</textarea>
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
								<label class="col-sm-2 control-label">Images</label>
								<div class="col-sm-8">
									<div class="images-list">
										<div class="row">
											<?php $images = json_decode($listing->assets); ?>
											
											<!--@//foreach ($images as $image)
											<div class="col-sm-3">
												<div class="thumbnail image-entry">
													<?php
													//$filename = substr($image, strrpos($image, '/') + 1);
													//$img_entry = str_replace($filename, 'thumb-admin-'.$filename, $image);
													?>
													<img src="{//{ url($img_entry) }}" alt="">
												</div>
											</div>
											@//endforeach-->
											
											<div class="col-sm-3">
												<div class="thumbnail image-entry">
													<a href="#" id="add-image" class="tooltips" data-trigger="hover" data-original-title="Click to add image(s)"><i class="ti ti-plus"></i></a>
												</div>
											</div>
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
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#listing-content').summernote({
			height: 300
		});

		$('#add-image').click(function(e){
			$(this).after('<input type="file" id="image-selector" accept="image/*" style="width:0;height:0;padding:0;margin:0;visibility:hidden;">');

			$('#image-selector').click();

			e.preventDefault();
		});

		$(document).on('change', '#image-selector', function(e){
			var file = e.target.files[0];
			console.log(file);
			var data = new FormData();
			var token = '{{ csrf_token() }}';

			data.append('_token', token);
			data.append('image', file);
			data.append('title', 'just title');
			$.ajax({
				method: 'POST',
				data: data,
				headers:
   				{
        			'X-CSRF-Token': $('input[name="_token"]').val()
    			},
				url: '{{ url('account/listings/upload_image/') }}',
				cache: false,
				//dataType: 'json',
				processData: false,
				contentType: false,
				success: function(data, textStatus, jqXHR) {
					console.log(data);
					if (data.status == 'success') {
						var thumbDom = null;
						console.log('success');
						thumbDom = '<div class="col-md-3"><div class="thumbnail image-entry">';
						thumbDom += '<img src="/' +data.relative_thumb_admin_path+'" alt="">';
						thumbDom += '<input type="hidden" name="images[]" value="'+ data.relative_path +'">';
						thumbDom += '</div></div>';

						$('.images-list .row').prepend(thumbDom);
					} else {
						console.log('not success');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Hangle errors
					console.log('ERRORS: ' + textStatus);

				}
			})
		});
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