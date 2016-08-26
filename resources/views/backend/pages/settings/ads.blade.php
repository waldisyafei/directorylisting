@extends('backend.base')

@section('title', 'Ads Settings')

@section('content')
	<ol class="breadcrumb">
		<li>Settings</li>
		<li>Ads Settings</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				@if (Session::has('success'))
					<div class="alert alert-success">
						{{ Session::get('success') }}
					</div>
				@endif
				@if ($errors->has())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="panel panel-blue">
					<form method="post" action="{{ url('app-admin/settings/ads') }}" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
							<h2>Ads Settings</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Max content length</label>
								<div class="col-sm-2">
									<input type="number" name="content_length" class="form-control" value="{{ Setting::get('ads.content_length') }}">
								</div>
							</div>
						</div>

						<!-- Panel Footer -->
						<div class="panel-footer">
							<div class="row">
								<div class="col-sm-8 col-sm-offset-2">
									<button class="btn-primary btn">Save</button>
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