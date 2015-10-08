@extends('dash.base')
@section('title')
{{$page}}
@stop

@section('bc')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li><a href="{{route('dashboard')}}">Dashboard</a></li>
  <li class="active">{{$page}}</li>
</ol>
@stop

@section('meta')
{{Core::showScript('md5.js')}}
{{Core::showScript('sha3.js')}}
{{Core::showScript('encryption.js')}}
{{Core::showScript('addserver.js')}}
@stop

@section('body')
<div class="hidden" id="enctoken">{{Auth::user()->encryptiontoken}}</div>
<div id="passphrasebox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="mModalLabel">Encrypt Password</h4>
		</div>

		<div class="modal-body">
			<p>Enter the password.</p>
			<input type="password" id="encpassword" class="form-control">
			<br>
			<p>Please enter the passphrase that you use to encrypt your passwords.</p>
			<input type="password" id="encpassphrase" class="form-control">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button id="encryptbuttonbox" type="button" class="btn btn-primary">Set Password</button>
		</div>
    </div>
  </div>
</div>



<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading"><h4>{{$page}}</h4></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="{{ route('addserversubmit') }}" method="post">
					<div id="message" class="alert alert-info text-center">All information other than name are optional.</div>
					{{ Form::token() }}
					<?php
					if(stristr($page, 'edit')) echo '<input type="hidden" name="isedit" value="' . $servid . '">';
					?>
					@foreach($errors->get('name') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input class="form-control" id="name" name="name" placeholder="Server Name" value="{{{Input::old('name')}}}" required></input>
						</div>
					</div>

					@foreach($errors->get('type') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="type" class="col-sm-3 control-label">Server Type</label>
						<div class="col-sm-9">
							<select class="form-control" id="type" name="type" data-selected="{{{Input::old('type')}}}">
								<option value="Virtual Machine">Virtual Machine</option>
								<option value="Cloud Server">Cloud Server</option>
								<option value="Dedicated Server">Dedicated Server</option>
								<option value="Shared Hosting">Shared Hosting</option>
								<option value="Reseller Hosting">Reseller Hosting</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>

					@foreach($errors->get('provider') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="provider" class="col-sm-3 control-label">Provider</label>
						<div class="col-sm-9">
							<input class="form-control" id="provider" name="provider" placeholder="Server Provider" value="{{{Input::old('provider')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('url') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="url" class="col-sm-3 control-label">URL / Hostname</label>
						<div class="col-sm-9">
							<input class="form-control" id="url" name="url" placeholder="http://example.com" value="{{{Input::old('url')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('location') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="location" class="col-sm-3 control-label">Location</label>
						<div class="col-sm-9">
							<input class="form-control" id="location" name="location" placeholder="Frankfurt, Germany" value="{{{Input::old('location')}}}"></input>
						</div>
					</div>

					<hr>

					@foreach($errors->get('panel') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="panel" class="col-sm-3 control-label">Panel Type</label>
						<div class="col-sm-9">
							<select class="form-control" id="panel" name="panel" data-selected="{{{Input::old('panel')}}}">
								<option value="None">None</option>
								<option value="cPanel">cPanel</option>
								<option value="Plesk">Plesk</option>
								<option value="DirectAdmin">DirectAdmin</option>
								<option value="Webuzo">Webuzo</option>
								<option value="Kloxo">Kloxo</option>
								<option value="ZPanel">ZPanel</option>
								<option value="VestaCP">VestaCP</option>
								<option value="ISPCP">ISPCP</option>
								<option value="SolusVM">SolusVM</option>
								<option value="Virtualizor">Virtualizor</option>
								<option value="Feathur">Feathur</option>
								<option value="HyperVM">HyperVM</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>

					<div  id="panelodiv">
						@foreach($errors->get('panelo') as $message)
							<div class="alert alert-danger">{{ $message }}</div>
						@endforeach
						<div class="form-group">
							<label for="panelo" class="col-sm-3 control-label">Other Panel</label>
							<div class="col-sm-9">
								<input class="form-control" id="panelo" name="panelo" placeholder="Other Panel" value="{{{Input::old('panelo')}}}"></input>
							</div>
						</div>
					</div>

					@foreach($errors->get('panelurl') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="panelurl" class="col-sm-3 control-label">Panel URL</label>
						<div class="col-sm-9">
							<input class="form-control" id="panelurl" name="panelurl" placeholder="http://cpanel.example.com:2082/" value="{{{Input::old('panelurl')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('panellogin') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="panellogin" class="col-sm-3 control-label">Panel Login</label>
						<div class="col-sm-9">
							<input class="form-control" id="panellogin" name="panellogin" placeholder="mail@hostlog.in" value="{{{Input::old('panellogin')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('panelpassword') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="encryption_token" class="col-sm-3 control-label">Panel Password (Encrypted)</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input class="form-control" id="panelpassword" name="panelpassword" placeholder="Click Set To Create One" value="{{{Input::old('panelpassword')}}}" readonly>
								<span class="input-group-btn">
									<button class="setbutton btn btn-default" type="button">Set</button>
								</span>
							</div>
						</div>
					</div>

					<hr>

					@foreach($errors->get('billingurl') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="billingurl" class="col-sm-3 control-label">Billing Panel URL</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input class="form-control" id="billingurl" name="billingurl" placeholder="http://billing.example.com/" value="{{{Input::old('billingurl')}}}"></input>
								<span class="input-group-addon">
									<label><input type="checkbox" name="iswhmcs" id="iswhmcs" @if(Input::old('iswhmcs') == 1)checked@endif> WHMCS</label>
								</span>
							</div>
						</div>
					</div>

					@foreach($errors->get('billinglogin') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="billinglogin" class="col-sm-3 control-label">Billing Panel Login</label>
						<div class="col-sm-9">
							<input class="form-control" id="billinglogin" name="billinglogin" placeholder="mail@hostlog.in" value="{{{Input::old('billinglogin')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('billingpassword') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="encryption_token" class="col-sm-3 control-label">Billing Password (Encrypted)</label>
						<div class="col-sm-9">
							<div class="input-group">
								<input class="form-control" id="billingpassword" name="billingpassword" placeholder="Click Set To Create One" value="{{{Input::old('billingpassword')}}}" readonly>
								<span class="input-group-btn">
									<button class="setbutton btn btn-default" type="button">Set</button>
								</span>
							</div>
						</div>
					</div>

					<hr>

					@foreach($errors->get('ip') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="ip" class="col-sm-3 control-label">IP Addresses</label>
						<div class="col-sm-9">
							<textarea rows="3" class="form-control" id="ip" name="ip" placeholder="192.168.1.1, 127.0.0.1">{{{Input::old('ip')}}}</textarea>
						</div>
					</div>

					@foreach($errors->get('storage') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="storage" class="col-sm-3 control-label">Storage</label>
						<div class="col-sm-9">
							<input class="form-control" id="storage" name="storage" placeholder="100 GB" value="{{{Input::old('storage')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('ram') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="ram" class="col-sm-3 control-label">RAM</label>
						<div class="col-sm-9">
							<input class="form-control" id="ram" name="ram" placeholder="16 GB" value="{{{Input::old('ram')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('bandwidth') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="bandwidth" class="col-sm-3 control-label">Bandwidth</label>
						<div class="col-sm-9">
							<input class="form-control" id="bandwidth" name="bandwidth" placeholder="2 TB" value="{{{Input::old('bandwidth')}}}"></input>
						</div>
					</div>

					<hr>

					@foreach($errors->get('color') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="color" class="col-sm-3 control-label">Display Color</label>
						<div class="col-sm-9">
							<select class="form-control" id="color" name="color" data-selected="{{{Input::old('color')}}}">
								<option value="default">Default</option>
								<option value="blue">Blue</option>
								<option value="green">Green</option>
								<option value="red">Red</option>
								<option value="yellow">Yellow</option>
							</select>
						</div>
					</div>

					@foreach($errors->get('cost') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="cost" class="col-sm-3 control-label">Cost</label>
						<div class="col-sm-9">
							<input class="form-control" id="cost" name="cost" placeholder="$20 Per Month" value="{{{Input::old('cost')}}}"></input>
						</div>
					</div>

					@foreach($errors->get('notes') as $message)
						<div class="alert alert-danger">{{ $message }}</div>
					@endforeach
					<div class="form-group">
						<label for="notes" class="col-sm-3 control-label">Notes</label>
						<div class="col-sm-9">
							<textarea rows="3" class="form-control" id="notes" name="notes" placeholder="Some Notes...">{{{Input::old('notes')}}}</textarea>
						</div>
					</div>

					<div class="text-center"><button id="submitbutton" class="btn btn-info" type="submit">Submit</button></div>

				</form>
			</div>
		</div>
	</div>
</div>
@stop