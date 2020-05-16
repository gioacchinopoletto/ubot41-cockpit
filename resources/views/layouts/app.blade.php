<!doctype html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		
		<link href="{{ asset('css/ubot.css') }}" rel="stylesheet">

		<title>{{ config('app.name') }} | {{ config('cockpit.company_name') }}</title>
		
		@yield('top-scripts')
  	</head>
  	<body>
	  	@auth
	  		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/logo_menu.png') }}" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						@role('Admin')
						<li class="nav-item dropdown">
					    	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					          {{ __('Users')}}
					        </a>
					        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					          	<a class="dropdown-item" href="{{ route('users.create')}}">{{ __('Add user')}}</a>
							  	<div class="dropdown-divider"></div>
							  	<a class="dropdown-item" href="{{ route('users.index')}}">{{ __('Users')}}</a>
							  	<a class="dropdown-item" href="{{ route('roles.index')}}">{{ __('Roles')}}</a>
							  	<a class="dropdown-item" href="{{ route('permissions.index')}}">{{ __('Permissions')}}</a>
					        </div>
					    </li>
					    @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                            @if(config('cockpit.show_lang') == true)
                            <li class="nav-item dropdown">
                            	<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="material-icons" style="padding-top: 7px">translate</span></a>	
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									@if(session('applocale') == 'it')
										<a class="dropdown-item" href="{{ url('/lang/en') }}">English</a>
									@else <!-- if session is null or not set we have EN as default language -->
										<a class="dropdown-item" href="{{ url('/lang/it') }}">Italiano</a>
									@endif
								</div>
							</li>
							@endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	                                @php
										$hashUser = md5( strtolower(trim(Auth::user()->email)));
									@endphp
									<img class="rounded-circle mr-1" src="https://www.gravatar.com/avatar/{{$hashUser}}?r=g&d=wavatar&s=30">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.profile') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            
                    </ul>
                </div>
            </div>
        </nav>
	  	@endauth
  		<div class="container-fluid">
	  		
	  		@yield('content')
	  		
  		</div>
  		 
    	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		
		@yield('bottom-scripts')
  	</body>
</html>



