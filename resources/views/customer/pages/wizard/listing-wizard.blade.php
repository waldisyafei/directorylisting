@extends('customer.base')

@section('title', 'My Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class="">Listing Wizard</li>
	</ol>
	<div class="container-fluid">
		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>Buy / Renews Listing</h2>
							<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body"}'></div>
						</div>
						<div class="panel-body">
							<div class="btn-wrapper">
								<div class="col-md-2 text-center">
									<button type="button" id="btn-buy" class="btn btn-success btn-block">BUY</button>
								</div>
								<div class="col-md-2 text-center">
									<button type="button" id="btn-new" class="btn btn-info btn-block">RENEW</button>
								</div>
							</div>

							<div class="buy-listing">
								<p>You are select buy new Listing, please follow the steps to finish</p>
								<form action="#" id="wizard" class="form-horizontal">
									<fieldset title="Step 1">
										<legend>Please Select Main Category</legend>
										<div class="form-group">
											<label for="fieldname" class="col-md-3 control-label">Select Main Category</label>
											<div class="col-md-6">
												<?php
												$categories = App\Models\ListingCategory::where('parent', 0)->get();
												?>
												<select class="form-control" name="main_category" required>
													<option selected disabled>--- SELECT MAIN CATEGORY ---</option>
													@forelse ($categories as $category)
														<option value="{{ $category->id }}">{{ $category->title }}</option>
													@empty
														{{-- empty expr --}}
													@endforelse
												</select>
											</div>
										</div>
									</fieldset>
									<fieldset title="Step 2">
										<legend>Fill Listing Content</legend>
										<div class="form-group">
											<label class="col-sm-2 control-label">Title</label>
											<div class="col-sm-8">
												<input type="text" name="title" value="{{ old('title') }}" class="form-control" required="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Content</label>
											<div class="col-sm-8">
												<textarea id="listing-content" name="content" rows="10">{{ old('content') }}</textarea>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Image</label>
											<div class="col-sm-8">
												<input type="file" name="image" required>
											</div>
										</div>
									</fieldset>
									<fieldset title="Step 3">
										<legend>Preview</legend>
										<div class="form-group">
											<label for="" class="col-md-3 control-label">Terms and Conditions</label>
											<div class="col-md-9">
												<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, nemo, atque consequuntur officiis asperiores consectetur porro labore commodi esse error quisquam nihil illum sunt facere inventore possimus autem ab voluptates quibusdam non voluptatum suscipit architecto. Illo, facilis, corporis, veritatis dolores minus quasi iure cupiditate quis autem ducimus nisi obcaecati tenetur sed ea excepturi pariatur consequatur enim labore officia mollitia. Rerum, voluptatem numquam molestiae recusandae iusto ipsum inventore unde accusantium labore delectus? Doloremque, fugit, sunt libero laboriosam cupiditate sed sequi nostrum saepe. Mollitia, alias, expedita accusantium porro error autem dolore veniam commodi nesciunt provident vitae neque. Nostrum, sed, molestias itaque provident inventore natus animi quasi laborum laboriosam facere ratione aperiam iusto. Non ducimus facere sunt doloribus? Asperiores, natus distinctio quis iure!</p>
											</div>
										</div>
									</fieldset>
									<input type="submit" class="finish btn-success btn" value="Submit" />
								</form>
							</div>

							<div class="renew-listing">
								<p>Select the option, Buy or Renew Listing. And follow the steps.</p>
								<form action="#" id="wizard-renew" class="form-horizontal">
									<fieldset title="Step 2">
										<legend>Personal Data</legend>
										<div class="form-group">
											<label for="fieldnick" class="col-md-3 control-label">Nick</label>
											<div class="col-md-6"><input id="fieldnick" class="form-control" name="name" minlength="4" type="text" required></div>
										</div>
										<div class="form-group">
											<label for="fieldabout" class="col-md-3 control-label">About</label>
											<div class="col-md-6"><textarea id="fieldabout" class="form-control autosize" rows="2"></textarea></div>
										</div>
									</fieldset>
									<fieldset title="Step 3">
										<legend>Preview</legend>
										<div class="form-group">
											<label for="" class="col-md-3 control-label">Terms and Conditions</label>
											<div class="col-md-9">
												<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, nemo, atque consequuntur officiis asperiores consectetur porro labore commodi esse error quisquam nihil illum sunt facere inventore possimus autem ab voluptates quibusdam non voluptatum suscipit architecto. Illo, facilis, corporis, veritatis dolores minus quasi iure cupiditate quis autem ducimus nisi obcaecati tenetur sed ea excepturi pariatur consequatur enim labore officia mollitia. Rerum, voluptatem numquam molestiae recusandae iusto ipsum inventore unde accusantium labore delectus? Doloremque, fugit, sunt libero laboriosam cupiditate sed sequi nostrum saepe. Mollitia, alias, expedita accusantium porro error autem dolore veniam commodi nesciunt provident vitae neque. Nostrum, sed, molestias itaque provident inventore natus animi quasi laborum laboriosam facere ratione aperiam iusto. Non ducimus facere sunt doloribus? Asperiores, natus distinctio quis iure!</p>
											</div>
										</div>
									</fieldset>
									<input type="submit" class="finish btn-success btn" value="Submit" />
								</form>
							</div>
						</div>
					</div>
			    </div>
			</div>
		</div>
	</div>
@endsection

@section('page-styles')
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('assets/backend/plugins/datatables/dataTables.themify.css') }}" rel="stylesheet">
	<!-- Summernote -->
	<link type="text/css" href="{{ asset('assets/backend/plugins/summernote/dist/summernote.css') }}" rel="stylesheet">
@endsection

@section('page-scripts')
	<!-- Load page level scripts-->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <!-- Validate Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-validation/jquery.validate.min.js') }}"></script>
	<!-- Stepy Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-stepy/jquery.stepy.js') }}"></script>

	<script type="text/javascript" src="{{ asset('assets/backend/plugins/summernote/dist/summernote.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#btn-buy').click(function(){
			$('.buy-listing').slideDown(100);
			$('.btn-wrapper').slideUp(100);
			$('.panel-heading h2').text('Buy Listing');
			$('.panel').removeClass('panel-info').addClass('panel-success');

			$('#wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

		    //Add Wizard Compability - see docs
		    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

		    //Make Validation Compability - see docs
		    $('#wizard').validate({
		        errorClass: "help-block",
		        validClass: "help-block",
		        highlight: function(element, errorClass,validClass) {
		           $(element).closest('.form-group').addClass("has-error");
		        },
		        unhighlight: function(element, errorClass,validClass) {
		            $(element).closest('.form-group').removeClass("has-error");
		        }
		    });

		    $('#listing-content').summernote({
				height: 300
			});

			$('#package-chooser').change(function(){
				$('#package-info .alert').remove();
				$('#package-info').append('<p class="alert alert-info" style="padding: 10px; margin-top: 10px;">'+$('#package-chooser :selected').data('notes') + '</p>');
			});

			if ($('#package-chooser :selected').text() != '-- SELECT PACKAGE --') {
				$('#package-info').append('<p class="alert alert-info" style="padding: 10px; margin-top: 10px;">'+$('#package-chooser :selected').data('notes') + '</p>');
			}

			$('input[name="show_date"]').datetimepicker({format: 'yyyy-mm-dd hh:ii'});
		});
	});

		
	</script>
@endsection

@section('inline-style')
<style type="text/css">
	.buy-listing {
		display: none;
	}
	.renew-listing {
		display: none;
	}
</style>
@stop