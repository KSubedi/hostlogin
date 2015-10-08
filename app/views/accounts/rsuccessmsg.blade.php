@extends('layouts.base')
@section('title')
Registration Complete
@stop

@section('body')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">Register</li>
</ol>
<div class="alert alert-success text-center">
	You have been registered successfully! We have sent an confirmation email to {{{$remail}}}. Please confirm the email before you can login.
</div>
@stop