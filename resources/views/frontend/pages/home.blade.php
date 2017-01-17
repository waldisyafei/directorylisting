@extends('frontend.base')

@section('title', 'Home')

@section('content')
	<div class="middle-content">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<div class="teaser-home">
						<img src="{{ asset('assets/frontend/images/slider-bg.jpg') }}" alt="">
						<?php
						$categories = App\Models\ListingCategory::where('parent', 0)->get();
						$counter = 1;
						?>
						@foreach ($categories as $category)
							<div class="btn-group cat-item{{ $counter > 3 ? ' dropup' : null }}">
								<a href="javascript:;" class="cat-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $category->title }}</a>
								@if (count($category->children) > 0)
									<ul class="dropdown-menu">
										@foreach ($category->children as $children)
											<li><a href="{{ url('category', $children->slug) }}">{{ $children->title }}</a></li>
										@endforeach
									</ul>
								@endif
							</div>
							<?php $counter++; ?>
						@endforeach
					</div>
				</div>
				<div class="col-md-3">
					<?php $counter = 1; ?>
					@foreach ($categories as $key => &$category)
					<div class="random-listing type-1">
						@if (!empty($category->children))
							<div class="flexslider">
								<ul class="slides">
									@foreach ($category->children as $children)<?php// dd($children); ?> 
										<?php
										$childrenListings = getActiveListings($children->id, 'active');
										$childrenImages = array();
										foreach ($childrenListings as $childrenListing) {
											$assets = json_decode($childrenListing->assets);
											$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
											$childrenImages[] = str_replace($filename, 'thumb-'.$filename, $assets[0]);
										}
										?> <?php if (isset($filename)) dd($filename); ?> 
										@if (!empty($childrenImages))
											@foreach ($childrenImages as $childrenImage)<?php dd($childrenImages); ?> 
												<li><img src="{{ $childrenImage }}" alt=""></li>
											@endforeach
										@endif
									@endforeach
								</ul>
							</div>
						@else
							<img src="{{ asset('assets/frontend/images/empty-listing.png') }}" alt="">
						@endif
					</div>
					<?php
					unset($categories[$key]);
					$categories = $categories;
					$counter++;
					if ($counter > 2) {
						break;
					}
					?>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-content">
		<div class="container">
			<div class="row">
				<?php $counter = 1; ?>
				@foreach ($categories as $key => &$category)
				<div class="col-md-3">
					<div class="random-listing type-1">
						<?php
						$childrenImages = array();
						if (!empty($category->children)) {
							foreach ($category->children as $children) {
								$childrenListings = getActiveListings($children->id, 'active');
								foreach ($childrenListings as $childrenListing) {
									$assets = json_decode($childrenListing->assets);
									$filename = substr($assets[0], strrpos($assets[0], '/') + 1);
									$childrenImages[] = str_replace($filename, 'thumb-'.$filename, $assets[0]);
								}
							}
						}
						?>
						<?php if (count($childrenImages) > 0): ?>
							<div class="flexslider">
								<ul class="slides">
									<?php foreach ($childrenImages as $childrenImage): ?>
										<li><img src="{{ $childrenImage }}" alt=""></li>
									<?php endforeach ?>	
								</ul>
							</div>
						<?php endif ?>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
@stop

@section('page-styles')
	{{-- expr --}}
@stop

@section('page-scripts')
	<script type="text/javascript" src="{{ asset('assets/frontend/js/jquery.flexslider-min.js') }}"></script>
@stop

@section('inline-script')
	<script type="text/javascript">
		$(function(){
			$('.teaser-home .cat-item').eq(0).css({
				'left': '73px',
				'top': '3px'
			});
			$('.teaser-home .cat-item').eq(1).css({
				'left': '303px',
				'top': '3px'
			});
			$('.teaser-home .cat-item').eq(2).css({
				'left': '534px',
				'top': '3px'
			});
			$('.teaser-home .cat-item').eq(3).css({
				'left': '73px',
				'bottom': '3px'
			});
			$('.teaser-home .cat-item').eq(4).css({
				'left': '305px',
				'bottom': '3px'
			});
			$('.teaser-home .cat-item').eq(5).css({
				'left': '535px',
				'bottom': '3px'
			});

			$('.flexslider').each(function(){
				var sliderSettings = {
					controlNav: false,
					directionNav: false,
					animationSpeed: 700,
					slideshowSpeed: randomIntFromInterval(5000, 2000),
					easing: 'easeInOutBack',
					useCSS: false
				};

				$(this).flexslider(sliderSettings);
			});

			function randomIntFromInterval(min,max)
			{
			    return Math.floor(Math.random()*(max-min+1)+min);
			}
		});
	</script>
@stop