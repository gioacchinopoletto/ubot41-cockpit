@extends('layouts.app')

@section('content')

<div class="row m-5">
<div class="col-md-12">
    <h1>{{ __('Add permission')}}</h1>
    
    <p class="text-right">
	    <a role="button" href="{{ route('permissions.index') }}" class="btn btn-dark btn-sm">{{ __('Permissions')}}</a>
    </p>

    {{ Form::open(array('url' => 'permissions')) }}

    <div class="form-group">
       	{{ Form::label('name', __('Permission (key)')) }}
        {{ Form::text('name', '', array('class' => 'form-control form-control-sm')) }}
        @error('name')
			<div class="alert alert-danger">{{ $message }}</div>
		@enderror
    </div>
    
    
    @if(!$roles->isEmpty())
        <h1 class="mt-5">{{ __('Add permission to role') }}</h1>
		
		<div class='form-group'>
        @foreach ($roles as $role) 
        	<div class="form-check form-check-inline">
				<label>
				{{ Form::checkbox('roles[]',  $role->id ) }}
				{{ Form::label($role->name, ucfirst($role->name)) }}
				</label>
        	</div>
        @endforeach
		</div>
    @endif
    
    {{ Form::submit(__('Save'), array('class' => 'btn btn-dark btn-sm btn-block')) }}

    {{ Form::close() }}

</div>
</div>
@endsection