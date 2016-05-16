@extends('backend.base')

@section('title', 'Create New Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('app-admin/listings/categories') }}">Listings Categories</a></li>
	    <li>Create New Category</li>
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

			<form method="post" id="form-category" action="{{ url('app-admin/listings/categories/create') }}" class="form-horizontal">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-12">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<h2>New Category Form</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" value="{{ old('title') }}" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Is Main Category?</label>
								<div class="col-xs-8">
									<div class="radio">
										<label>
											<input type="radio" name="main_cat" class="is-main-cat" value="main" checked="checked">
											Main Category
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="main_cat" class="is-main-cat" value="sub">
											Sub Category
										</label>
									</div>
								</div>
							</div>
							<div class="form-group" id="select-main-cat">
								<label class="col-sm-2 control-label">Main Category</label>
								<div class="col-sm-8">
									<select class="form-control" name="parent">
										<option value="choose-category">-- SELECT MAIN CATEGORY --</option>
										<?php
										$categories = \App\Models\ListingCategory::all();
										?>
										@foreach ($categories as $category)
											@if ($category->parent == 0)
											<option value="{{ $category->id }}"{{ old('parent') == $category->id ? ' selected' : null }}>{{ $category->title }}</option>
											@endif
										@endforeach
									</select>
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
@endsection

@section('page-scripts')
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('.is-main-cat').click(function(){
			if ($(this).val() == 'sub') {
				$('#select-main-cat').css('display', 'block');
			} else {
				$('#select-main-cat').css('display', 'none');
			}
		});
	});
	</script>
@endsection

@section('inline-style')
<style type="text/css">
	#select-main-cat {
		display: none;
	}
</style>
@stop