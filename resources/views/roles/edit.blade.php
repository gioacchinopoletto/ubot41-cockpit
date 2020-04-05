{{-- \resources\views\roles\edit.blade.php --}}
@extends('layouts.app-desk')

@section('content')

<div class="card">
<div class="row">

<div class="col-md-12">

    <h4 class="card-title"><i class="fa fa-key"></i> {{ __('messages.edit_single_role', ['name' => $role->name])}}</h4>
    <div class="card-body">
    <p class="text-right">
	    <a role="button" href="{{ route('roles.index') }}" class="btn btn-info btn-sm">{{ __('messages.roles')}}</a>
    </p>

    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', __('messages.role')) }}
        {{ Form::text('name', null, array('class' => 'form-control form-control-sm')) }}
    </div>

    <h3>{{ __('messages.permissions') }}</h3>
    <div class="col-divid-3">
        @foreach ($permissions as $permission)
        
	        <div class='form-group'>
		    	<div class="custom-controls-stacked custom-control custom-checkbox">
					{{Form::checkbox('permissions[]',  $permission->id, $role->permissions, ['class' => 'custom-control-input'] ) }}
					<label class="custom-control-label">
						{{ ucfirst($permission->name) }}
					</label>
		    	</div>
		    </div>
        
		@endforeach
    </div>
    {{ Form::submit(__('messages.button_save'), array('class' => 'btn btn-info btn-sm btn-block')) }}

    {{ Form::close() }}    
</div>
</div>
</div>
</div>

@endsection