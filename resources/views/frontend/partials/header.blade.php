<style type="text/css">
	.marquee {
	  height: 40px;
	  overflow: hidden;
	  position: relative;
	  line-height: 40px;
	}
	.marquee div {
	  display: block;
	  width: 200%;
	  height: 30px;

	  position: absolute;
	  overflow: hidden;

	  animation: marquee 20s linear infinite;
	  -moz-animation: marquee 20s linear infinite;
	  -webkit-animation: marquee 20s linear infinite;
	}
	.marquee span {
	  float: left;
	  width: 50%;
	}
	@keyframes marquee {
	  0% { left: 100%; }
	  100% { left: -100%; }
	}
	@-webkit-keyframes marquee {
	  0% { left: 100%; }
	  100% { left: -100%; }
	}
	@-moz-keyframes marquee {
	  0% { left: 100%; }
	  100% { left: -100%; }
	}
</style>
<div id="top-header">
	<div class="container">
		<ul class="social-links">
			<li class="twitter"><a href="javascript:;"></a></li>
			<li class="fb"><a href="javascript:;"></a></li>
		</ul>
		<div class="marquee">
			<div class="m-inner">
				<span>{{ Setting::get('site_settings.announcement') }}</span>
			</div>
		</div>
		<form action="#" method="POST" role="form" id="form-subscribe-top">
			<div class="col-xs-10">
				<input type="text" name="email" placeholder="Your Email" class="form-control">
			</div>
			<div class="col-xs-2" style="padding: 0;">
				<button type="button" class="btn btn-default btn-block"></button>
			</div>
		</form>
	</div>
</div>

<header id="header">
	<div class="container">
		<div class="row">
			<!-- Logo -->
			<div class="col-md-4 col-sm-5">
				<div id="logo">
					<!-- <?php echo date('Y-m-d H:i:s'); ?> -->
					<?php if (Setting::get('site_settings.enable_sessional_logo') == 'on'): ?>
						<?php
						$show_start = strtotime(Setting::get('site_settings.sessional_show'));
						$show_end = strtotime(Setting::get('site_settings.sessional_end'));
						?>
						<?php if ($show_start <= time() AND $show_end >= time()): ?>
							<a href="{{ url('/') }}" title="MyListing"><img src="<?php echo url(Setting::get('site_settings.sessional_logo')) ?>" alt="MyListing"></a>
						<?php else: ?>
							<a href="{{ url('/') }}" title="MyListing"><img src="<?php echo url(Setting::get('site_settings.default_logo')) ?>" alt="MyListing"></a>
						<?php endif ?>

					<?php else: ?>
						<a href="{{ url('/') }}" title="MyListing"><img src="<?php echo url(Setting::get('site_settings.default_logo')) ?>" alt="MyListing"></a>
					<?php endif ?>
				</div>
			</div>
			<!-- ./End logo -->
<!-- 
			<?php // $ads = getActiveAds(true);// dd($ads); ?>

			<?php // if (count($ads) > 0): ?>
				<?php // foreach ($ads as $ad): ?>
					<?php /*
					$assets = json_decode($ad->assets);
					$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
					$img_entry = str_replace($filename, 'thumb-'.$filename, $assets[0]);*/
					?>
					<div class="col-md-4">
						<div class="header-top-r">
							<a href="<?php // echo url('ads' .'/'.  $ad->link) ?>" target="_blank" class="topra top-r1"><img src="<?php // echo url($img_entry); ?>"></a>
						</div>
					</div>
				<?php // endforeach ?>
			<?php // endif ?> -->
						<?php 
							$ads = getActiveAds(true);
							$ads_left = array();
							$ads_right = array();
							$c = 1;
							foreach ($ads as $ad) {
								$ad = $ad->toarray();
								if(($c %2) == 0) array_push($ads_left, $ad);
								else array_push($ads_right, $ad);
								$c++;
							}
						?>
						<div class="col-md-4">
							<div class="header-top-r">
								<div class="flexslider">
									<ul class="slides">
										<?php $c = 0; ?>
										@foreach ($ads_left as $ad)
											<?php
											$assets = json_decode($ad['assets']);
											$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
											$img_entry = str_replace($filename, 'thumb-'.$filename, $assets[0]);
											?>
											<li><a href="<?php echo 'http://' . $ad['link'] ?>" class="topra top-r1"><img style="height: 94px; border-radius: 5px;" src="{{ url($img_entry) }}" alt=""></a></li>
											<?php $c++; ?>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="header-top-r">
								<div class="flexslider">
									<ul class="slides">
										<?php $c = 0; ?>
										@foreach ($ads_right as $ad)
											<?php
											$assets = json_decode($ad['assets']);
											$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
											$img_entry = str_replace($filename, 'thumb-'.$filename, $assets[0]);
											?>
											<li><a href="<?php echo 'http://' . $ad['link'] ?>" class="topra top-r1"><img style="height: 94px; border-radius: 5px;" src="{{ url($img_entry) }}" alt=""></a></li>
											<?php $c++; ?>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
			<!-- 
			<div class="col-md-4">
				<div class="header-top-r">
					<a href="#" class="ads top-r1"><img src="{{ asset('assets/frontend/img/cs/ads-300x92.png') }}"></a>
				</div>
			</div>
			<!--
			<div class="col-md-4">
				<div class="header-top-r">
					<a href="#" class="ads top-r1"><img src="{{ asset('assets/frontend/img/cs/ads-300x92.png') }}"></a>
				</div>
			</div> -->	
		</div>
	</div>
</header>
