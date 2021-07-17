

<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content={{ csrf_token() }}>
        <title>@yield('title', 'SME')</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/fontawesome/css/all.min.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('fontaw/font-awesome.min.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link href="{{ asset('vendor/floating-scroll/jquery.floatingscroll.css') }}" rel="stylesheet">
 <!-- datatable -->
		<!-- Styles -->
		@stack('styles')
    </head>
</head>
<body>
@include('layouts.navbar')
<section id="app">
	@yield('content')
	<change-password></change-password>
</section>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
   
    <!-- Material Design -->
    <script src="{{ asset('vendor/material-kit/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/material-kit/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/material-kit/js/material-kit.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>