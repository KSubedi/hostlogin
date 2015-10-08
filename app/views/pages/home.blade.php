@extends('layouts.base')
@section('title')
HomePage
@stop

@section('body')
			<div class="row">
				<div class="col-md-8">
					<div class="jumbotron">
						<h1>Host Login</h1>
						<p>Host Login lets you store information about all of your web hosting accounts including VPS and Dedicated Server accounts in once place so that you can access them easily.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading text-center"><h3>Control Panel</h3></div>
						<div class="panel-body">
						<form class="form-horizontal" role="form" action="{{ route('submit') }}" method="post">
							{{ Form::token() }}
							<input type="hidden" name="home" value="true">
							@foreach($errors->get('email') as $message)
								<div class="alert alert-danger">{{ $message }}</div>
							@endforeach
							<div class="form-group">
								<label for="email" class="col-sm-3 control-label">Email</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="email" name="email" placeholder="mail@hostlog.in" required></input>
								</div>
							</div>
							@foreach($errors->get('password') as $message)
								<div class="alert alert-danger">{{ $message }}</div>
							@endforeach
							<div class="form-group">
								<label for="password" class="col-sm-3 control-label">Password</label>
								<div class="col-sm-9">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password" required></input>
								</div>
							</div>
							<div class="text-center">
								<label class="checkbox-inline">
								  <input type="radio" id="login" value="login" name="type" checked> Existing User
								</label>
								<label class="checkbox-inline">
								  <input type="radio" id="register" value="register" name="type"> New User
								</label>
							</div>
							<div class="text-center">
								<br/><button class="btn btn-default btn-xs" type="submit">Submit</button>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-default text-center">
						<div class="panel-heading"><h3>Secure</h3></div>
						<div class="panel-body">
							<img src="{{ route('images', 'secure') }}"></img>
							<p><br/>All data submitted to our servers are encrypted using 256 bit SSL. All the passwords that are going to be stored in our servers are going to be encrypted end to end using FIPS compliant AES256 encryption system so that only you can access them.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default text-center">
						<div class="panel-heading"><h3>Fast</h3></div>
						<div class="panel-body">
							<img src="{{ route('images', 'fast') }}"></img>
							<p><br/>All of the important information about your servers that you need frequently will be available in one place which will make thinks like accessing your server or getting information about your server like ip addresses and hostname faster.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default text-center">
						<div class="panel-heading"><h3>Free</h3></div>
						<div class="panel-body">
							<img src="{{ route('images', 'free') }}"></img>
							<p><br/>Host Login is currently free and will continue to remain free. Host Login was made by developers to make other developer's life easier since they have to deal with multiple client's servers, and we believe that there should be no costs involved in that. </p>
						</div>
					</div>
				</div>
			</div>

@stop