{{-- \resources\views\users\permissions.blade.php --}}

@extends('layouts.app-desk')

@section('content')

<div class="card">
<div class="row justify-content-center">
	<div class="col-md-11">
		<h4 class="card-title"><i class="fa fa-user-plus"></i> {{ __('messages.edit_user_permissions', ['name' => $user->name])}}</h4>
		<div class="card-body">
		<p class="text-right">
	    	<a role="button" href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">{{ __('messages.button_back')}}</a>
		</p>
		
		<p>
			<small>
			<div class="form-check form-check-inline">
				<label>
					<input type="checkbox" disabled="disabled" checked="checked">
					{{ __('messages.inherit_from_role') }}
				</label>
			</div>
			<div class="form-check form-check-inline">
				<label>
					<input type="checkbox" checked="checked">
					{{ __('messages.personal_permission_active') }}
				</label>
			</div>
			</small>		
		</p>	
		
		{{ Form::open(['route' => ['users.syncpermissions', $user->id], 'method' => 'put']) }}
		<?php 
			$pra = array();
			foreach($permissions_from_role as $pr) {
				array_push($pra, $pr->id);
			}
		?>
		
		<div class="row">
			<div class="col-md-4">
					@php
						$conta = 0;
					@endphp
				    @foreach ($permissions as $t)
			        	<?php 
				        	
				        	$check = ($user->hasPermissionTo($t->name)) ? true : false;
				        	
				        	$disabled =  (in_array($t->id, $pra)) ? 'disabled' : false;
				        	$color =  (in_array($t->id, $pra)) ? 'custom-control-pink' : '';
				        	
							if($conta % 20 == 0 && $conta != 0)
							{
								echo "</div><div class='col-md-4'>";
							}
				        	$conta++;
				        ?>
				        	<div class="custom-controls-stacked custom-control custom-checkbox">
					        	{{Form::checkbox('permissions[]',  $t->name, $check, ['disabled' => $disabled, 'class' => 'custom-control-input'] ) }}
								<label class="custom-control-label {{ $color }}">    
				        		{{ ucfirst($t->name) }}
								</label>
				        	</div>
					@endforeach
			</div>
		</div>	    
		<br />
		{{ Form::submit(__('messages.button_save'), array('class' => 'btn btn-info btn-sm btn-block')) }}
	    
		{{ Form::close() }}
			
		</div>
	</div>
</div>
</div>
@endsection