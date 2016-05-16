@extends('backend.base')

@section('title', 'Permissions Management')

@section('content')
	<h1 class="page-heading">User Permissions Management</h1>

	<ol class="breadcrumb">
		<li><a href="<?php echo url('app-admin') ?>">Dashboard</a></li>
		<li class="active">Permissions Management</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@include('backend.partials.errors')

				<div class="clearfix mb-lg">
					<a class="btn btn-primary" href="<?php echo url('app-admin/permissions/create') ?>" role="button"><i class="ti ti-plus"></i>Add New Permission</a>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h2>Permissions List</h2>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="50">ID</th>
									<th>Name</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($permissions as $permission)
									<tr>
										<td><?php echo $permission->id ?></td>
										<td><?php echo $permission->display_name ?></td>
										<td>
											<a class="btn btn-primary btn-sm tooltips" href="<?php echo url('app-admin/permissions/edit', $permission->id) ?>" role="button" title="Edit this permission"><i class="ti ti-pencil-alt"></i></a>&nbsp;
											<a class="btn btn-danger btn-sm tooltips" href="<?php echo url('app-admin/permissions/delete', $permission->id) ?>" role="button" title="Delete this permission"><i class="ti ti-trash"></i></a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="panel-footer">
						<div class="col-sm-6 pull-right text-right">
							<?php echo $permissions->render() ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop