<!doctype html>
<html lang="en">
	<head>
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		
		<link href="{{ asset('css/ubot.css') }}" rel="stylesheet">

		<title>@yield('title')</title>
		
		@yield('top-scripts')
		
		<style>
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
	            border-right: 2px solid;
                font-size: 56px;
                padding: 0 15px 0 15px;
            }

            .message {
                font-size: 18px;
                padding: 10px;
            }
            .link {
                font-size: 56px;
                padding: 15px 0 15px 25px;
            }
        </style>
  	</head>
  	<body>
	  	<div class="container-fluid">
	  		
	  		<div class="row login">
				<div class="col-md-6 align-items-center h-100 d-inline-block bg-nero text-center align-middle">
					<img class="logo-sx d-none d-sm-inline-block" src="{{ asset('img/logo_login.png') }}" />
				</div>
				<div class="col-md-6 align-items-center h-100 d-inline-block">
					<div class="flex-center full-height">
			            <div class="code" style="margin-top: 50vh;">
			                @yield('code')
			            </div>
			
			            <div class="message" style="margin-top: 50vh;">
			                @yield('message')
			            </div>
			            <div class="link" style="margin-top: 50vh;">
			            	<a class="lin" href="{{ url('/')}}" title="{{ __('back to home') }}"><span class="material-icons">clear</span></a>
			            </div>
			        </div>		
				</div>		
			</div>	
  			
  		</div>
  		 
    	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		
		@yield('bottom-scripts')
  	</body>
</html>



