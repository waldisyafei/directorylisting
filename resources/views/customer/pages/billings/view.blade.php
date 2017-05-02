@extends('customer.base')

@section('title', 'View Billing')

@section('content')
	<h3 class="page-title">Billings</h3>
	<ol class="breadcrumb">
	    <li><a href="{{ url('account/billings') }}">Billings</a></li>
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
		                                <strong>{{ $billing->customer->customer_name }}</strong><br>
		                                <?php $address = $billing->customer->address; ?>
		                                <?php echo $address->address_1 . '<br>'; ?>
		                                <?php echo $address->address_2 != '' ? $address->address_1 . '<br>' : null; ?>
		                                {{ $address->city }}, {{ App\Models\Zone::find($address->zone_id)->name }}. {{ $address->postcode }}<br>
		                                {{ App\Models\Country::find($address->country_id)->name }}
		                            </address>
		                        </div>
		                        <div class="pull-right">
		                            <h3 class="text-muted"><br></h3>
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
		                                                <th width="200">Listing ID</th>
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
		                                                
		                                                <?php
															$packages = App\Models\Package::where('id', $billing->id)->select('name')->orderby('created_at', 'DESC')->get();
															foreach ($packages as $package){
																echo '<td>' . $package->name . '</td>';
															}
											 			?>
		                                                <td><?php echo $billing->item_type ?></td>
		                                                <td>1</td>
		                                                <td>Rp {{ number_format($billing->amount, 0, '.',',') }}</td>
		                                                <td>
		                                                	<?php $price_disc = $billing->customer ? Setting::get('ads.price_discount') : Setting::get('ads.noncust.price_discount')?>
		                                                	<?php if ($billing->item_type == 'ads'): ?>
								                                {{ $price_disc }}%
							                                <?php else: ?>
								                                {{ $billing->item->package->discount }}%
							                            	<?php endif ?>
		                                                </td>
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
		                    
	                    @if ($billing->confirm_message == '' && $billing->bukti_pembayaran == '')
	                    <div class="row">
			                	<form action="{{ url('account/billings/confirm', $billing->id) }}" method="POST" role="form" enctype="multipart/form-data">
			                		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			                		<input type="hidden" name="billing_id" value="{{ $billing->id }}">
			                		<input type="hidden" name="edit" value="true">
			                		<legend>Confirm Payment</legend>
			                		
			                		@if ($billing->confirm_message == '')
			                		<div class="form-group">
			                			<label for="">Confirm Message</label>
			                			<?php 
			                			if($billing->item_type == "listing")
			                				$placeholder = "<Customer Name>, <Customer Rekening Number>, <Invoice ID>, <Transfer To BCA/Mandiri>, <Tgl Transfer (dd/mm/yyyy)>";
			                			else
			                				$placeholder = "<Customer Name>, <Customer Rekening Number>, <Invoice ID>, <Transfer To BCA/Mandiri>";
			                			?>
										<textarea class="form-control" value="{{ $billing->confirm_message }}" rows="5" name="message" placeholder="{{ $placeholder }}"></textarea>
			                		</div>
			                		@else
			                		<div class="form-group">
			                			<label for="">Confirm Message</label>
										<p>{{ $billing->confirm_message }}
			                		</div>
			                		@endif
			                		
			                		@if ($billing->bukti_pembayaran == '')
			                		<div class="form-group">
			                			<label>Bukti Pembayaran</label>
			                			<input type="file" name="image" value="{{ $billing->bukti_pembayaran }}" accept=".pdf,image/*">
			                		</div>
			                		@else
			                		<div class="form-group">
			                			<label>Bukti Pembayaran</label>
			                				<img src="{{ asset($billing->bukti_pembayaran) }}" class="img-responsive" alt=""><br/>
			                				<a class="btn btn-danger" href="{{ url('account/billings/confirm/delimage', $billing->id) }}" role="button"><i class="ti ti-trash"></i> Delete Image</a> <em>(Be Careful this will immediately delete your proof of payment)</em>
				                	</div>
			                		@endif

			                		@if ($billing->bukti_pembayaran == '' && $billing->confirm_message == '')
			                		<button type="submit" class="btn btn-primary">Confirm</button>
			                		@elseif (isset($edit) && $edit == true && ($billing->bukti_pembayaran !== '' || $billing->confirm_message !== ''))
			                		<button type="submit" class="btn btn-primary">Update</button>
			                		@elseif ($billing->bukti_pembayaran !== '' || $billing->confirm_message !== '')
			                		<a class="btn btn-primary" href="{{ url('account/billings/confirm/edit', $billing->id) }}" role="button"><i class=""></i> Edit Confirm Payment</a>
			                		@endif
			                	</form>
			                </div>
			                @else
			                 <div class="row">
			                	<form action="{{ url('account/billings/confirm', $billing->id) }}" method="POST" role="form" enctype="multipart/form-data">
			                		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			                		<input type="hidden" name="billing_id" value="{{ $billing->id }}">
			                		<input type="hidden" name="edit" value="true">
			                		<legend>Confirm Payment</legend>
			                		
			                		@if ($billing->confirm_message == '')
			                		<div class="form-group">
			                			<label for="">Confirm Message</label>
										<textarea class="form-control" value="{{ $billing->confirm_message }}" rows="5" name="message" disabled></textarea>
			                		</div>
			                		@else
			                		<div class="form-group">
			                			<label for="">Confirm Message</label>
										<p>{{ $billing->confirm_message }}</p>
			                		</div>
			                		@endif
			                		
			                		@if ($billing->image_pembayaran == null && $billing->file_pembayaran == null )
			                		<div class="form-group">
			                			<label>Bukti Pembayaran</label>
			                			<p><em>Belum ada bukti pembayaran yang diupload</em></p>
			                		</div>
			                		@elseif($billing->image_pembayaran !== null)
			                		<div class="form-group">
			                			<label>Bukti Pembayaran</label>
			                				<img src="{{ asset($billing->image_pembayaran) }}" class="img-responsive" alt=""><br/>
			                				<a class="btn btn-danger" href="{{ url('account/billings/confirm/delimage', $billing->id) }}" role="button"><i class="ti ti-trash"></i> Delete Image</a> <em>(Be Careful this will immediately delete your proof of payment)</em>
				                	</div>
				                	@else
				                	<div class="form-group">
			                			<label>Bukti Pembayaran</label>
			                			<?php
			                			$filename = explode( '/', $billing->file_pembayaran );
			                			$filename = $filename[5];
			                			?>
			                			<p><a class="img-responsive" href="{{ asset($billing->file_pembayaran) }}" > {{ $filename }}</a><br>
			                			<a class="btn btn-danger" href="{{ url('account/billings/confirm/delimage', $billing->id) }}" role="button"><i class="ti ti-trash"></i> Delete File</a> <em>(Be Careful this will immediately delete your proof of payment)</em>
			                		</div>
			                		@endif

			                		<a class="btn btn-primary" href="{{ url('account/billings/confirm/edit', $billing->id) }}" role="button"><i class=""></i> Edit Confirm Payment</a>
			                	</form>
			                </div>
			                @endif
		            </div>

		        </div>
			</div>
		</div>
	</div>
@endsection