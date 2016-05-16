@extends('backend.base')

@section('title', 'Create New Role')

@section('content')
	<h3 class="page-title">Create New Role</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <li><a href="{{ url('app-admin/roles') }}">Roles</a></li>
	    <li class="active"><span>Create New Role</span></li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if ($errors->has())
					<div class="alert alert-dismissable alert-danger">
						<i class="ti ti-close"></i>&nbsp; <strong>Oh snap!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					</div>
				@endif
				
				<div class="panel panel-blue" data-widget='{"draggable": "false"}'>
					<!-- Panel heading -->
					<div class="panel-heading">
						<h2>New Role Form</h2>
					</div>
					<!-- ./End panel heading -->

					<form class="form-horizontal row-border" method="post" action="{{ url('app-admin/roles/create') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<!-- Panel body -->
						<div class="panel-body" style="padding: 40px 16px;">
							<div class="form-group">
								<label for="rolename" class="col-sm-2 control-label">Role Name <small style="color: red;">*</small></label>
								<div class="col-sm-8">
									<input type="text" name="name" class="form-control" id="rolename" placeholder="Role Name" value="{{ old('name') }}">
								</div>
							</div>
							<div class="form-group">
								<label for="desc" class="col-sm-2 control-label">Description</label>
								<div class="col-sm-8">
									<textarea name="desc" class="form-control" id="desc">{{ old('desc') }}</textarea>
								</div>
							</div>

							<!-- Permissions -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Permissions</label>
								<div class="col-sm-8">
									<?php $perms = App\Models\Permission::all(); ?>
									<div class="row">
										@foreach ($perms as $perm)
											<div class="col-sm-4">
												<label class="checkbox icheck" style="-webkit-user-select: none;-moz-user-select: none;user-select: none;">
													<input type="checkbox" name="perms[]" id="<?php echo $perm->name; ?>">
													<?php echo $perm->display_name; ?>
												</label>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
						<!-- ./End panel body -->

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<a href="{{ url('app-admin/roles') }}" class="btn-default btn">Cancel</a>&nbsp;&nbsp;&nbsp;
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
@stop

@section('page-styles')
	<!-- Code Prettifier -->
    <link type="text/css" href="{{ asset('assets/backend/plugins/codeprettifier/prettify.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link type="text/css" href="{{ asset('assets/backend/plugins/iCheck/skins/minimal/blue.css') }}" rel="stylesheet">
@stop