@extends('customer.base')

@section('title', 'My Listing')

@section('content')
	<ol class="breadcrumb">
	    <li class="">Advertising Wizard</li>
	</ol>
	<div class="container-fluid">
		<div data-widget-group="group1">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info" data-widget='{"draggable": "false"}'>
						<div class="panel-heading">
							<h2>Buy / Renews Ads</h2>
							<div class="panel-ctrls" data-actions-container="" data-action-collapse='{"target": ".panel-body"}'></div>
						</div>
						<div class="panel-body">
							<div class="btn-wrapper">
								<div class="col-md-2 text-center">
									<a href="{{ url('account/ads/buy') }}" class="btn btn-success btn-block">BUY</a>
								</div>
								<div class="col-md-2 text-center">
									<a href="{{ url('account/ads/renew') }}" class="btn btn-info btn-block">RENEW</a>
								</div>
							</div>
						</div>
					</div>
			    </div>
			</div>
		</div>
	</div>
@endsection

@section('page-styles')
@endsection

@section('page-scripts')
	<!-- Load page level scripts-->
@endsection

@section('inline-script')
	<script type="text/javascript">
	$(function(){
		
	});

		
	</script>
@endsection

@section('inline-style')
<style type="text/css">
	.buy-listing {
		display: none;
	}
	.renew-listing {
		display: none;
	}
</style>
@stop