@extends('backend.base')

@section('title', 'View Billing')

@section('content')
	<h3 class="page-title">Billings</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('app-admin') }}">Dashboard</a></li>
	    <?php if($billing->item_type == 'listing') $bill_url = 'listing'; else $bill_url = 'ads'; ?>
	    <li><a href="{{ url('app-admin/billings/'. $bill_url) }}">Billings</a></li>
	    <li class="active">View Billing</li>
	</ol>

	<div class="container-fluid">
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
		                                            	<?php if ($billing->item_type == 'ads'): ?>
		                                                	<td><?php echo $billing->item->days ?></td>
		                                                <?php else: ?>
		                                                	<td><?php echo $billing->item->package->days ?></td>
		                                            	<?php endif ?>
		                                            	<?php if ($billing->item_type == 'ads'): ?>	
		                                                	<?php
		                                                	$price = $billing->customer ? floatval(Setting::get('ads.price_per_day')) : floatval(Setting::get('ads.noncust.price_per_day'));
		                                                	$price_total = $price * intval($billing->item->days);
		                                                	?>

		                                                	<td>Rp {{ number_format($price, 0, '.',',') }}</td>
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
@endsection