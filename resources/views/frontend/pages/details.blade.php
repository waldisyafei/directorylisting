@extends('frontend.base')

@section('title', $item->title)

@section('content')
	<div id="search-section">
		<div class="container clearfix">
			<div class="search-in-cat">
				<form method="get" role="form" class="clearfix" action="search">
					<input type="text" name="q" id="search-input" placeholder="Search Keywords" class="form-control">
					<button type="submit" class="btn-search">Search</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</div>
			<div class="subscribe">
				<form method="get" role="form" class="clearfix">
					<input type="text" name="email" id="search-input" placeholder="Your Email" class="form-control">
					<button type="submit" class="btn-search">SUBSCRIBE</button>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</div>
		</div>
	</div>

	<div class="cat-nav-section">
		<div class="container">
			<ul class="nav cat-menu">
				<li class="home"><a href="javascript:;"></a></li>

				<?php $categories = App\Models\ListingCategory::all(); ?>
				<?php foreach ($categories as $category): ?>
					<?php if ($category->parent == 0): ?>
						<?php foreach ($category->children as $child): ?>
						<li><a href="{{ url('category', $child->slug) }}">{{ $child->title }}</a></li>
						<?php endforeach ?>
					<?php endif ?>
				<?php endforeach ?>
			</ul>
		</div>
	</div>

	<div class="content">
		<div class="container">
			<div class="row">
				<div class="listing-meta-tag clearfix">
					<div class="col-md-8">
						<div class="listing-info">
							<h1 class="listing-detail-title">{{ strtoupper($item->title) }}</h1>
							<div class="listing-detail-thumb">
								<?php
								$assets = json_decode($item->assets);
								$filename = $assets[0];
								?>
								<a href="javascript:;"><img src="{{ asset($filename) }}" alt=""></a>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="listing-vendor-info">
							<div class="info-inner">
								<?php
								$itemdress = $item->customer->address;
								$province = App\Models\Zone::find($itemdress->zone_id);
								$country = App\Models\Country::find($itemdress->country_id)->name;
								?>
								<span class="vendor-name">{{ $item->customer->customer_name }}</span>
								<p class="vendor-address">{{ $itemdress->address_1 }}, {{ $province->name }} {{ $itemdress->postcode }} <br>{{ $country }}</p>
								<span class="vendor-phone"><i class="glyphicon glyphicon-earphone"></i> {{ $item->customer->phone }}</span>
								<a href="<?php echo !empty($item->url) ? $item->url : '#' ?>" target="_blank" class="vendor-site-link">VISIT WEBSITE <i class="glyphicon glyphicon-play pull-right"></i></a>
								<a href="<?php echo !empty($item->url) ? $item->url : '#' ?>" target="_blank" class="listing-goto-link">Produk ini dapat diperoleh di &raquo;</a>
							</div>
							<!-- <div class="vendor-btn">
								<a href="javascript:;" class="grey-dark">DESKRIPSI</a>
								<a href="javascript:;" class="grey">REVIEW</a>
								<a href="javascript:;" class="grey">.......................</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top: 35px;">
				<div class="col-md-12">
					<div role="tabpanel">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#deskripsi" aria-controls="deskripsi" role="tab" data-toggle="tab">DESKRIPSI</a>
							</li>
							<li role="presentation">
								<a href="#review" aria-controls="review" role="tab" data-toggle="tab">REVIEW</a>
							</li>
							<li role="presentation">
								<a href="#custom" aria-controls="custom" role="tab" data-toggle="tab">{{ $item->custom_tab_title != '' ? $item->custom_tab_title : 'CUSTOM' }}</a>
							</li>
						</ul>
					
						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active" id="deskripsi">
								<div class="listing-description">
									<div class="desc-inner">
										<div class="clearfix">
											<div class="col-md-4">
												<span class="listing-price-range">HARGA: <strong>Rp <?php echo $item->price_from ? number_format($item->price_from, 0, ',', '.') : '0' ?><!--  - Rp <?php echo $item->price_to ? number_format($item->price_to, 0, ',', '.') : '0' ?> --></strong></span>
											</div>
											<div class="col-md-8">
												<a href="<?php echo !empty($item->url) ? $item->url : '#' ?>" target="_blank" class="listing-goto-link">Produk ini dapat diperoleh di &raquo;</a>
											</div>
										</div>
										<div class="clearfix">
											<div class="listing-desc-content">
												{!! $item->content !!}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="review">
								@if ($item->review != '')
									{!! $item->review !!}
								@else
									<p>No Review</p>
								@endif
							</div>
							<div role="tabpanel" class="tab-pane fade" id="custom">
								@if ($item->custom_tab != '')
									{!! $item->custom_tab !!}
								@else
									<p>No Custom Tab Set</p>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="row">
				<div class="col-md-12">
					
				</div>
			</div> -->
		</div>
	</div>

	<?php
	if (get_listing_meta('listing_views_'.date('Ymd'), $item->id)) {
		$count = get_listing_meta('listing_views_'.date('Ymd'), $item->id);

		$count = $count + 1;

		update_listing_meta('listing_views_'.date('Ymd'), $count, $item->id);
	} else {
		add_listing_meta('listing_views_'.date('Ymd'), 1, $item->id);
	}
	?>
@stop

@section('page-styles')
<style type="text/css">
	.listing-detail-thumb {
	    height: 320px;
	    overflow: hidden;
	}

	.nav-tabs li a{
		font-weight: bold;
	}
	.listing-description {
		margin-top: 0;
		box-shadow: 0 0 0;
	}
	.tab-pane {
		background: #fff;
		padding: 20px 15px 15px 15px;
	    border: 1px solid #ddd;
	    border-top-width: 0;
	}
	.listing-description .desc-inner {
		padding: 0;
	}
	a.listing-goto-link {
	    padding: 2px;
	    background: #b3b3b3;
	    display: block;
	    font-size: 18px;
	    text-align: center;
	    color: #fff;
	    font-family: 'Roboto', sans-serif;
	    text-decoration: none;
	    border-radius: 5px;


	}
</style>
@stop

@section('page-scripts')
	{{-- expr --}}
@stop
