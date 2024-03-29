<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

		@yield('bottom-scripts')
  	</body>
</html>
