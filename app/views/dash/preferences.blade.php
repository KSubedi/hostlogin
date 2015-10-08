@extends('layouts.base')
@section('title')
User Preferences
@stop

@section('body')

<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('dashboard')}}">Dashboard</a></li>
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

					<form class="form-horizontal" role="form" action="{{ route('preferencessubmit') }}" method="post">
						{{ Form::token() }}

						@foreach($errors->get('firstname') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">First Name</label>
							<div class="col-sm-9">
								<input class="form-control" id="firstname" name="firstname" placeholder="First Name" value="{{{Auth::user()->firstname}}}" required></input>
							</div>
						</div>

						@foreach($errors->get('lastname') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="lastname" class="col-sm-3 control-label">Last Name</label>
							<div class="col-sm-9">
								<input class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="{{{Auth::user()->lastname}}}"></input>
							</div>
						</div>

						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<h4>{{{Auth::user()->email}}}</h4>
							</div>
						</div>

						@foreach($errors->get('password') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach

						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Leave Empty If You Do Not Want To Change!"></input>
							</div>

						</div>

						@foreach($errors->get('password_confirmation') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation"></input>
							</div>
						</div>

						<div class="text-center">
							<br/><button class="btn btn-default" type="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop