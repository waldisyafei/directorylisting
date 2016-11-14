@extends('customer.base')

@section('title', 'Listing Categories')

@section('content')
	<ol class="breadcrumb">
		<li class="clearfix">Listing Categories</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="clearfix mb-lg">
					<a class="btn btn-primary" href="<?php echo url('account/listings/categories/create') ?>" role="button">Crate new Category</a>
				</div>
			</div>
		</div>
	</div>
@stop