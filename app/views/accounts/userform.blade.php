@extends('layouts.base')
@section('title')
{{ $page }}
@stop

@section('meta')
{{Core::showScript('sha3.js')}}
{{Core::showScript('userform.js')}}
@stop

@section('body')
<div id="tokenbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="mModalLabel">Encryption Passphrase</h4>
		</div>

		<div class="modal-body">
			<p>Please enter a passphrate that will be used to encrypt your passwords.</p>
			<ul>
				<li>You will not be able to change this, so be really careful while choosing one.</li>
				<li>You will need this every time you want to decrypt passwords for your servers.</li>
				<li>This will not be stored in our servers, you are the only person who will know this.</li>
				<li>It is highly recommended that you use something else other than your password for passphrase.</li>
			</ul>
			<p>Passphrase</p>
			<input type="password" id="encpassphrase" class="form-control">
			<p>Confirm:</p>
			<input type="password" id="encpassphraseconfirm" class="form-control">
		</div>
		<div class="modal-footer">
			<button id="ctoken" type="button" class="btn btn-primary">Create Encryption Token</button>
		</div>
    </div>
  </div>
</div>


<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">{{ $page }}</li>
</ol>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $page }}</div>
				<div class="panel-body">

					<div id="message" class="alert alert-info text-center" hidden></div>
					@if(Session::has('message'))
						<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif

					@if(Session::has('warning'))
						<div class="alert alert-danger">{{ Session::get('warning') }}</div>
					@endif

					<form class="form-horizontal" role="form" action="{{ route('submit') }}" method="post">
						{{ Form::token() }}
						<input type="hidden" name="home" value="false">
						@if($page == 'Register')

						@foreach($errors->get('firstname') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input class="form-control" id="firstname" name="firstname" placeholder="First Name" value="{{{Input::old('firstname')}}}" required></input>
							</div>
						</div>

						@foreach($errors->get('lastname') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="lastname" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="{{{Input::old('lastname')}}}" required></input>
							</div>
						</div>

						@endif

						@foreach($errors->get('email') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="email" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="mail@hostlog.in" value="{{{Input::old('email')}}}" required></input>
							</div>
						</div>

						@foreach($errors->get('password') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{{Input::old('password')}}}" required></input>
							</div>
						</div>

						@if($page == 'Register')

						@foreach($errors->get('password_confirmation') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation" required></input>
							</div>
						</div>

						@foreach($errors->get('encryption_token') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="encryption_token" class="col-sm-3 control-label">Encryption Token</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input class="form-control" id="encryption_token" name="encryption_token" placeholder="Click Set To Create One" value="{{{Input::old('encryption_token')}}}" readonly required>
									<span class="input-group-btn">
										<button id="encbutton" class="btn btn-default" type="button">Set</button>
									</span>
								</div>
							</div>
						</div>

						@endif

						<div class="text-center hidden">
							<label class="checkbox-inline">
							  <input type="radio" id="login" value="login" name="type" @if($page == 'Login')checked@endif> Existing User
							</label>
							<label class="checkbox-inline">
							  <input type="radio" id="register" value="register" name="type" @if($page == 'Register')checked@endif> New User
							</label>
						</div>
						<div class="text-center">
							<br/><button class="btn btn-default" type="submit">Submit</button>
							@if($page == 'Login')
							<a href="{{route('forgotpassword')}}" class="btn btn-info">Forgot Password</a>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop