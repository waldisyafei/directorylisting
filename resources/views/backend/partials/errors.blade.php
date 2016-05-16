@if (Session::has('success'))
	<div class="alert alert-dismissable alert-success">
		<i class="ti ti-check"></i>&nbsp; <strong>Well done!</strong> {{ Session::get('success') }}.
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>
@endif

@if (Session::has('error'))
	<div class="alert alert-dismissable alert-danger">
		<i class="ti ti-check"></i>&nbsp; <strong>Oh snap!</strong> {{ Session::get('error') }}.
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	</div>
@endif

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