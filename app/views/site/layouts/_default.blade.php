<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			OpenPayments Analytics
			@show
		</title>
		@section('meta_keywords')
		<meta name="keywords" content="OpenPayments, Open Payments Analytics, OpenPaymentsAnalytics" />
		@show
		@section('meta_author')
		<meta name="author" content="Streebo" />
		@show
		@section('meta_description')
		<meta name="description" content="Sunshine Act, OpenPayments Data Analysis, OpenPayments" />
                @show
		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" href="{{asset('bootstrap/css/styles.css')}}">

		<style>
        body {
            padding: 60px 0;
        }
		@section('styles')
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
		
		<!-- Javascripts
		================================================== -->
        <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
		<script type="application/javascript" src="http://10.0.102.77/SpotfireWeb/GetJavaScriptApi.ashx?Version=1.0"></script>
		<script src="{{asset('bootstrap/js/util.js')}}"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="{{asset('bootstrap/js/jquery.js')}}"></script>
		<script src="{{asset('bootstrap/js/typeahead.js')}}"></script>
		<script src="{{asset('bootstrap/js/bloodhound.js')}}"></script>

        @yield('scripts')
		
		
	</head>

	<body>
		<!-- To make sticky footer need to wrap in a div -->
		<div id="wrap">
		<!-- Navbar -->
		<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
			 <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
						<li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Home</a></li>
					</ul>
					@if (Auth::check())
					<ul class="nav navbar-nav">
                    <li	{{ (Request::is('user/company') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/company') }}}">Company</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li{{ (Request::is('user/physician') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/physician') }}}">Physician</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li	{{ (Request::is('user/specialty') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/specialty') }}}">Specialty</a></li>
					</ul>
					<ul class="nav navbar-nav">
						<li	{{ (Request::is('user/competition') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/competition') }}}">Competition</a></li>
					</ul>
					@endif
					
					<ul class="nav navbar-nav">
                    <li {{ (Request::is('contact') ? ' class="active"' : '') }}><a href="{{{ URL::to('contact') }}}">Contact Us</a></li>
					</ul>

                    <ul class="nav navbar-nav pull-right">
                        @if (Auth::check())
                        @if (Auth::user()->hasRole('admin'))
                        <li><a href="{{{ URL::to('admin') }}}">Admin Panel</a></li>
                        @endif
                        <li><a href="{{{ URL::to('user') }}}">Logged in as {{{ Auth::user()->username }}}</a></li>
                        <li><a href="{{{ URL::to('user/logout') }}}">Logout</a></li>
                        @else
                        <li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">Login</a></li>
                        <li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
                        @endif
                    </ul>
					<!-- ./ nav-collapse -->
				</div>
			</div>
		</div>
		<!-- ./ navbar -->

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
		</div>
		<!-- ./ container -->

		<!-- the following div is needed to make a sticky footer -->
		<div id="push"></div>
		</div>
		<!-- ./wrap -->

		
		
		<div id="footer">
			<div class="container">
				<p>OpenPaymentsAnalytics - 2015</p>
			</div>
		</div>
	</body>
</html>
