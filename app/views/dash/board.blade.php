@extends('dash.base')
@section('title')
DashBoard
@stop

@section('meta')
{{Core::showScript('md5.js')}}
{{Core::showScript('sha3.js')}}
{{Core::showScript('encryption.js')}}
{{Core::showScript('board.js')}}
@stop

@section('bc')
<ol class="breadcrumb">
  <li><a href="{{route('home')}}">Home</a></li>
  <li class="active">DashBoard</li>
</ol>
@if(Session::has('message'))
<span class="hidden firstmsg" data-msg="{{ Session::get('message') }}"></span>
@endif
<div id="message" class="alert alert-info text-center" hidden></div>
@stop

@section('body')
<div class="hidden" id="enctoken">{{Auth::user()->encryptiontoken}}</div>
<div id="passphrasebox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="mModalLabel">Encryption Passphrase</h4>
		</div>

		<div class="modal-body">
			<p>Please enter the passphrase that was used to encrypt your passwords.</p>
			<input type="password" id="encpassphrase" class="form-control">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button id="decryptbutton" type="button" class="btn btn-primary">Decrypt Passwords</button>
		</div>
    </div>
  </div>
</div>

<div id="deletebox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mModalLabelDelete" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="mModalLabel">Delete Server</h4>
		</div>
		<form action="{{route('deleteserversubmit')}}" method="post">
		{{ Form::token() }}
		<div class="modal-body">
			<p>Are you sure you want to delete the server?</p>
			<input type="hidden" id="delete" name="delete" value="" class="form-control">
		</div>
		<div class="modal-footer">
			<button id="deleteserverbutton" type="submit" class="btn btn-danger pull-left">Yes</button>
			<button type="button" class="btn btn-default pull-right" data-dismiss="modal">No</button>
		</div>
		</form>
    </div>
  </div>
</div>


<div class="row">
	@if(!isset($servers[0]))
	<div class="alert alert-info text-center">You do not have any servers yet. Please add servers using "Add Server" button.</div>
	@endif
	<?php $counter = 0; ?>
	@foreach($servers as $server)
	<?php
		$colors = array('blue' => 'info',
						'red' => 'danger',
						'green' => 'success',
						'yellow' => 'warning');
		$color = 'default';
		if(isset($colors[$server->color])) $color = $colors[$server->color];
	?>
	<div class="col-md-4 pcontainer">
		<div class="panel panel-{{$color}}">
			<div class="panel-heading text-center">
				<a class="collapselink" data-toggle="collapse" href="#panel-{{$counter}}"><h3>{{{$server->name}}}</h3></a>
			</div>
			<div class="panel-body table-responsive collapse" id="panel-{{$counter}}">
			<?php $counter++; ?>
				<div class="text-center">
					<div class="btn-group dash-buttons">
						<?php $serverenc = Crypt::encrypt($server->id . Core::getSalt()); ?>
						<a href="{{route('editserver', $serverenc)}}" class="btn btn-success btn-xs">Edit</a>
						<a href="#" data-server="{{$serverenc}}" class="delbtn btn btn-danger btn-xs">Delete</a>
					</div>
				</div>

				<table class="table table-striped">
					@if($server->type != "")
					<tr>
						<td><strong>Type</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->type}}}"/></td>
					</tr>
					@endif

					@if($server->provider != "")
					<tr>
						<td><strong>Provider</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->provider}}}"/></td>
					</tr>
					@endif

					@if($server->location != "")
					<tr>
						<td><strong>Location</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->location}}}"/></td>
					</tr>
					@endif

					@if($server->url != "")
					<tr>
						<td><strong>URL / Hostname</strong></td>
						<td><a target="_blank" href="{{{$server->url}}}" class="btn btn-primary btn-xs">{{{Core::sterm($server->url)}}}</a></td>
					</tr>
					@endif

					@if($server->panel != "")
					<tr>
						<td><strong>Panel</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->panel}}}"/></td>
					</tr>
					@endif

					@if($server->panelurl != "")
					<tr>
						<td><strong>Panel URL</strong></td>
						<td><a target="_blank" href="{{{$server->panelurl}}}" class="btn btn-default btn-xs">{{{Core::sterm($server->panelurl)}}}</a></td>
					</tr>
					@endif

					@if($server->panellogin != "")
					<tr>
						<td><strong>Panel Login</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->panellogin}}}"/></td>
					</tr>
					@endif

					@if($server->panelpassword != "")
					<tr>
						<td><strong>Panel Password</strong></td>
						<td><input class="encrypted aselect form-control input-xs" data-enc="{{{$server->panelpassword}}}" value="Encrypted"/></td>
					</tr>
					@endif

					@if($server->billingurl != "")
					<tr>
						<td><strong>Billing URL</strong></td>
						<td><a target="_blank" href="{{{$server->billingurl}}}" class="btn btn-info btn-xs">{{{Core::sterm($server->billingurl)}}}</a></td>
					</tr>
					@endif

					@if($server->billinglogin != "")
					<tr>
						<td><strong>Billing Login</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->billinglogin}}}"/></td>
					</tr>
					@endif

					@if($server->billingpassword != "")
					<tr>
						<td><strong>Billing Password</strong></td>
						<td><input class="encrypted aselect form-control input-xs" data-enc="{{{$server->billingpassword}}}" value="Encrypted"/></td>
					</tr>
					@endif

					<?php
					$ips = $server->ip;
					$ips = explode(',', $ips); //Explode the ip's stored as string
					foreach ($ips as $key => $ip) {
						if(trim($ip) == '') unset($ips[$key]); //If ips are empty, drop them from array
					}
					$ips = array_values($ips); //Reindex array
					?>

					@if(isset($ips['0']))
					<tr>
						<td><strong>IP Addresses</strong></td>
						<td>
							@foreach($ips as $ip)
							<span class="badge"><input class="aselect form-control input-xs" value="{{{trim($ip)}}}"/></span><br>
							@endforeach
						</td>
					</tr>
					@endif

					@if($server->storage != "")
					<tr>
						<td><strong>Storage</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->storage}}}"/></td>
					</tr>
					@endif

					@if($server->ram != "")
					<tr>
						<td><strong>Ram</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->ram}}}"/></td>
					</tr>
					@endif

					@if($server->bandwidth != "")
					<tr>
						<td><strong>Bandwidth</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->bandwidth}}}"/></td>
					</tr>
					@endif

					@if($server->cost != "")
					<tr>
						<td><strong>Cost</strong></td>
						<td><input class="aselect form-control input-xs" value="{{{$server->cost}}}"/></td>
					</tr>
					@endif

					@if($server->notes != "")
					<tr>
						<td><strong>Notes</strong></td>
						<td><textarea rows="5" class="aselect form-control textarea-cs">{{{$server->notes}}}</textarea></td>
					</tr>
					@endif

				</table>
			</div>
		</div>
	</div>
	@endforeach
</div>
@stop
