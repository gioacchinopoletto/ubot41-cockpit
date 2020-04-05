@extends('layouts.app	')

@section('content')
<div class="row m-5">
<div class="col-md-12">
    <h1>{{ __('Permissions')}}</h1>
	
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
		<a role="button" href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">{{ __('Roles')}}</a>
		@can('Permission - add')
		<span class="button-separator d-xs-none d-inline-block"></span>
		<a role="button" href="{{ route('permissions.create') }}" class="btn btn-dark btn-sm">{{ __('Add permission')}}</a>
		@endcan
    </p>
    <p>	
    {!! Form::open(['method'=>'GET','url'=>'permissions','class'=>'','role'=>'search'])  !!} 
		<div class="input-group mb-3">
		    <input type="text" value="{{ app('request')->input('search') }}" class="form-control form-control-sm" name="search" placeholder="{{ __('Search')}}">
		    <div class="input-group-append">
		        @if(app('request')->input('search'))
		        <a class="btn btn-sm" title="{{ __('Cancel')}}" href="{{ route('permissions.index') }}"><span class="material-icons">backspace</span></a>
		        @else
		        <button class="btn btn-sm" type="submit">
		            <span class="material-icons">search</span>
		        </button>
		        @endif
		        
		    </div>
		</div>
	{!! Form::close() !!}
	</p>
    
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>{{ __('Permissions') }} <span class="material-icons">search</span></th>
                    <th class="text-center"><span class="material-icons">reorder</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td class="align-middle">{{ $permission->name }}</td> 
                    <td class="text-center class="align-middle"">
	                     {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
	                     <div class="btn-group btn-group-sm" role="group" aria-label="">
						 	@can('Permission - edit')
						 	<a role="button" href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-dark btn-sm"><span class="material-icons">create</span></a>
						 	@endcan

		                    @can('Permission - delete')
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

    {!! $permissions->links() !!}


</div>
</div>
@endsection