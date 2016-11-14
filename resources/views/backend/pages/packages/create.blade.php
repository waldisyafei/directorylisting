@extends('backend.base')

@section('title', 'Create New Package')

@section('content')
	<h3 class="page-title">Create New Package</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin/packages') }}">Packages</a></li>
	    <li class="active"><span>Create New Package</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if ($errors->has())
					<div class="alert alert-dismissable alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="panel panel-blue">
					<div class="panel-heading">
						<h2>New Package Form</h2>
					</div>
					<form method="post" action="{{ url('app-admin/packages/create') }}" class="form-horizontal">
						{!! csrf_field() !!}
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Package Name</label>
								<div class="col-sm-8">
									<input type="text" name="name" class="form-control" placeholder="Package Name" value="{{ old('name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Price</label>
								<div class="col-sm-8">
									<input type="text" name="price" class="form-control" placeholder="Packag Price ex(10000)" value="{{ old('notes') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Notes</label>
								<div class="col-sm-8">
									<textarea class="form-control" rows="5" name="notes">{!! old('notes') !!}</textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Active Days</label>
								<div class="col-sm-2" style="padding-right: 0;">
									<input name="days" type="number" min="1" step="1" class="form-control" value="1">
								</div>
								<label class="col-sm-2 control-label" style="text-align: left;"> Days</label>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Discount</label>
								<div class="col-sm-2" style="padding-right: 0;">
									<input name="discount" type="number" min="0" max="100" step="1" class="form-control" value="{{ old('discount') !== '' ? old('discount') : '0' }}">
								</div>
								<label class="col-sm-2 control-label" style="text-align: left;"> %</label>
							</div>
						</div>

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('app-admin/packages') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
									<button class="btn-primary btn">Create</button>
								</div>
							</div>
						</div>
						<!-- ./End Panel Footer -->
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection