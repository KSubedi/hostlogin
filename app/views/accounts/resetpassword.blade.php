@extends('layouts.base')
@section('title')
{{$page}}
@stop

@section('body')
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
					@if(Session::has('error'))
						<div class="alert alert-danger">{{ Session::get('error') }}</div>
					@endif

					@if(Session::has('status'))
						<div class="alert alert-info">{{ Session::get('status') }}</div>
					@endif

					<form class="form-horizontal" role="form" action="{{ action('RemindersController@postReset') }}" method="post">
						{{ Form::token() }}
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label for="email" class="col-sm-3 control-label">Email</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="mail@hostlog.in" required></input>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">New Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" required></input>
							</div>
						</div>

						<div class="form-group">
							<label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation" required></input>
							</div>
						</div>
						
						<div class="text-center">
							<br/><button class="btn btn-default" type="submit">Reset Password</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop