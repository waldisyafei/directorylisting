@extends('customer.base')

@section('title', 'Dashboard')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('subscriber') }}">Home</a></li>
	</ol>
	<div class="container-fluid">
		<div class="row">
	        <div class="col-md-12">
	            <div class="panel panel-default" data-widget='{"draggable": "false"}'>
	                <div class="panel-heading">
	                    <h2>Listing Views Statistic</h2>
	                    <div class="panel-ctrls">
	                    	<div class="dataTables_filter pull-right">
	                    		<label class="panel-ctrls-center">
	                    			<select class="form-control" id="choose-listing">
		                    		<?php $listings = App\Models\Listing::where('customer_id', Auth::customer()->get()->customer_id)->orderby('created_at', 'DESC')->get(); ?>

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