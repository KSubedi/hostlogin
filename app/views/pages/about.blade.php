@extends('layouts.base')
@section('title')
About Us
@stop

@section('body')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">About Us</li>
</ol>
<div class="jumbotron alert-info text-right">
	<h1>About Us</h1>
	<p>Just some information about us.</p>
</div>

<div class="well">
	<p>Host Login was created by me (Kaushal Subedi <a href="http://kaushal.us/">http://kaushal.us/</a>) to make it easier for people to access information about all of their web hosting accounts from one place.

	<br><br>After having to deal with remembering or checking email again and again to get information about client's servers, I thought i would create a system where I could access all the servers from one place.
	<br><br>At first I created it so that I could use it for my personal use only, but later after seeing that a lot of other people were in the same boat as me, I thought i would make a public version with encryption and other features.
	<br><br>After getting some good feedback from a tiny survey I conducted, I started working on the project and made some big changes to the basic system that I was using for myself.
	<br><br><br>Host Login uses the following third party addons:
	<br><br><a href="http://jquery.com/">jQuery Javascript Library</a>
	<br><br><a href="https://github.com/mdp/gibberish-aes">Gibberish AES Client Side Encryption Library</a>
	<br><br><a href="https://github.com/placemarker/jQuery-MD5">jQuery MD5 Plugin</a>

</div>
@stop