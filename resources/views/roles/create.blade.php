@extends('layouts.app')

@section('content')

<div class="row m-5">
	<div class="col-md-12">
    	<h1>{{ __('Add role')}}</h1>


    <p class="text-right">
	    <a role="button" href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">{{ __('Roles')}}</a>
    </p>

    {{ Form::open(array('url' => 'roles')) }}

    <div class="form-group">
        {{ Form::label('name', __('Role')) }}
        {{ Form::text('name', null, array('class' => 'form-control form-control-sm')) }}
        @error('name')
			<div class="alert alert-danger">{{ $message }}</div>
		@enderror
    </div>

    <h1 class="mt-5 mb-3">{{ __('Add permission to role') }}</h1>
	
	<div class="col-divid-3">
	    	@foreach ($permissions as $permission)
				<div class="form-check">
					<label>
						{{ Form::checkbox('permissions[]',  $permission->id ) }}
						{{ Form::label($permission->name, ucfirst($permission->name)) }}
					</label>
        		</div>			
			@endforeach	
    </div>
    @error('permissions')
		<div class="alert alert-danger">{{ $message }}</div>
	@enderror
    
    {{ Form::submit(__('Save'), array('class' => 'btn btn-dark btn-sm btn-block')) }}

    {{ Form::close() }}
   
</div>
</div>
@endsection