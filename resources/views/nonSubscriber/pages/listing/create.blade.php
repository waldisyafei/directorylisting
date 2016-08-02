@extends('customer.base')

@section('title', 'Create New Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('account/listings') }}">My Listings</a></li>
	    <li>Create New Listings</li>
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

			<form method="post" action="{{ url('account/listings/create') }}" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-12">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<h2>New Listing Form</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" value="{{ old('title') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="category">
										<option value="choose-category">-- SELECT CATEGORY --</option>
										<?php
										$categories = \App\Models\ListingCategory::all();
										?>
										@foreach ($categories as $category)
											<!-- <option value="{{ $category->id }}"{{ old('tags') == $category->id ? ' selected' : null }}>{{ $category->title }}</option> -->
											<?php
											$childrens = $category->children()->get();
											?>
											@if ($category->parent == 0 || $category->parent == null)
												<optgroup label="<?php echo $category->title ?>">
													@foreach ($childrens as $children)
														<option value="{{ $children->id }}"{{ old('category') == $children->id ? ' selected' : null }}>{{ $children->title }}</option>
													@endforeach
												</optgroup>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Content</label>
								<div class="col-sm-8">
									<textarea id="listing-content" name="content" rows="10">{{ old('content') }}</textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Keywords</label>
								<div class="col-sm-8">
									<input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-8">
									<input type="text" name="tags" value="{{ old('tags') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Show Date</label>
								<div class="col-sm-8">
									<input type="text" name="show_date" value="{{ old('show_date') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">URL Website</label>
								<div class="col-sm-8">
									<input type="text" name="url" value="{{ old('url') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Price Range</label>
								<div class="col-sm-4">
									<input type="text" name="price_from" value="{{ old('price_from') }}" class="form-control">
								</div>
								<div class="col-sm-4">
									<input type="text" name="price_to" value="{{ old('price_to') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="clearfix">
									<label class="col-sm-2 control-label">Package</label>
									<div class="col-sm-4">
										<select id="package-chooser" class="form-control" name="package">
											<?php $packages = App\Models\Package::all(); ?>

											<option>-- SELECT PACKAGE --</option>
											@foreach ($packages as $package)
												<option value="{{ $package->id }}" data-notes="{!! $package->notes !!}"{{ old('package') == $package->id ? ' selected' : null }}>{{ $package->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="col-sm-6">&nbsp;</div>
								</div>
								<div class="clearfix">
									<div class="col-sm-2">&nbsp;</div>
									<div class="col-sm-8" id="package-info"></div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Image</label>
								<div class="col-sm-8">
									<input type="file" name="image">
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('account/listings') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Create</button>
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
		$('#listing-content').summernote({
			height: 300
		});

		$('#package-chooser').change(function(){
			$('#package-info .alert').remove();
			$('#package-info').append('<p class="alert alert-info" style="padding: 10px; margin-top: 10px;">'+$('#package-chooser :selected').data('notes') + '</p>');
		});

		if ($('#package-chooser :selected').text() != '-- SELECT PACKAGE --') {
			$('#package-info').append('<p class="alert alert-info" style="padding: 10px; margin-top: 10px;">'+$('#package-chooser :selected').data('notes') + '</p>');
		}

		$('input[name="show_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
	});
	</script>
@endsection