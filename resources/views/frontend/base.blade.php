<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title') - <?php echo Setting::get('site_settings.title') != '' ? Setting::get('site_settings.title') : 'MyListing' ?></title>

		<!-- Bootstrap CSS -->
		<link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/screen.css') }}">
		
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

		@yield('page-styles')

		@yield('embeed-style')

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		@include('frontend.partials.header')

		@yield('content')

		@include('frontend.partials.footer')

		@yield('inline-script')
	</body>
</html>