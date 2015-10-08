		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnav">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{route('home')}}">Host Login</a>
				</div>
				
				<div class="collapse navbar-collapse" id="mainnav">
					<ul class="nav navbar-nav navbar-right">
						<li @if($page == 'Home')class="active"@endif><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						
						@if(Auth::check())
						<?php $legacy = 'false'; if(Auth::user()->id <= Core::getLegacy()) $legacy = 'true'; ?>
						<p id="edata" class="hidden" data-legacy="{{$legacy}}" data-xsalt="{{Core::getSalt()}}">
						@else
						<p id="edata" class="hidden" data-xsalt="{{Core::getSalt()}}">
						@endif


						@if(Auth::check())
						<li @if($page == 'DashBoard')class="active"@endif><a href="{{ route('dashboard') }}"><span class="glyphicon glyphicon-tasks"></span> Dashboard</a></li>
						@endif
						<li @if($page == 'Features')class="active"@endif><a href="{{ route('page', array('features')) }}"><span class="glyphicon glyphicon-flash"></span> Features</a></li>
						<li @if($page == 'About')class="active"@endif><a href="{{ route('page', array('about')) }}"><span class="glyphicon glyphicon-globe"></span> About Us</a></li>
						
						@if(Auth::check())
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Hello {{{Auth::user()->firstname}}} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('preferences') }}"><span class="glyphicon glyphicon-wrench"></span> Account Settings</a></li>
								<li><a href="{{ route('logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
							</ul>
						</li>
						@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> Hello Guest <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
								<li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-link"></span> Sign Up</a></li>
								<li><a href="{{ route('forgotpassword') }}"><span class="glyphicon glyphicon-asterisk"></span> Forgot Password</a></li>
							</ul>
						</li>
						@endif
					</ul>
				</div>
			</div>
		</nav>