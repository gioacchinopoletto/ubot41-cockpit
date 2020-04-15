@extends('layouts.app')

@section('content')

<div class="row m-5">
	<div class="col-md-12">

    <h1 class="mb-5"> 
	    <img class="rounded-circle mr-1" src="https://www.gravatar.com/avatar/{{$hashUser}}?r=g&d=identicon&s=30">
	    {!! $user->name !!}
    </h1>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class' => '')) }}
	
		<div class="row">
			<div class="form-group col-md-10">
		       	{{ Form::label('name', __('Fullname')) }}
		        {{ Form::text('name', null, array('class' => 'form-control form-control-sm')) }}
		        @error('name')
					<div class="alert alert-danger">{{ $message }}</div>
				@enderror
		    </div>
			<div class="form-check col-md-1">
		       	{{ Form::radio('locale', 'it', $user->locale, array('class' => 'form-check-input')) }}
		       	{{ Form::label('locale', __('Italian'), array('class' => 'form-check-label')) }}
			</div>
			<div class="form-check col-md-1">   	
		        {{ Form::radio('locale', 'en', $user->locale, array('class' => 'form-check-input')) }}
		        {{ Form::label('locale', __('English'), array('class' => 'form-check-label')) }}
		    </div>
		    @error('locale')
					<div class="alert alert-danger">{{ $message }}</div>
			@enderror
		</div>
		
		<div class="form-group">
	       	{{ Form::label('email', __('Email')) }}
	        {{ Form::text('email', null, array('class' => 'form-control form-control-sm')) }}
	        @error('email')
				<div class="alert alert-danger">{{ $message }}</div>
			@enderror
	    </div>
	
		<div class="form-group">
	       	{{ Form::label('password', __('Password') ) }}
			{{ Form::password('password', array('class' => 'form-control form-control-sm')) }}
			<small class="form-text text-muted">
				{{ __('Type password only if you want to change it') }}
			</small>
	        @error('password')
				<div class="alert alert-danger">{{ $message }}</div>
			@enderror
	    </div>
	    
	    <div class="form-group">
	       	{{ Form::label('password_confirmation', __('Password confirmation') ) }}
			{{ Form::password('password_confirmation', array('class' => 'form-control form-control-sm')) }}
			@error('password_confirmation')
				<div class="alert alert-danger">{{ $message }}</div>
			@enderror
	    </div>
				
		<p>{!! __("You can change your avatar setting your email with <a href='https://en.gravatar.com' target='_blank'>Gravatar</a>.") !!}</p>
		
	{{ Form::submit(__('Save'), array('class' => 'btn btn-dark btn-sm btn-block')) }}

    {{ Form::close() }}	
	
	    	
</div>
</div>

@endsection