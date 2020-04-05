@extends('layouts.app')

@section('content')

	<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-5 offset-md-3">
					{{ Form::open(array('url' => route('register'), 'class' => '')) }}
						<img class="pb-4 d-block d-sm-none" src="{{ asset('img/logo_login.png') }}" />
						<h1>{{ __('Cockpit registration') }}</h1>
						<div class="form-group">
							{{ Form::label('name', __('Fullname') ) }}
							{{ Form::text('name', null, array('class' => 'form-control form-control-sm')) }}
							@error('name')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror	
						</div>
						<div class="form-group">
							{{ Form::label('email', __('Email') ) }}
							{{ Form::text('email', null, array('class' => 'form-control form-control-sm')) }}
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
						<div class="form-group">
							{{ Form::submit(__('Register'), array('class' => 'btn btn-sm btn-dark btn-block'))}}
						</div>
					{{ Form::close() }}
					<p>
                        <a class="lin" title="{{ __('login to Cockphit') }}" href="{{ route('login') }}">{{ __('Have an account?') }}</a>
					</p>
                    
				</div>
			</div>
		</div>
	</div>	

@endsection
