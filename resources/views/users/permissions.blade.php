

@extends('layouts.app')

@section('content')

<div class="row m-5">
<div class="col-md-12">
		<h1> {{ __('Edit personal permission for :name', ['name' => $user->name])}}</h1>
		
		<p class="text-right">
	    	<a role="button" href="{{ url()->previous() }}" class="btn btn-dark btn-sm">{{ __('Back')}}</a>
		</p>
		
		<div class="mb-5">
			<div class="form-check form-check-inline">
				<label>
					<input type="checkbox" disabled="disabled" checked="checked">
					{{ __('Inherit from user role') }}
				</label>
			</div>
			<div class="form-check form-check-inline">
				<label>
					<input type="checkbox" checked="checked">
					{{ __('Personal permission') }}
				</label>
			</div>		
		</div>	
		
		{{ Form::open(['route' => ['users.syncpermissions', $user->id], 'method' => 'put']) }}
		<?php 
			$pra = array();
			foreach($permissions_from_role as $pr) {
				array_push($pra, $pr->id);
			}
		?>
		
		<div class="col-divid-3">
		    @foreach ($permissions as $t)
	        	<?php 
		        	
		        	$check = ($user->hasPermissionTo($t->name)) ? true : false;
		        	
		        	$disabled =  (in_array($t->id, $pra)) ? 'disabled' : false;
		        	$color =  (in_array($t->id, $pra)) ? 'custom-control-dark' : '';
		        ?>
		        	<div class="form-check">
						<label>
							{{ Form::checkbox('permissions[]',  $t->name, $check, ['disabled' => $disabled, 'class' => ''] ) }}
							{{ Form::label($t->name) }}
						</label>
	        		</div>
		       
			@endforeach
		</div>	    
		
		
		{{ Form::submit(__('Save'), array('class' => 'btn btn-dark btn-sm btn-block')) }}
	    
		{{ Form::close() }}
			
		
</div>
</div>
@endsection