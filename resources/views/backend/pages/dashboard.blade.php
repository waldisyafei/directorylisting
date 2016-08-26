@extends('backend.base')

@section('title', 'Dashboard')

@section('content')
	<ol class="breadcrumb">
	    <li class=""><a href="{{ url('app-admin') }}">Home</a></li>
	    <li class="active"><a href="{{ url('app-admin') }}">Dashboard</a></li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Active Listings</span></div>
					<div class="tile-body"><span><?php echo getListings('active')->count(); ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Active Ads</span></div>
					<div class="tile-body"><span><?php echo getAds('active')->count(); ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Active Customers</span></div>
					<div class="tile-body"><span><?php echo $users = App\Models\User::count(); ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-3">
				<div class="info-tile tile-orange">
					<div class="tile-icon"><i class="ti ti-layout-list-thumb-alt"></i></div>
					<div class="tile-heading"><span>Almost Expire Listings</span></div>
					<div class="tile-body">
						<span>
							<?php 
								//echo getSubscriberListings('active')->count();
								$listings = App\Models\Listing::where('customer_id', Auth::user()->get()->user_id)->orderby('created_at', 'DESC')->get();
								$expired_listings = array();
								$almost_expired_listings = array();
								foreach ($listings as $listing) {
									$listing_date = explode("-", $listing->expired_date);
									if ($listing_date[0] >= date('Y')) {
										if ($listing_date[1] >= date('m')) {
												$L_date = explode(" ", $listing_date[2]);
											if ((date('d') - Setting::get('site_settings.almost_expired')) <= $L_date[0] && date('d')<= $L_date[0]){
												$almost_expired_listings[] = $listing->id;
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
			<div class="col-md-6">
				<div class="info-tile tile-blue">
					<div class="tile-icon"><i class="fa fa-money"></i></div>
					<div class="tile-heading"><span>Payment Confirm</span></div>
                    <?php
                    $unconfirmed = getListings('pending')->count();
                    $unconfirmed = $unconfirmed + getAds('pending')->count();
                    ?>
					<div class="tile-body"><span><?php echo $unconfirmed; ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="info-tile tile-green">
					<div class="tile-icon"><i class="ti ti-check-box"></i></div>
					<div class="tile-heading"><span>Content Need Approval</span></div>
					<?php
					$need_approval = getListings('checking')->count();
					$need_approval = $need_approval + getAds('checking')->count();
					?>
					<div class="tile-body"><span><?php echo $need_approval; ?></span></div>
					<!-- <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div> -->
				</div>
			</div>
		</div>
		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-gray" data-widget='{"draggable": "false"}'>
		                <div class="panel-heading">
		                	<h2>Recent Activities</h2>
			                <div class="panel-ctrls button-icon-bg" 
								data-actions-container="" 
								data-action-collapse='{"target": ".panel-body"}'
								data-action-colorpicker=''
								data-action-refresh-demo='{"type": "circular"}'
								>
							</div>
						</div>
						<div class="panel-body scroll-pane" style="height: 320px;">
							<div class="scroll-content">
								<ul class="mini-timeline">
									<?php $logs = get_system_logs(10); ?>

									<?php if ($logs): ?>
										<?php foreach ($logs as $log): ?>
										<li class="mini-timeline-lime">
											<div class="timeline-icon"></div>
											<div class="timeline-body">
												<div class="timeline-content">
													<?php echo $log->log_text; ?>
													<span class="time"><?php echo human_time_diff(strtotime($log->created_at)); ?></span>
												</div>
											</div>
										</li>
										<?php endforeach ?>
									<?php endif ?>
									<li class="mini-timeline-default">
										<div class="timeline-body ml-n">
											<div class="timeline-content">
												<button type="button" data-loading-text="Loading..." class="loading-example-btn btn btn-sm btn-default">See more</button>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-bluegray" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>Visitor Stats</h2>
							<div class="panel-ctrls button-icon-bg" 
								data-actions-container="" 
								data-action-collapse='{"target": ".panel-body"}'
								data-action-colorpicker=''
								data-action-refresh-demo='{"type": "circular"}'
								>
							</div>
						</div>
						<div class="panel-body">
							<div id="socialstats" style="height: 272px;" class="mt-sm mb-sm"></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div> <!-- .container-fluid -->
@stop

@section('page-styles')
	<!-- FullCalendar -->
	<link type="text/css" href="{{ asset('assets/backend/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
	<!-- jVectorMap -->
	<link type="text/css" href="{{ asset('assets/backend/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
	<!-- Switchery -->
	<link type="text/css" href="{{ asset('assets/backend/plugins/switchery/switchery.css') }}" rel="stylesheet">
@stop

@section('page-scripts')
	<!-- Load page level scripts-->
	<!-- Charts -->
	<!-- Flot Main File -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.min.js') }}"></script>
	<!-- Flot Pie Chart Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.pie.min.js') }}"></script>
	<!-- Flot Stacked Charts Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.stack.min.js') }}"></script>
	<!-- Flot Ordered Bars Plugin-->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.orderBars.min.js') }}"></script>
	<!-- Flot Responsive -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.resize.min.js') }}"></script>
	<!-- Flot Tooltips -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.tooltip.min.js') }}"></script>
	<!-- Flot Curved Lines -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/charts-flot/jquery.flot.spline.js') }}"></script>
	<!-- Sparkline -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/sparklines/jquery.sparklines.min.js') }}"></script>

	<!-- jVectorMap -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
	<!-- jVectorMap -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

	<!-- Switchery -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/switchery/switchery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/easypiechart/jquery.easypiechart.js') }}"></script>
	<!-- Moment.js Dependency -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/fullcalendar/moment.min.js') }}"></script>
	<!-- Calendar Plugin -->
	<script type="text/javascript" src="{{ asset('assets/backend/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
	<!-- Initialize scripts for this page-->
	<script type="text/javascript" src="{{ asset('assets/backend/demo/demo-index.js') }}"></script>
	<!-- End loading page level scripts-->
@stop