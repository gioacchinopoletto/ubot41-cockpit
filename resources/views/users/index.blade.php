@extends('layouts.app')

@section('content')

<div class="row m-5">
<div class="col-md-12">
    <h1>{{ __('Users')}}</h1>
    
    @if (session('message'))
		<div class="alert alert-{{ session('message.type')}} alert-dismissible fade show" role="alert">
			{!! session('message.text')!!}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif 
	
	<p class="text-right">    
	    <a role="button" href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">{{ __('Roles')}}</a>
		<a role="button" href="{{ route('permissions.index') }}" class="btn btn-dark btn-sm">{{ __('Permissions')}}</a>
		@can('User - add')
		<span class="button-separator d-xs-none d-inline-block"></span>
		<a role="button" href="{{ route('users.create') }}" class="btn btn-dark btn-sm">{{ __('Add user')}}</a>
		@endcan
	</p>
	<p>	
    {!! Form::open(['method'=>'GET','url'=>'users','class'=>'','role'=>'search'])  !!} 
		<div class="input-group mb-3">
		    <input type="text" value="{{ app('request')->input('search') }}" class="form-control form-control-sm" name="search" placeholder="{{ __('Search')}}">
		    <div class="input-group-append">
		        @if(app('request')->input('search'))
		        <a class="btn btn-sm" title="{{ __('Cancel')}}" href="{{ route('users.index') }}"><span class="material-icons">backspace</span></a>
		        @else
		        <button class="btn btn-sm" type="submit">
		            <span class="material-icons">search</span>
		        </button>
		        @endif
		        
		    </div>
		</div>
	{!! Form::close() !!}
	</p>
    
    <div class="table-responsive-md">
        <table class="table table-sm table-bordered">

            <thead class="thead-dark">
                <tr>
                    <th>{{ __('Fullname')}} <span class="material-icons">search</span></th>
                    <th>{{ __('Email')}} <span class="material-icons">search</span></th>
                    <th>{{ __('Member since')}}</th>
                    <th>{{ __('Roles')}}</th>
                    @can('User - add single permission')
                    <th>{{ __('Personal permissions')}}</th>
                    @endcan
                    <th class="text-center"><span class="material-icons">reorder</span></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                	@php
						$hashUser = md5( strtolower(trim($user->email)));
						$tr_class = ($user->active == 0) ? "table-danger" : "";
					@endphp
                <tr class="{{ $tr_class }}">
                    <td class="align-middle">
						<img class="rounded-circle mr-1" src="https://www.gravatar.com/avatar/{{$hashUser}}?r=g&d=identicon&s=30"> {{ $user->name }}
					</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="align-middle">{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                    @can('User - add single permission')
					<td class="align-middle">
					    <a role="button" href="{{ route('users.personalpermissions', $user->id) }}" class="btn btn-dark btn-sm">{{ count($user->getDirectPermissions()) }}</a>
					</td>
				    @endcan
                    <td class="align-middle text-center">
	                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
	                    <div class="btn-group btn-group-sm" role="group" aria-label="">
						  @can('User - view')
						  <a role="button" href="{{ route('users.show', $user->id) }}" class="btn btn-dark"><span class="material-icons">folder_open</span></a>
						  @endcan
						  @can('User - edit')
						  <a role="button" href="{{ route('users.edit', $user->id) }}" class="btn btn-dark"><span class="material-icons">create</span></a>
						  @endcan
						  @can('User - change state')
							  @if($user->active == 1)
							  	<a role="button" href="{{ route('users.changestate', [$user->id, 0]) }}"class="btn btn-dark"><span class="material-icons">toggle_off</span></a>	
							  @else
							  	<a role="button" href="{{ route('users.changestate', [$user->id, 1]) }}" class="btn btn-dark"><span class="material-icons">toggle_on</span></a>
							  @endif
						  @endcan
						  @can('User - delete')
						  		{{ Form::button('<span class="material-icons">delete</span>', ['class' => 'btn btn-dark', 'type' => 'submit']) }}
						  @endcan					  	  
	                    </div>
	                    {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    
    {!! $users->links() !!}
</div>
</div>

@endsection