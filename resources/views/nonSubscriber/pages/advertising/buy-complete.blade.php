@extends('nonSubscriber.base')

@section('title', 'Buy Ads Complete')

@section('content')
	<ol class="breadcrumb">
	    <li class="">Complete</li>
	</ol>
	<div class="container-fluid">

		<!-- Ads Table -->
		<div data-widget-group="group1">
			<div class="row">
				@if (Session::has('success'))
					<div class="col-md-12">
						<div class="alert alert-dismissable alert-success">
							<i class="ti ti-check"></i>&nbsp; <strong>Well Done!</strong> {{ Session::get('success') }}.
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					</div>
				@endif
				@if (Session::has('error'))
					<div class="col-md-12">
						<div class="alert alert-dismissable alert-danger">
							<i class="ti ti-close"></i>&nbsp; <strong>Access denied!</strong> {{ Session::get('error') }}.
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					</div>
				@endif
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Order Details</h2>
							<div class="panel-ctrls"></div>
						</div>
						<div class="panel-body">
							<div class="panel panel-transparent">
					            <div class="panel-body">
					                <div class="clearfix">
					                    <div class="pull-left">
					                        <img src="{{ asset('assets/backend/img/app-logo.png') }}" class="mt-md mb-md" alt="Avenxo">
					                        <address class="mt-md mb-md">
					                            <strong>MyListing, PT.</strong><br>
					                            Jl. Margonda Raya No. 834<br>
					                            Jawa Barat Indonesia, 16423<br>
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
					                <div class="row mb-xl">
					                    <!-- <div class="col-md-12">
					                        <h1 class="text-primary text-center" style="font-weight: normal;">INVOICE</h1>
					                    </div> -->
					                    <div class="col-md-12">
					                        <div class="pull-left">
					                            <h3 class="text-muted">To</h3>
					                            <address>
					                                <strong>{{ Auth::customer()->get()->customer_name }}</strong><br>
					                                <?php $address = Auth::customer()->get()->address; ?>
					                                <?php echo $address->address_1 . '<br>'; ?>
					                                <?php echo $address->address_2 != '' ? $address->address_1 . '<br>' : null; ?>
					                                {{ $address->city }}, {{ App\Models\Zone::find($address->zone_id)->name }}. {{ $address->postcode }}<br>
					                                {{ App\Models\Country::find($address->country_id)->name }}
					                            </address>
					                        </div>
					                        <div class="pull-right">
					                            <h3 class="text-muted">Info</h3>
					                            <ul class="text-left list-unstyled">
					                            	<?php $createdDate = date('d/m/Y'); ?>
					                                <li><strong>Date:</strong> {{ date('d/m/Y') }}</li>
					                                <li><strong>Due:</strong> {{ date('d/m/Y',  strtotime("+10 days")) }}</li>
					                                <li><strong>Late Fee:</strong> 0.5%</li>
					                            </ul>
					                        </div>
					                    </div>
					                </div>
					                <div class="row mb-xl">
					                    <div class="col-md-12">
					                        <div class="panel" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
					                            <div class="panel-body no-padding">
					                                <div class="table-responsive">
					                                    <table class="table table-hover m-n">
					                                        <thead>
					                                            <tr>
					                                                <th>#</th>
					                                                <th>Ads ID</th>
					                                                <th>Description</th>
					                                                <th class="text-right">Quantity</th>
					                                                <th class="text-right">Unit Cost</th>
					                                                <th class="text-right">Discount</th>
					                                                <th class="text-right">Total</th>
					                                            </tr>
					                                        </thead>
					                                        <tbody>
					                                        	<?php
					                                        	$totalPrice = 0.00;
					                                        	$subtotal = 0.00;
					                                        	$discSum = 0.00;
					                                        	$counter = 0;
					                                        	?>
					                                        	@foreach ($ads as $ad)
					                                        		<?php
					                                        		$disc = Setting::get('ads.price_discount');
					                                        		$harga = Setting::get('ads.price_per_day') * $ad->days;
					                                        		$potongan = $disc / 100 * $harga;
					                                        		$potonganHarga = $harga - $potongan;
					                                        		$totalPrice = $totalPrice + $potonganHarga;
					                                        		$subtotal = $subtotal + $harga;
					                                        		$discSum = $discSum + $potongan;
					                                        		$counter++;
					                                        		?>
					                                        		<tr>
					                                        			<td>{{ $counter }}</td>
						                                        		<td>{{ $ad->ad_id }}</td>
						                                        		<td>{{ Setting::get('ads.price_notes') }}</td>
						                                        		<td class="text-right">1</td>
						                                        		<td class="text-right">Rp {{ number_format($harga, 0, '.', ',') }}</td>
						                                        		<td class="text-right">{{ $disc }}%</td>
						                                        		<td class="text-right">Rp {{ number_format($potonganHarga, 0, '.', ',') }}</td>
					                                        		</tr>
					                                        	@endforeach
					                                        </tbody>
					                                    </table>
					                                </div>
					                            </div>
					                        </div>
					                    </div>

					                    <div class="col-md-12">
					                        <div class="row" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
					                            <div class="col-md-4 col-md-offset-8">
					                                <p class="text-right"><strong>SUB TOTAL: Rp {{ number_format($subtotal, 0, '.', ',') }}</strong></p>
					                                <p class="text-right">TOTAL POTONGAN HARGA: Rp {{ number_format($discSum, 0, '.', ',') }}</p>
					                                <p class="text-right">VAT: 0%</p>
					                                <hr>
					                                <h3 class="text-right text-danger" style="font-weight: bold;">Rp {{ number_format($totalPrice, 0, '.', ',') }}</h3>
					                            </div>
					                        </div>
					                    </div>
					                </div>

					            </div>

					        </div>
						</div>
						<div class="panel-footer text-right">
							<a class="btn btn-info" href="javascript:;" role="button" onClick="alert('Service unavailable!')"><i class="ti ti-email"></i>&nbsp;&nbsp;Email</a>
							<a class="btn btn-success" href="javascript:window.print()" role="button"><i class="ti ti-printer"></i>&nbsp;&nbsp;Print</a>
							<a class="btn btn-default" href="{{ url('account/ads') }}" role="button"><i class="ti ti-list"></i>&nbsp;&nbsp;Manage</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./End Ads Table -->
	</div>
@endsection

@section('page-styles')
@endsection

@section('page-scripts')
@endsection

@section('inline-script')
	<script type="text/javascript">
	</script>
@endsection

@section('inline-style')
<style type="text/css">
</style>
@stop