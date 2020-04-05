@extends('layouts.app')

@section('content')

<div class="row m-5">
<div class="col-md-12">
    <h1>{{ __('Users')}}</h1> 
	
	<p class="text-right">    
	    <a role="button" href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">{{ __('Roles')}}</a>
		<a role="button" href="{{ route('permissions.index') }}" class="btn btn-dark btn-sm">{{ __('Permissions')}}</a>
		@can('Add user')
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
                    @can('Add single user permission')
                    <th>{{ __('Personal permissions')}}</th>
                    @endcan
                    <th class="text-center"><span class="material-icons">reorder</span></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                
                <tr>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    <td class="align-middle">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="align-middle">{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                    @can('Add single user permission')
					<td class="align-middle">
					    <a role="button" href="{{ route('users.personalpermissions', $user->id) }}" class="btn btn-outline-info btn-sm">{{ count($user->getDirectPermissions()) }}</a>
					</td>
				    @endcan
                    <td class="align-middle text-center">
	                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
	                    <div class="btn-group btn-group-sm" role="group" aria-label="">
						  @can('View user')
						  <a role="button" href="{{ route('users.show', $user->id) }}" class="btn btn-outline-info"><i class="fa fa-folder-open-o"aria-hidden="true"></i></a>
						  @endcan
						  @can('Edit user')
						  <a role="button" href="{{ route('users.edit', $user->id) }}" class="btn btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
						  @endcan
						  @can('Change user state')
							  @if($user->active == 1)
							  	<a role="button" href="{{ route('users.changestate', [$user->id, 0]) }}"class="btn btn-info">{{ __('messages.button_deactivate')}}</a>	
							  @else
							  	<a role="button" href="{{ route('users.changestate', [$user->id, 1]) }}" class="btn btn-info">{{ __('messages.button_activate')}}</a>
							  @endif
						  @endcan
						  @can('Delete user')
							{{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
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