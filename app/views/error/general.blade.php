@extends('layouts.base')
@section('title')
Oops! Something Went Wrong
@stop

@section('body')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">Error</li>
</ol>
<div class="well text-center">
	<img src="{{route('images', 'error')}}">
	<h3>Oops! Something Went Wrong!<br>
	<small>Either the page you were looking for does not exist, or something wrong happened with our system.
	<br>We have notified our system administrators, and they should be working on it shortly.</small>
	</h3>
</div>
@stop