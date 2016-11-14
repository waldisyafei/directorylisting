@extends('customer.base')

@section('title', 'Renew Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('account/listings') }}">My Listings</a></li>
	    <li>BUy</li>
	</ol>
	<div class="container-fluid">
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
			<div class="col-md-12">
				<div class="panel panel-blue">
					<div class="panel-heading">
						<h2>Renew Listing</h2>
					</div>
					<div class="panel-body">
						<p>You are select buy Renew Listing, please follow the steps to finish</p>
						<form action="{{ url('account/listings/renew') }}" method="post" id="buy-listing-wizard" class="form-horizontal">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<fieldset title="Step 1">
								<?php
								$packages = App\Models\Package::all();
								?>
								<legend>Please Select a Package</legend>
								<?php
						        $customerListings = getCustomerListings(array(
						            array(
						                'key' => 'customer_id',
						                'comparasion' => '=',
						                'value' => Auth::customer()->get()->customer_id
						            )
						        ), 'DESC', 10);
								?>

								@foreach ($customerListings as $key => $listing)
									<div class="listing-entry{{ $key == 0 ? ' first' : null }}">
										<div class="form-group">
											<label class="col-md-3 control-label">Listing ID</label>
											<label class="col-md-6 control-label" style="text-align: left;"><strong>{{ $listing->listing_id }}</strong></label>
										</div>
										<div class="form-group">
											<label for="fieldname" class="col-md-3 control-label">Select Package</label>
											<div class="col-md-6">
												<select class="select-package form-control" name="listings[{{ $listing->listing_id }}][package_id]" required>
													<option selected>--- SELECT PACKAGE ---</option>
													@forelse ($packages as $package)
														<option value="{{ $package->id }}" data-info="{{ $package->notes }}" data-price="{{ $package->price }}" data-days="{{ $package->days }}" data-discount="{{ $package->discount }}">{{ $package->name }}</option>
													@empty
														{{-- empty expr --}}
													@endforelse
												</select>
											</div>
										</div>
										<p class="listing-package-info"></p>
									</div>
								@endforeach
							</fieldset>
							<fieldset title="Step 2">
								<legend>Info Order</legend>

								<div class="info-order-list clearfix">
									<div class="col-md-6">
										
									</div>
								</div>
							</fieldset>
							<input type="submit" class="finish btn-success btn" value="Submit" />
						</form>
					</div>
					<!-- ./End panel body -->
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page-styles')
@endsection

@section('page-scripts')
    <!-- Validate Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-validation/jquery.validate.min.js') }}"></script>
	<!-- Stepy Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/form-stepy/jquery.stepy.js') }}"></script>
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		$('#buy-listing-wizard').stepy(
			{finishButton: true,
				titleClick: true,
				block: true,
				validate: true,
				next: function(){
					var infoOrders = '';
					var totalHarga = 0;

					$('.select-package').each(function(k, v){
						var selectedPackage = $(this).find(':selected');
						var discount = parseInt(selectedPackage.data('discount'));
						var harga = parseFloat(selectedPackage.data('price'));
						var potonganHarga = discount / 100 * harga;
						var hargaDikurangDiscount = harga - potonganHarga;
						var listing_id = $(this).closest('.listing-entry').find('.form-group:first-child label:last-child').text();

						if (selectedPackage.val() !== '--- SELECT PACKAGE ---') {
							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Listing '+ listing_id + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Package Name</td><td>'+selectedPackage.text()+' Hari</td>';
							infoOrders += '<tr><td width="100">Hari Tayang</td><td>'+selectedPackage.data('days')+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+selectedPackage.data('info')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+selectedPackage.data('discount')+'%</td>';
							infoOrders += '</table>';
							infoOrders += '</div></div>';
							totalHarga = totalHarga + hargaDikurangDiscount;
						}
					});

					$('.info-order-list .col-md-6 .panel').remove();

					$('.info-order-list .col-md-6').append(infoOrders);

					if ($('.alert').length > 0) {
						$('.alert .col-md-2 strong').html('Rp ' + totalHarga.format());
					} else {
						$('.info-order-list').after('<div class="alert alert-inverse clearfix"><div class="col-md-10 text-right"><strong style="color: #000;">Total Harga:</strong></div><div class="col-md-2 text-right"><strong style="color: #000;">Rp '+totalHarga.format()+'</strong></div></div>');
					}
				}
			});

	    //Add Wizard Compability - see docs
	    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

	    //Make Validation Compability - see docs
	    $('#buy-listing-wizard').validate({
	        errorClass: "help-block",
	        validClass: "help-block",
	        highlight: function(element, errorClass,validClass) {
	           $(element).closest('.form-group').addClass("has-error");
	        },
	        unhighlight: function(element, errorClass,validClass) {
	            $(element).closest('.form-group').removeClass("has-error");
	        }
	    });

	    $('body').on('change', '.select-package', function(){
			var selectedOpt = $(this).find(':selected');
			var selectVal = selectedOpt.val();

			if (selectVal !== '--- SELECT PACKAGE ---') {
				$(this).closest('.listing-entry').find('.listing-package-info').html(selectedOpt.data('info'));

				$(this).closest('.listing-entry').css({
					'border-color': '#AADA95',
					'background': '#CEF2BE'
				});
			} else {
				$(this).closest('.listing-entry').removeAttribute('style');
			}
			$(this).parents('.form-group').next('.listing-package-info').addClass('active');
		});
	});
	/**
	 * Number.prototype.format(n, x)
	 * 
	 * @param integer n: length of decimal
	 * @param integer x: length of sections
	 */
	Number.prototype.format = function(n, x) {
	    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
	};
	</script>
@endsection

@section('inline-style')
</style>
@stop