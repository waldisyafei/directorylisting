@extends('backend.base')

@section('title', 'Edit Category')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('app-admin/listings/categories') }}">Listings Categories</a></li>
	    <li>Edit Category</li>
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

			<form method="post" action="{{ url('app-admin/listings/categories/edit', $category->id) }}" class="form-horizontal" id="form-category">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="col-md-12">
					<div class="panel panel-blue">
						<div class="panel-heading">
							<h2>Edit Category Form</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-8">
									<input type="text" name="title" value="{{ $category->title }}" class="form-control">
								</div>
							</div>
							<!-- <div class="form-group">
								<label class="col-sm-2 control-label">Is Main Category?</label>
								<div class="col-xs-8">
									<div class="radio">
										<label>
											<input type="radio" name="main_cat" class="is-main-cat" value="main"{!! $category->parent == 0 ? ' checked' : null !!}>
											Main Category
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="main_cat" class="is-main-cat" value="sub"{!! $category->parent > 0 ? ' checked' : null !!}>
											Sub Category
										</label>
									</div>
								</div>
							</div> -->
							<div class="form-group" id="select-main-cat">
								<label class="col-sm-2 control-label">Parent</label>
								<div class="col-sm-8">
									<select class="form-control" name="parent" autocomplete="off">
										<option value="choose-category"{{ $category->parent == null ? ' selected' : null }}>-- SELECT CATEGORY --</option>
										<?php
										$categories = \App\Models\ListingCategory::where('parent', 0)->get();
										?>
										@foreach ($categories as $cat)
											<option value="{{ $cat->id }}"{!! $category->parent == $cat->id ? ' selected' : null !!}>{{ $cat->title }}</option>
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
@endsection

@section('page-scripts')
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){

		var isMainVal = $('input[name="main_cat"]:checked', '#form-category').val();

		if (isMainVal === 'sub') {
			$('#select-main-cat').css('display', 'block');
		} else {
			$('#select-main-cat').css('display', 'none');
		}

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
</style>
@stop