{{-- \resources\views\roles\index.blade.php --}}
@extends('layouts.app-desk')

@section('content')
<div class="card">
<div class="row">
<div class="col-md-12">
    <h4 class="card-title"><i class="fa fa-key"></i> {{ __('messages.roles')}}</h4>
    <div class="card-body">
    <p class="text-right">  
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-info btn-sm">{{ __('messages.users')}}</a>
		<a role="button" href="{{ route('permissions.index') }}" class="btn btn-info btn-sm">{{ __('messages.permissions')}}</a>
		@can('Add role')
		<a role="button" href="{{ route('roles.create') }}" class="btn btn-outline-info btn-sm">{{ __('messages.add_role')}}</a>
		@endcan
    </p>
        

    <div class="table-responsive-md">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>{{ __('messages.role') }}</th>
                    <th>{{ __('messages.permissions') }}</th>
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
							
							<a role="button" href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info">{{ __('messages.button_edit')}}</a>
							@can('Delete role')
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
    </div>
</div>
</div>
</div>
@endsection