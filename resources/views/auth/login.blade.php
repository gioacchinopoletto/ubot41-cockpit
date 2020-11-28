@extends('layouts.app')

@section('content')

	<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-6 offset-md-3">
					{{ Form::open(array('url' => route('login'), 'class' => '')) }}
						<img class="pb-4 d-block d-sm-none m-auto" src="{{ asset('img/logo_login.png') }}" />
						<h1>{{ __('Cockpit login') }}</h1>
						@if (session('message'))
						<div class="alert alert-{{ session('message.type')}}">{{ session('message.text')}}</div>
						@endif
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
					<p class="text-center">
					@if (Route::has('password.request'))
	        	<a class="lin spaced" title="{{ __('receive a password reset link') }}" href="{{ route('password.request') }}">
	              {{ __('Forgot your password?') }}
						</a>
					@endif
					@if (Route::has('register'))
            <a class="lin spaced" title="{{ __('register to Cockpit') }}" href="{{ route('register') }}">{{ __('Register new account') }}</a>
        	@endif
					</p>
					@if(config('cockpit.show_socialite') == true)
					<p class="text-center">
						<a class="lin" href="{{ route('login.facebook') }}">{{ __('Login with Facebook') }}</a>
					</p>
					@endif
					@if(session('applocale') == 'it')
      				<p class="text-muted text-center">Do you speak <a class="lin" href="{{ url('/lang/en') }}">english</a>?</p>
          @else <!-- if session is null or not set we have EN as default language -->
          		<p class="text-muted text-center">Parli <a class="lin" href="{{ url('/lang/it') }}">italiano</a>?</p>
          @endif
				</div>
			</div>
		</div>
	</div>

@endsection
