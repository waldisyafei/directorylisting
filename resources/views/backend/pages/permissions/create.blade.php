@extends('backend.base')

@section('title', 'Add new Permission')

@section('content')
	<ol class="breadcrumb">
		<li><a href="<?php echo url('app-admin') ?>">Dashboard</a></li>
		<li><a href="<?php echo url('app-admin/permissions') ?>">Permissions</a></li>
		<li class="active">Create New Permission</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@include('backend.partials.errors')

				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>New Permission Form</h2>
					</div>
					<form method="post" action="<?php echo url('app-admin/permissions/create') ?>" class="form-horizontal">
						{!! csrf_field() !!}
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Permission Name</label>
								<div class="col-sm-8">
									<input type="text" name="display_name" value="<?php echo old('display_name') ?>" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="description"><?php echo old('description') ?></textarea>
								</div>
							</div>
						</div>

						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<button type="submit" class="btn btn-primary">Create</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop