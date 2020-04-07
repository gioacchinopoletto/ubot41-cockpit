@extends('layouts.app')

@section('content')
<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-5 offset-md-3">
					<form method="POST" action="{{ route('password.update') }}">
						@csrf
                        <input type="hidden" name="token" value="{{ $token }}">
						
						<img class="pb-4 d-block d-sm-none" src="{{ asset('img/logo_login.png') }}" />
						<h1>{{ __('Reset Password') }}</h1>
               
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
							{{ Form::submit(__('Reset password'), array('class' => 'btn btn-sm btn-dark btn-block'))}}
						</div>
                
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
