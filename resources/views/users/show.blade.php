@extends('layouts.app')

@section('content')

<div class="row m-5">
	<div class="col-md-12">

    <h1> 
	    <img class="rounded-circle mr-1" src="https://www.gravatar.com/avatar/{{$hashUser}}?r=g&d=identicon&s=30">
	    {!!  $user->name !!}
    </h1>

    <p class="text-right">
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-dark btn-sm">{{ __('Users')}}</a>
    </p>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class' => '')) }}
	
					<div class="form-group">
				       	{{ Form::label('name', __('Fullname')) }}
				        {{ Form::text('name', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
				    </div>
				
					<div class="form-group">
				       	{{ Form::label('email', __('Email')) }}
				        {{ Form::text('email', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
				    </div>
				
					<h1 class="mt-5 mb-3">{{ __('Roles') }}</h1>
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

    {{ Form::close() }}	
	
	    	
</div>
</div>

@endsection