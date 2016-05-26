@extends('backend.base')

@section('title', 'Site Settings')

@section('content')
	<ol class="breadcrumb">
		<li>Settings</li>
		<li>Site Settings</li>
	</ol>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-blue">
					<form method="post" action="{{ url('app-admin/settings/site') }}" class="form-horizontal" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-heading">
							<h2>Site Settings</h2>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Site Title</label>
								<div class="col-sm-8">
									<input type="text" name="site_title" value="{{ Setting::get('site_settings.title') }}" class="form-control" placeholder="Site Title">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Default Logo</label>
								<div class="col-sm-8">
									<input type="file" name="default_logo" class="form-control" accept="image/*">

									<br>
									<?php if (Setting::get('site_settings.default_logo')): ?>
										<div class="logo">
											<img src="<?php echo url(Setting::get('site_settings.default_logo')) ?>">
										</div>
									<?php endif ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Enable Sessional Logo</label>
								<div class="col-sm-8">
									<ul class="demo-btns mb-n">
										<input class="bootstrap-switch" type="checkbox" id="enable-sessional-logo" name="enable_sessional_logo" data-size="normal" data-on-color="success" data-off-color="default" data-radio-all-off="true"<?php echo Setting::get('site_settings.enable_sessional_logo') == 'on' ? ' checked="true"' : null ?>>
									</ul>
								</div>
							</div>

							<div class="sessional-logo-wrap">
								<div class="form-group">
									<label class="col-sm-2 control-label">Sessional Logo</label>
									<div class="col-sm-8">
										<input type="file" name="sessional_logo" class="form-control" accept="image/*">

										<br>
										<?php if (Setting::get('site_settings.sessional_logo')): ?>
											<div class="logo">
												<img src="<?php echo url(Setting::get('site_settings.sessional_logo')) ?>">
											</div>
										<?php endif ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Start Show Date</label>
									<div class="col-sm-8">
										<input type="text" name="show_date" value="{{ Setting::get('site_settings.sessional_show') }}" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">End Show Date</label>
									<div class="col-sm-8">
										<input type="text" name="end_date" value="{{ Setting::get('site_settings.sessional_end') }}" class="form-control">
									</div>
								</div>

								<br><br><br>
								<div class="form-group">
									<label class="col-sm-2 control-label">Header Annoucement</label>
									<div class="col-sm-8">
										<textarea name="announcement" rows="4" class="form-control">{{ Setting::get('site_settings.announcement') }}</textarea>
									</div>
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

@section('page-scripts')
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
@stop

@section('inline-script')
<script type="text/javascript">
	$(function(){

		if ($('#enable-sessional-logo').bootstrapSwitch('state') === false) {
			$('.sessional-logo-wrap').hide(0);
		}
		$('#enable-sessional-logo').on('switchChange.bootstrapSwitch', function(event, state) {
			if (state === true) {
				$('.sessional-logo-wrap').stop(true, true).slideDown(300);
			} else {
				$('.sessional-logo-wrap').stop(true, true).slideUp(300);
			}
		});

		$('input[name="show_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
		$('input[name="end_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
	});
</script>
@stop