<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title', 'Welcome') - Host Login</title>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/spacelab/bootstrap.min.css" rel="stylesheet">
		<link href="{{route('assets', 'styles.css')}}" rel="stylesheet">
		<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
		@yield('meta', '')
	</head>
	<body>
		@include('templates/nav')
		<div class="container">
