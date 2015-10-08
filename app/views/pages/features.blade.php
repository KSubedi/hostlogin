@extends('layouts.base')
@section('title')
Features
@stop

@section('body')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">Features</li>
</ol>
<div class="jumbotron alert-info text-right">
	<h1>Features</h1>
	<p>Some features we provide.</p>
</div>

<div class="well">
	<div class="row">
		<div class="col-md-2"><img src="{{route('images', 'panel')}}" width="100%" class="img-thumbnail"></div>

		<div class="col-md-10">
			<h4>All In One</h4>
			<p>All information about your server like Provider, Hostname, IP Addresses, Billing Login, Passwords etc can be stored in one place. You can also add additional information like notes in there so if you ever need anything about your server, it will be available all in one place.</p>
		</div>
	</div>
</div>

<div class="well">
	<div class="row">
		<div class="col-md-10">
			<h4>Encrypted Passwords</h4>
			<p>Host Login allows you to save your panel login and billing login passwords. These passwords will be encrypted using end to end encryption which means the unencrypted versions of passwords will never even reach our servers. No one will be able to see your passwords unless they have the encryption passphrase that you set while creating the account.</p>
		</div>

		<div class="col-md-2"><img src="{{route('images', 'encryption')}}" width="100%" class="img-thumbnail"></div>
	</div>
</div>

<div class="well">
	<div class="row">
		<div class="col-md-2"><img src="{{route('images', 'colorcoding')}}" width="100%" class="img-thumbnail"></div>

		<div class="col-md-10">
			<h4>Color Coding</h4>
			<p>We support color coding that will let you give each server their own color so that you can group servers by different colors. This will help you visually identify servers and group them differently. We currently support 5 colors: Default(Gray), Red, Blue, Green and Yellow.</p>
		</div>
	</div>
</div>

<div class="well">
	<div class="row">
		<div class="col-md-10">
			<h4>Instant Search</h4>
			<p>Our instant search feature will help you find the server you are looking for without even reloading the page. You can search for the name of the server or any information about the server. For example, you can either type in the IP address to find server with that IP, or type in a location to find servers that are located there.</p>
		</div>

		<div class="col-md-2"><img src="{{route('images', 'instantsearch')}}" width="100%" class="img-thumbnail"></div>
	</div>
</div>

<div class="alert alert-info text-center">
	<p>There are a lot more features.</p>
</div>
@stop