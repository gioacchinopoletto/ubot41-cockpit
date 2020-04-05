@extends('layouts.app	')

@section('content')
<div class="row m-5">
<div class="col-md-12">
    <h1><i class="fa fa-key"></i> {{ __('Permissions')}}</h1>
	
	<p class="text-right">  
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-dark btn-sm">{{ __('Users')}}</a>
		<a role="button" href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">{{ __('Roles')}}</a>
		@can('Add permission')
		<a role="button" href="{{ route('permissions.create') }}" class="btn btn-dark btn-sm">{{ __('Add permission')}}</a>
		@endcan
    </p>
    <p>	
    {!! Form::open(['method'=>'GET','url'=>'permissions','class'=>'','role'=>'search'])  !!} 
		<div class="input-group mb-3">
		    <input type="text" value="{{ app('request')->input('search') }}" class="form-control form-control-sm" name="search" placeholder="{{ __('Search')}}">
		    <div class="input-group-append">
		        @if(app('request')->input('search'))
		        <a class="btn btn-sm" title="{{ __('messages.search_cancel')}}" href="{{ route('permissions.index') }}"><span class="material-icons">backspace</span></a>
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
                    <th class="text-center"><i class="fa fa-th"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td> 
                    <td class="text-center">
	                     {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
	                     <div class="btn-group btn-group-sm" role="group" aria-label="">
						 	@can('Edit permission')
						 	<a role="button" href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-info">{{ __('messages.button_edit')}}</a>
						 	@endcan

		                    @can('Delete permission')
									{!! Form::submit(__('messages.button_delete'), ['class' => 'btn btn-danger']) !!}
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