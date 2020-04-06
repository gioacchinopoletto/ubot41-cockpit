@extends('layouts.app')

@section('content')

<div class="row m-5">
	<div class="col-md-12">
    	<h1>{{ __('Add user')}}</h1>
    
			    <p class="text-right">
				    <a role="button" href="{{ route('users.index') }}" class="btn btn-dark btn-sm">{{ __('Users')}}</a>
			    </p>
    
			    {{ Form::open(array('url' => 'users')) }}
				
					<div class="form-group">
				       	{{ Form::label('name', __('Fullname')) }}
				        {{ Form::text('name', '', array('class' => 'form-control form-control-sm')) }}
				        @error('name')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
				    </div>
				
					<div class="form-group">
				       	{{ Form::label('email', __('Email')) }}
				        {{ Form::text('email', '', array('class' => 'form-control form-control-sm')) }}
				        @error('email')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
				    </div>
				
					<div class="form-group">
				       	{{ Form::label('password', __('Password') ) }}
						{{ Form::password('password', array('class' => 'form-control form-control-sm')) }}
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
				
					<h1 class="mt-5 mb-3">{{ __('Add role to user') }}</h1>
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
				    @error('roles')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					
				
			    {{ Form::submit(__('Save'), array('class' => 'btn btn-dark btn-sm btn-block')) }}
				
			    {{ Form::close() }}
	</div>
</div>
@endsection