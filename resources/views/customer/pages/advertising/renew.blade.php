@extends('customer.base')

@section('title', 'Buy Ads')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('account/listings') }}">Buy Ads Slot</a></li>
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
						<h2>Buy Ads Slot</h2>
					</div>
					<div class="panel-body">
						<p>You are select buy new Ads, please follow the steps to finish</p>
						<form action="{{ url('account/ads/renew/{id}') }}" method="post" id="buy-ads-wizard" class="form-horizontal">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<fieldset title="Step 1">
								<legend>How Long Ads to show</legend>
								<?php if ($ad): ?>
									<?php //foreach ($ads as $ad): ?>
										<div class="listing-entry first">
											<div class="form-group">
												<label class="col-sm-2 control-label">Ads ID</label>
												<label class="col-sm-8 control-label" style="text-align: left;"><strong><?php echo $ad->ad_id ?></strong></label>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Show Days</label>
												<div class="col-sm-8">
													<div class="row">
														<div class="col-sm-2">
															<input type="number" min="0" max="365" name="ads[<?php echo $ad->id ?>][days]" data-price="{{ Setting::get('ads.price_per_day') }}" data-notes="{{ Setting::get('ads.price_notes') }}" data-discount="{{ Setting::get('ads.price_discount') }}" class="form-control days" value="{{ old('days') ? old('days') : '0' }}">
														</div>
														<div class="col-sm-3">
															<label class="control-label">Days</label>
														</div>
													</div>
												</div>
											</div>
											<p class="listing-package-info"></p>
										</div>
									<?php //endforeach ?>
								<?php endif ?>
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
		$(document).on('ready', function(){
					var infoOrders = '';
					var totalHarga = 0;

					$('.days').each(function(k, v){
						if ($(this).val() !== '0') {
							var discount = parseInt($(this).data('discount'));
							var harga = parseFloat($(this).data('price')) * parseInt($(this).val());
							var potonganHarga = discount / 100 * harga;
							var hargaDikurangDiscount = harga - potonganHarga;

							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Ads Slot '+ (k + 1) + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Tayang</td><td>'+$(this).val()+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+$(this).data('notes')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+$(this).data('discount')+'%</td>';
							infoOrders += '</table>';
							infoOrders += '</div></div>';
							totalHarga = totalHarga + hargaDikurangDiscount;
						}
					});

					$('.info-order-list .col-md-6 .panel').remove();

					$('.info-order-list .col-md-6').append(infoOrders);
		
		$('body').on('click', '.days', function(){
					$('.info-order-list .col-md-6 .panel').remove();
					var infoOrders = '';
					var totalHarga = 0;

					$('.days').each(function(k, v){
						if ($(this).val() !== '0') {
							var discount = parseInt($(this).data('discount'));
							var harga = parseFloat($(this).data('price')) * parseInt($(this).val());
							var potonganHarga = discount / 100 * harga;
							var hargaDikurangDiscount = harga - potonganHarga;

							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Ads Slot '+ (k + 1) + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Tayang</td><td>'+$(this).val()+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+$(this).data('notes')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+$(this).data('discount')+'%</td>';
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
				});
	});
		/*$('#buy-ads-wizard').stepy(
			{finishButton: true,
				titleClick: true,
				block: true,
				validate: true,
				next: function(){
					var infoOrders = '';
					var totalHarga = 0;

					$('.days').each(function(k, v){
						if ($(this).val() !== '0') {
							var discount = parseInt($(this).data('discount'));
							var harga = parseFloat($(this).data('price')) * parseInt($(this).val());
							var potonganHarga = discount / 100 * harga;
							var hargaDikurangDiscount = harga - potonganHarga;

							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Ads Slot '+ (k + 1) + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Tayang</td><td>'+$(this).val()+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+$(this).data('notes')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+$(this).data('discount')+'%</td>';
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
			});*/

	    //Add Wizard Compability - see docs
	    $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');

	    //Make Validation Compability - see docs
	    $('#buy-ads-wizard').validate({
	        errorClass: "help-block",
	        validClass: "help-block",
	        highlight: function(element, errorClass,validClass) {
	           $(element).closest('.form-group').addClass("has-error");
	        },
	        unhighlight: function(element, errorClass,validClass) {
	            $(element).closest('.form-group').removeClass("has-error");
	        }
	    });

	    $('body').on('change', '.days', function(){
			$(this).closest('.listing-entry').find('.listing-package-info').html($(this).data('notes'));
			$(this).parents('.form-group').next('.listing-package-info').addClass('active');
		});

		$('body').on('click', '.add-listing-entry', function(){
			var parent = $(this).parent();

			parent.find('.tooltip').remove();

			var cloned = parent.clone();

			$(this).css('display', 'none');

			cloned.find('.days').val('1');
			cloned.find('.listing-package-info').text('').removeClass('active');
			cloned.find('.remove-listing-entry').css('display', 'block');
			parent.after(cloned);

			renameFieldEntry();

					var infoOrders = '';
					var totalHarga = 0;

					$('.days').each(function(k, v){
						//if ($(this).val() !== '0') {
							var discount = parseInt($(this).data('discount'));
							var harga = parseFloat($(this).data('price')) * parseInt($(this).val());
							var potonganHarga = discount / 100 * harga;
							var hargaDikurangDiscount = harga - potonganHarga;

							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Ads Slot '+ (k + 1) + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Tayang</td><td>'+$(this).val()+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+$(this).data('notes')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+$(this).data('discount')+'%</td>';
							infoOrders += '</table>';
							infoOrders += '</div></div>';
							totalHarga = totalHarga + hargaDikurangDiscount;
						//}
					});

					$('.info-order-list .col-md-6 .panel').remove();

					$('.info-order-list .col-md-6').append(infoOrders);
		});

		$('body').on('click', '.remove-listing-entry', function(){
			var prevEntry = $(this).parent().prev();
			var nextEntry = $(this).parent().next();
			$(this).parent().remove();
			$(".panel-bluegraylight").remove();
			$(".alert-inverse").remove();
					var infoOrders = '';
					var totalHarga = 0;

					$('.days').each(function(k, v){
						if ($(this).val() !== '0') {
							var discount = parseInt($(this).data('discount'));
							var harga = parseFloat($(this).data('price')) * parseInt($(this).val());
							var potonganHarga = discount / 100 * harga;
							var hargaDikurangDiscount = harga - potonganHarga;

							infoOrders += '<div class="panel panel-bluegraylight"><div class="panel-heading"><h2>Ads Slot '+ (k + 1) + '</h2></div>';
							infoOrders += '<div class="panel-body"><table class="table table-stripped">';
							infoOrders += '<tr><td width="100">Tayang</td><td>'+$(this).val()+' Hari</td>';
							infoOrders += '<tr><td width="100">Catatan</td><td>'+$(this).data('notes')+'</td>';
							infoOrders += '<tr><td width="100">Harga</td><td>Rp '+ hargaDikurangDiscount.format() +'</td>';
							infoOrders += '<tr><td width="100">Discount</td><td>'+$(this).data('discount')+'%</td>';
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

			// show the remove button and add button to the prev of parent
			// if any entry after
			if (nextEntry.hasClass('listing-entry') === false) {
				prevEntry.find('.add-listing-entry').css('display', 'block');
			}

			renameFieldEntry();
		});

		function renameFieldEntry() {
			var days = $('.days');

			for (var i = 0; i < days.length; i++) {
				days.eq(i).attr('name', 'ads[' + i + '][days]');
			}
		}
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