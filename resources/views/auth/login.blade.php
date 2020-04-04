@extends('layouts.app')

@section('content')
	
	<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_menu.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-5 offset-md-3">
					{{ Form::open(array('url' => route('login'), 'class' => '')) }}
						<img class="pb-4 d-block d-sm-none" src="{{ asset('img/logo_menu.png') }}" />
						<h1>{{ __('Cockpit login') }}</h1>
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
							{{ Form::submit(__('Login'), array('class' => 'btn btn-sm btn-dark btn-block'))}}
						</div>		
					{{ Form::close() }}
					@if (Route::has('password.request'))
	                    <p><a title="{{ __('receive a password reset link') }}" href="{{ route('password.request') }}">
	                        {{ __('Forgot your password?') }}</a>
	                    </p>
					@endif
					@if (Route::has('register'))
                    	<p>
                        	<a title="{{ __('register to Cockphit') }}" href="{{ route('register') }}">{{ __('Register new account') }}</a>
						</p>
                    @endif
				</div>
			</div>		
		</div>		
	</div>	
	
@endsection
