@extends('layouts.app')

@section('content')

<div class="row m-5">
<div class="col-md-12">
    <h1>{{ __('Roles')}}</h1>
    
    @if (session('message'))
		<div class="alert alert-{{ session('message.type')}} alert-dismissible fade show" role="alert">
			{!! session('message.text')!!}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif 

    <p class="text-right">  
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-dark btn-sm">{{ __('Users')}}</a>
		<a role="button" href="{{ route('permissions.index') }}" class="btn btn-dark btn-sm">{{ __('Permissions')}}</a>
		@can('Role - add')
		<a role="button" href="{{ route('roles.create') }}" class="btn btn-dark btn-sm">{{ __('Add role')}}</a>
		@endcan
    </p>
        

    <div class="table-responsive-md">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Permissions') }}</th>
                    <th class="text-center"><i class="fa fa-th"></i></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
                    <td class="text-center">
	                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
	                    <div class="btn-group btn-group-sm" role="group" aria-label="">
							
							<a role="button" href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-dark btn-sm"><span class="material-icons">folder_open</span></a>
							@can('Role - delete')
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
    
</div>
</div>
@endsection