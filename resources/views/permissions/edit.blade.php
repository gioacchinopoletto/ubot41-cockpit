{{-- \resources\views\permissions\edit.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

<div class="col-md-11">

    <h3><i class="fa fa-key"></i> {{ __('messages.edit_permission', ['name' => $permission->name])}}</h3>
	<p class="text-right">
	    <a role="button" href="{{ route('permissions.index') }}" class="btn btn-info btn-sm">{{ __('messages.permissions')}}</a>
    </p>
	
	

    
    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', __('messages.permission')) }}
        {{ Form::text('name', null, array('class' => 'form-control form-control-sm')) }}
    </div>
    
    <h3>{{ __('messages.roles') }}</h3>
    <div class='form-group'>
        @foreach ($roles as $role)
        <div class="form-check form-check-inline">
			<label>
				{{Form::checkbox('roles[]',  $role->id, $permission->roles ) }}
				{{Form::label($role->name, ucfirst($role->name)) }}
			</label>
        </div>

    @endforeach
    </div>
    
    {{ Form::submit(__('messages.button_save'), array('class' => 'btn btn-info btn-sm btn-block')) }}

    {{ Form::close() }}

</div>
</div>

@endsection