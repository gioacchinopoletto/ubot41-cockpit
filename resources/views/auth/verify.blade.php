@extends('layouts.app')

@section('content')
<div class="row login">
		<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
			<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
		</div>
		<div class="col-md-6 align-items-center h-100 d-inline-block">
			<div class="row">
				<div class="col-md-5 offset-md-3">
					<img class="pb-4 d-block d-sm-none" src="{{ asset('img/logo_login.png') }}" />
					<h1>{{ __('Verify your email address') }}</h1>
					@if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address') }}
                        </div>
                    @endif
					
					<p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p>{{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-dark p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    </p>
					
				</div>
			</div>
		</div>
</div>	

@endsection
