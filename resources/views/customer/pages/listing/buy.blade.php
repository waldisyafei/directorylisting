@extends('customer.base')

@section('title', 'Buy Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('account/listings') }}">My Listings</a></li>
	    <li>Buy</li>
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
						<h2>Buy Listing Slot</h2>
					</div>
					<div class="panel-body">
						<p>You are select buy new Listing, please follow the steps to finish</p>
						<form action="{{ url('account/listings/buy') }}" method="post" id="buy-listing-wizard" class="form-horizontal">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<fieldset title="Step 1">
								<legend>How Long Listings to show</legend>
								<?php
								$packages = App\Models\Package::all();
								?>
								<div class="listing-entry first">
									<div class="form-group">
										<label for="fieldname" class="col-md-3 control-label">Select Package</label>
										<div class="col-md-6">
											<select class="select-package form-control" name="listings[0][package_id]" required>
												<option selected disabled>--- SELECT PACKAGE ---</option>
												@forelse ($packages as $package)
													<option value="{{ $package->id }}" data-info="{{ $package->notes }}" data-price="{{ $package->price }}" data-days="{{ $package->days }}" data-discount="{{ $package->discount }}">{{ $package->name }}</option>
												@empty
													{{-- empty expr --}}
												@endforelse
											</select>
										</div>
									</div>
									<p class="listing-package-info"></p>
									<!-- <button type="button" class="add-listing-entry btn tooltips" title="Add New Listing Slot"><i class="fa fa-plus"></i></button> -->
									<button type="button" class="remove-listing-entry btn tooltips" title="Remove Slot"><i class="fa fa-close"></i></button>
								</div>
							</fieldset>
							<!--<fieldset title="Step 2">
								<legend>Info Order</legend>-->

								<div class="info-order-list clearfix">
									<div class="col-md-6">
										
									</div>
								</div>
							<!--</fieldset>-->
							<input type="submit" style="float: right;" class="finish btn-success btn" value="Submit" />
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
			$(document).on('ready', function(){
					var infoOrders = '';
					var totalHarga = 0;

					$('.select-package').each(function(k, v){
						var selectedPackage = $(this).find(':selected');
						var discount = parseInt(selectedPackage.data('discount'));
						var harga = parseFloat(selectedPackage.data('price'));
						var potonganHarga = discount / 100 * harga;
						var hargaDikurangDiscount = harga - potonganHarga;

						if ($(this).val() !== '') {
							infoOrders += '<div class="panels row">';
							infoOrders += '<div class="col-md-6 text-left">';
							infoOrders += '<span style="padding-right:5em;">Listing Slot '+ (k + 1) + '</span>' ;
							infoOrders += '<strong style="color: #000;">Rp '+hargaDikurangDiscount.format()+'</strong></div>' ;
							
							infoOrders += '</div></div>';
							totalHarga = totalHarga + hargaDikurangDiscount;
						}
					});

					$('.info-price-list .panels').remove();

					$('.info-price-list').append(infoOrders);

		$('body').on('change', '.select-package', function(){
			$('.info-price-list .col-md-6 .panel').remove();
					var infoOrders = '';
					var totalHarga = 0;

					$('.select-package').each(function(k, v){
						var selectedPackage = $(this).find(':selected');
						var discount = parseInt(selectedPackage.data('discount'));
						var harga = parseFloat(selectedPackage.data('price'));
						var potonganHarga = discount / 100 * harga;
						var hargaDikurangDiscount = harga - potonganHarga;

						if ($(this).val() !== '') {
							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Listing Slot '+ (k + 1) + '</h2></div>';
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
					//jQuery('html, body').animate({
			        //	scrollTop: 0
			    	//}, 1000);
				});
			});
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

			if (selectVal !== '') {
				$(this).closest('.listing-entry').find('.listing-package-info').html(selectedOpt.data('info'));
			}
			$(this).parents('.form-group').next('.listing-package-info').addClass('active');
		});

		$('body').on('click', '.add-listing-entry', function(){
			var parent = $(this).parent();

			parent.find('.tooltip').remove();

			var cloned = parent.clone();

			$(this).css('display', 'none');

			cloned.find('.listing-package-info').text('').removeClass('active');
			cloned.find('.remove-listing-entry').css('display', 'block');
			parent.after(cloned);

			renameFieldEntry();
		});

		$('body').on('click', '.remove-listing-entry', function(){
			var prevEntry = $(this).parent().prev();
			var nextEntry = $(this).parent().next();
			$(this).parent().remove();

			// show the remove button and add button to the prev of parent
			// if any entry after
			if (nextEntry.hasClass('listing-entry') === false) {
				prevEntry.find('.add-listing-entry').css('display', 'block');
			}

			renameFieldEntry();
		});

		function renameFieldEntry() {
			var selectPackage = $('.select-package');

			for (var i = 0; i < selectPackage.length; i++) {
				selectPackage.eq(i).attr('name', 'listings[' + i + '][package_id]');
			}
		}
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