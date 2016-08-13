@extends('customer.base')

@section('title', 'Dashboard')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('subscriber') }}">Home</a></li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Active Listings</span></div>
					<div class="tile-body"><span><?php echo getSubscriberListings('active')->count(); ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-4">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Almost Expire Listings</span></div>
					<div class="tile-body">
						<span>
							<?php 
								//echo getSubscriberListings('active')->count();
								$listings = App\Models\Listing::where('customer_id', Auth::customer()->get()->customer_id)->orderby('created_at', 'DESC')->get();
								$expired_listings = array();
								$almost_expired_listings = array();
								foreach ($listings as $listing) {
									$listing_date = explode("-", $listing->expired_date);//print_r($listing_date);
									if ($listing_date[0] >= date('Y')) {
										if ($listing_date[1] >= date('m')) {
												$L_date = explode(" ", $listing_date[2]);// print_r($L_date);die();
											if ($L_date[0] > date('d') && $L_date[0] <= date('d')) {
												$almost_expired_listings[] = $listing->id;
												//echo "ada ";print_r($expired_listings); echo "OOEKKEKEKEKEKEK";
												//die();
											}
										} 
									}
								}
								echo count($almost_expired_listings);
							?>
						</span>
					</div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-4">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Expired Listings</span></div>
					<div class="tile-body"><span><?php echo getSubscriberListings('expired')->count(); ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
		</div>

		<div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                    <h2>Listing Views Statistic</h2>
	                    <div class="panel-ctrls">
	                    	<div class="dataTables_filter pull-right">
	                    		<label class="panel-ctrls-center">
	                    			<select class="form-control" id="choose-listing">

		                    		<?php foreach ($listings as $listing): ?>
		                    			<option value="<?php echo $listing->id ?>"><?php echo $listing->title ?></option>
		                    		<?php endforeach ?>
		                    	</select>
	                    		</label>
	                    	</div>
	                    </div>
	                </div>
	                <div class="panel-body">
	                    <div id="listing-stats"></div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
@stop

@section('inline-style')
<style type="text/css">
	.morris-hover.morris-default-style {
    border-radius: 10px;
    padding: 6px;
    color: #666;
    background: rgba(255, 255, 255, 0.8);
    border: solid 2px rgba(230, 230, 230, 0.8);
    font-family: sans-serif;
    font-size: 12px;
    text-align: center;
	}

	.morris-hover {
	    position: absolute;
	    z-index: 1000;
	}
</style>
@stop

@section('page-scripts')
<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-morrisjs/raphael.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-morrisjs/morris.min.js') }}"></script>
@stop()

@section('inline-script')
<script type="text/javascript">
	$(function(){

		Date.prototype.getMonthName = function(lang) {
		    lang = lang && (lang in Date.locale) ? lang : 'en';
		    return Date.locale[lang].month_names[this.getMonth()];
		};

		Date.prototype.getMonthNameShort = function(lang) {
		    lang = lang && (lang in Date.locale) ? lang : 'en';
		    return Date.locale[lang].month_names_short[this.getMonth()];
		};

		Date.locale = {
		    en: {
		       month_names: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		       month_names_short: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		    }
		};

		function getStats() {
			$.ajax({
				url: '<?php echo url('account/listing_stats') ?>',
				data: {
					listing_id: $('#choose-listing').find(':selected').val()
				},
				dataType: 'json',
				beforeSend: function(){
					$('#listing-stats').find('*').remove();
					$('#listing-stats').css('min-height', '100px');
				},
				success: function(res) {
					$('#listing-stats').css('min-height', 'auto');

					Morris.Line({
						element: 'listing-stats',
						data: res,
						xkey: 'date',
						ykeys: ['value'],
						labels: ['views', 'date'],
						xLabelFormat: function(d) {
							return d.getDate()+' '+(d.getMonthNameShort()); 
					  	},
					  	gridIntegers: true,
						lineColors: [Utility.getBrandColor('inverse'),Utility.getBrandColor('midnightblue')]
					});

				}
			});
		}

		getStats();

		$('#choose-listing').on('change', function(){
			getStats();
		});

	});
</script>
@stop()