<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - <?php echo Setting::get('site_settings.title') != '' ? Setting::get('site_settings.title') : 'MyListing' ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    </script>
    <link type='text/css' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600' rel='stylesheet'>
</head>
<body class="animated-content">
    <div id="wrapper">
        <div id="layout-static">
            <div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <h3 class="page-title">Billings</h3>
	
		<div class="row">
			<div class="col-md-12">

				<div class="panel panel-transparent">
		            <div class="panel-body">
		            	<!--
		                <div class="clearfix">
		                    <div class="pull-left">
		                        <img src="assets/img/logo-big.png" class="mt-md mb-md" alt="Avenxo">
		                        <address class="mt-md mb-md">
		                            <strong>Avenxo, Inc.</strong><br>
		                            705 Folsom Ave, Suite 400<br>
		                            San Francisco, CA 94107<br>
		                        </address>
		                    </div>
		                    <div class="pull-right">
		                        <h1 class="text-primary text-right" style="font-weight: normal;">
		                            INVOICE
		                            <small style="display: block;">#10007819</small>
		                        </h1>
		                    </div>
		                </div>
		                <hr>
		                -->
		                <div class="row mb-xl">
		                    <!-- <div class="col-md-12">
		                        <h1 class="text-primary text-center" style="font-weight: normal;">INVOICE</h1>
		                    </div> -->
		                    <div class="col-md-12">
		                        <div class="pull-left">
		                            <h3 class="text-muted">To</h3>
		                            <address>
		                                <strong>{{ $billing->customer ? $billing->customer->customer_name : $billing->item->address->company }}</strong><br>
		                                <?php $address = $billing->customer ? $billing->customer->address : $billing->item->address; ?>
		                                <?php echo $address->address_1 . '<br>'; ?>
		                                <?php echo $address->address_2 != '' ? $address->address_1 . '<br>' : null; ?>
		                                {{ $address->city }}, {{ App\Models\Zone::find($address->zone_id)->name }}. {{ $address->postcode }}<br>
		                                {{ App\Models\Country::find($address->country_id)->name }}
		                            </address>
		                        </div>
		                        <div class="pull-right">
		                            <h3 class="text-muted">Info</h3>
		                            <ul class="text-left list-unstyled">
		                                <li><strong>Date:</strong> {{ date('d/M/Y', strtotime($billing->created_at)) }}</li>
		                            </ul>
		                        </div>
		                    </div>
		                </div>
		                <div class="row mb-xl">
		                    <div class="col-md-12">
		                        <div class="panel">
		                            <div class="panel-body no-padding">
		                                <div class="table-responsive">
		                                    <table class="table table-hover m-n">
		                                        <thead>
		                                            <tr>
		                                                <th width="200">{{ ucfirst($billing->item_type) }} ID</th>
		                                                <th>Description</th>
		                                                <th>Item Type</th>
		                                                <th>Qty</th>
		                                                <th>Unit Cost</th>
		                                                <th>Discount</th>
		                                                <th class="text-right">Total</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>
		                                            <tr>
		                                            	<?php if ($billing->item_type == 'ads'): ?>
		                                                	<td><?php echo $billing->item->ad_id ?></td>
		                                                <?php else: ?>
		                                                	<td><?php echo $billing->item->listing_id ?></td>
		                                            	<?php endif ?>

		                                                <?php if ($billing->item_type == 'ads'): ?>
	                                                		<td><?php echo $billing->customer ? Setting::get('ads.price_notes') : Setting::get('ads.noncust.price_notes') ?></td>
	                                                	<?php else: ?>
		                                                	<td><?php echo $billing->item->package->name ?></td>
		                                                <?php endif ?>

		                                                <td><?php echo $billing->item_type ?></td>
		                                                <td>1</td>
		                                                <?php if ($billing->item_type == 'ads'): ?>	
		                                                	<?php
		                                                	$price = $billing->customer ? floatval(Setting::get('ads.price_per_day')) : floatval(Setting::get('ads.noncust.price_per_day'));
		                                                	$price_total = $price * intval($billing->item->days);
		                                                	?>

		                                                	<td>Rp {{ number_format($price_total, 0, '.',',') }}</td>
		                                                	<td>{{ $billing->customer ? Setting::get('ads.price_discount') : Setting::get('ads.noncust.price_discount') }}%</td>
	                                                	<?php else: ?>
			                                                <td>Rp {{ number_format($billing->item->package->price, 0, '.',',') }}</td>
			                                                <td>{{ $billing->item->package->discount }}%</td>
		                                                <?php endif ?>
	                                                	<td class="text-right">Rp <?php echo number_format($billing->amount, 0, '.', ',') ?></td>
		                                            </tr>
		                                        </tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="col-md-12">
		                        <div class="row" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
		                            <div class="col-md-3 col-md-offset-9">
		                            	<?php $price_disc = $billing->customer ? Setting::get('ads.price_discount') : Setting::get('ads.noncust.price_discount') ?>
		                            	<?php if ($billing->item_type == 'ads'): ?>
			                                <p class="text-right"><strong>SUB TOTAL: Rp {{ number_format($price_disc * $billing->item->days, 0, '.',',') }}</strong></p>
			                                <p class="text-right">DISCOUNT: {{ $price_disc }}%</p>
		                                <?php else: ?>
			                                <p class="text-right"><strong>SUB TOTAL: Rp {{ number_format($billing->item->package->price, 0, '.',',') }}</strong></p>
			                                <p class="text-right">DISCOUNT: {{ $billing->item->package->discount }}%</p>
		                            	<?php endif ?>
		                                <p class="text-right">VAT: 0%</p>
		                                <hr>
		                                <h3 class="text-right text-danger" style="font-weight: bold;">IDR <?php echo number_format($billing->amount, 0, ',', '.') ?></h3>
		                            </div>
		                        </div>
		                    </div>
		                </div>


		                    
	                    @if ($billing->bukti_pembayaran != '' || $billing->confirm_message != '')
		                	<div class="row">
			                	<div class="col-md-12">
			                		<div class="well">
			                			<div class="form-group">
				                			<label for="">Confirm Message</label>
											<p>{{ $billing->confirm_message }}
				                		</div>
				                		
				                		<div class="form-group">
				                			<label>Bukti Pembayaran</label>
				                			@if ($billing->bukti_pembayaran != '')
				                				<img src="{{ asset($billing->bukti_pembayaran) }}" class="img-responsive" alt="">
				                			@endif
				                		</div>
			                		</div>
			                	</div>
			                </div>
	                    @endif
		                    
		                <div class="row">
		                    <div class="col-md-12">
		                        <div class="pull-right">
		                            <a href="javascript:window.print()" class="btn btn-inverse"><i class="ti ti-printer"></i></a>
		                            @if ($billing->status == 0)
		                            <a href="<?php echo url('app-admin/billings/' . $billing->item_type . '/' . $billing->id . '/confirm') ?>" class="btn btn-primary">Confirm Payment</a>
		                            @else
		                            <a href="<?php echo url('app-admin/billings/' . $billing->item_type . '/' . $billing->id . '/unconfirm') ?>" class="btn btn-warning">Cancel Confirm Payment</a>
		                            @endif
		                        </div>
		                    </div>
		                </div>

		            </div>

		        </div>
			</div>
		</div>
	</div>
                        
                        <footer role="contentinfo">
                            <div class="clearfix">
                                <ul class="list-unstyled list-inline pull-left">
                                    <li><h6 style="">&copy; 2015 MyListing. POWERED BY <a href="http://digirookstudio.com" target="_blank">DIGIROOK STUDIO</a></h6></li>
                                </ul>
                                <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>