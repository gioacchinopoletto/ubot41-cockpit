@extends('layouts.app')

@section('content')

	<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block m-auto" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-6 offset-md-3">
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
					<p class="text-center">
          	<a class="lin" title="{{ __('login to Cockpit') }}" href="{{ route('login') }}">{{ __('Have an account?') }}</a>
					</p>
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
