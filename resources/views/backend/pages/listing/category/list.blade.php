@extends('backend.base')

@section('title', 'Listings')

@section('content')
	<ol class="breadcrumb">
	    <li class="">Listing Categories</li>
	</ol>
	<div class="container-fluid">
		@if (Auth::user()->get()->can('can_create_category'))
			<!-- Action menu -->
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
				<div class="action-menu col-md-12">
					<a class="btn btn-primary" href="{{ url('app-admin/listings/categories/create') }}" role="button"><i class="ti ti-plus"></i> Add new Category</a>
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
							<h2>Listing Categories list</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body">
							<table id="categories-list" class="table table-striped table table-hover">
								<thead>
									<tr>
										<th width="50">#ID</th>
										<th>Title</th>
										<th>Jumlah Sub Category</th>
										<th>Jumlah Listing</th>
										<th>Created</th>
										<th>Updated</th>
										<th width="150">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$categories = App\Models\ListingCategory::where('parent', 0)->get();
									?>
									@foreach ($categories as $category)
										<?php
										$assets = json_decode($category->assets);
										?>
										<tr>
											<td class="text-center">{{ $category->id }}</td>
											<td>
												<a href="{{ url('app-admin/listings/categories/edit', $category->id) }}">{{ $category->title }}</a>

												<?php $countListings = 0 ?>
												@if (count($category->children) > 0)
													<ul>
														@foreach ($category->children as $children)
															<li><a href="{{ url('app-admin/listings/categories/edit', $children->id) }}">{{ $children->title }}</a></li>
															<?php $countListings = $countListings + $children->listingsCount->count() ?>
														@endforeach
													</ul>
												@endif
											</td>
											<td class="text-center">{{ $category->children->count() }}</td>
											<td class="text-center">{{ $countListings }}</td>
											<td>{{ date('d M Y H:i', strtotime($category->created_at)) }}</td>
											<td>{{ date('d M Y H:i', strtotime($category->updated_at)) }}</td>
											<td>
												<a href="{{ url('app-admin/listings/categories/edit', $category->id) }}" class="btn btn-primary-alt btn tooltips" title="Edit this category"><i class="ti ti-pencil"></i></a>&nbsp;&nbsp;
												<!-- <a href="{{ url('app-admin/listings/categories/delete', $category->id) }}" class="btn btn-danger-alt btn tooltips" title="Delete this category"><i class="ti ti-trash"></i></a> -->
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./End Listings Table -->
	</div>
@endsection

@section('page-styles')
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.themify.css') }}" rel="stylesheet">
@endsection

@section('page-scripts')
	<!-- Load page level scripts-->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.js') }}"></script>
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#listings-list').dataTable({
	    	"language": {
	    		"lengthMenu": "_MENU_"
	    	}
	    });

	    $('.dataTables_filter input').attr('placeholder','Search...');


	    //DOM Manipulation to move datatable elements integrate to panel
		$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
		$('.panel-ctrls').append("<i class='separator'></i>");
		$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

		$('.panel-footer').append($(".dataTable+.row"));
		$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
	});
	</script>
@endsection

@section('inline-style')
<style type="text/css">
	#categories-list tr td {
		vertical-align: middle;
	}
</style>
@stop