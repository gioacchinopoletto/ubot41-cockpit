@extends('layouts.app')

@section('content')
<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-5 offset-md-3">
					{{ Form::open(array('url' => route('password.email'), 'class' => '')) }}
						@csrf
						<img class="pb-4 d-block d-sm-none" src="{{ asset('img/logo_login.png') }}" />
						<h1>{{ __('Reset Password') }}</h1>
						@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
						@endif
						<div class="form-group">
							{{ Form::label('email', __('Email') ) }}
							{{ Form::text('email', null, array('class' => 'form-control form-control-sm')) }}
							@error('email')
							    <div class="alert alert-danger">{{ $message }}</div>
							@enderror	
						</div>
						<div class="form-group">
							{{ Form::submit(__('Send password reset link'), array('class' => 'btn btn-sm btn-dark btn-block'))}}
						</div>		
					{{ Form::close() }}
					<p><a class="lin" href="{{ route('login') }}">
	                        {{ __('Back to login') }}</a>
	                 </p>
				</div>
			</div>		
		</div>		
	</div>	
	
@endsection
