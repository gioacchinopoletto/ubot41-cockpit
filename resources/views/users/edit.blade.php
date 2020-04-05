{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.app-desk')

@section('content')

<div class="card">
<div class="row justify-content-center">

<div class="col-md-11">

    <h4 class="card-title"><i class="fa fa-user-plus"></i> {{ __('messages.edit_user', ['name' => $user->name])}}</h4>
    <div class="card-body">
    <p class="text-right">
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-info btn-sm">{{ __('messages.users')}}</a>
	    @can('Add single user permission')
	    <a role="button" href="{{ route('users.personalpermissions', $user->id) }}" class="btn btn-outline-info btn-sm">{{ __('messages.single_user_permissions')}}</a>
	    @endcan
    </p>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class' => 'form-type-material')) }}
	
	<div class="row">
		<div class="col-md-5">
		    <div class="form-group">
			    @php
				    $class = $errors->has('name') ? ' is-invalid' : '' ;
				@endphp
				{!! Form::text('name', null, ['class' => 'form-control'. $class] ) !!}
			    {{ Form::label('name', __('messages.field_name') ) }}
		        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                @endif
		    </div>
		</div>
		<div class="col-md-5">
		    <div class="form-group">
			    @php
				    $class = $errors->has('email') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::email('email', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('email', __('messages.field_email')) }}
		        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                @endif
		    </div>
		</div>
		<div class="col-md-2">
		    <div class="form-group">
			    @php
				    $class = $errors->has('locale') ? ' is-invalid' : '' ;
				@endphp
				{{ Form::select('locale', ['it' => 'Italiano', 'en' => 'English'], $user->locale, ['class' => 'form-control'. $class]) }}
		        {{ Form::label('locale', __('messages.field_locale')) }}
		        @if ($errors->has('locale'))
                        <div class="invalid-feedback">
                            {{ $errors->first('locale') }}
                        </div>
                @endif
		    </div>
		</div>
	</div>

    
	<div class="row">
    <div class="col-md-6">
	    <div class='form-group'>
		    
		    <h5> {{__('messages.edit_role') }}</h5>	
		    @foreach ($roles as $role)
	        	<div class="custom-controls-stacked custom-control custom-checkbox">
				   {{ Form::checkbox('roles[]',  $role->id, $user->roles, ['class' => 'custom-control-input'] ) }}
				   <label class="custom-control-label">{{ ucfirst($role->name) }}</label>
				</div>
	        @endforeach
	    </div>
    </div>
    <div class="col-md-6">    
		<div class="form-group">
			{{ Form::label('signaling_id', __('messages.field_signaler_contract') ) }}
			{{ Form::select('signaling_id', $signalers, $user->signaling_id, ['class' => 'form-control']) }}	
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col-md-6">
		    <div class="form-group">
			    <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  name="password" value="{{ old('password') }}">
		        {{ Form::label('password', __('messages.field_password')) }}
		        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                @endif
		    </div>
		</div>
		<div class="col-md-6">
		    <div class="form-group">
			    <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
		        {{ Form::label('password_confirmation', __('messages.field_password_confirm')) }}
		        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                @endif
		    </div>
		</div>
	</div>
	
	<h5>{{__('messages.addresses')}}</h5>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
		        @php
				    $class = $errors->has('address') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('address', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('address', __('messages.field_address_invoice') ) }}
		        @if ($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
		    </div>
		</div>
		<div class="col-md-4">    
		    <div class="form-group">
		        @php
				    $class = $errors->has('vat') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('vat', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('vat', __('messages.field_vat') ) }}
		        @if ($errors->has('vat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vat') }}
                    </div>
                @endif
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				@php
				    $class = $errors->has('ntp') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('ntp', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('ntp', __('messages.field_ntp') ) }}
		        @if ($errors->has('ntp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ntp') }}
                    </div>
                @endif
		    </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
		        @php
				    $class = $errors->has('city') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('city', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('city', __('messages.field_city') ) }}
		        @if ($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
		    </div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
		        @php
				    $class = $errors->has('region') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('region', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('region', __('messages.field_region') ) }}
		        @if ($errors->has('region'))
                    <div class="invalid-feedback">
                        {{ $errors->first('region') }}
                    </div>
                @endif
		    </div>
		</div>
	</div>
	
	<h5>{{__('messages.bankdatas')}}</h5>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				@php
				    $class = $errors->has('iban') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('iban', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('iban', __('messages.field_iban') ) }}
		        @if ($errors->has('iban'))
                    <div class="invalid-feedback">
                        {{ $errors->first('iban') }}
                    </div>
                @endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				@php
				    $class = $errors->has('bic') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('bic', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('bic', __('messages.field_bic') ) }}
		        @if ($errors->has('bic'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bic') }}
                    </div>
                @endif
			</div>
		</div>
	</div>	
	
	{{ Form::submit(__('messages.button_save'), array('class' => 'btn btn-info btn-sm btn-block')) }}

    {{ Form::close() }}
    
    <hr />
	
	<h3>{{__('messages.wallets')}}</h3>
	
	@can('Add wallet')
	<p class="text-right">
			<a role="button" href="{{ route('createwallet', $user->id) }}" class="btn btn-info btn-sm">{{ __('messages.add_wallet')}}</a>
	</p>
	@endcan
	
	@if($wallets->count() > 0)
	<div class="table-responsive-md">
        <table class="table table-sm table-bordered">
	        <thead>
                <tr>
	                <th>{{ __('messages.field_address')}}</th>
	                <th>{{ __('messages.field_type')}}</th>
	                <th>{{ __('messages.field_mantainer')}}</th>
	                <th>{{ __('messages.field_datetime_add')}}</th>
	                <th>{{ __('messages.field_datetime_edit')}}</th>
	                <th class="text-center"><i class="fa fa-th"></i></th>
                </tr>
	        </thead>    
	        <tbody>
	            @foreach ($wallets as $wallet)
	            <tr>
		            <td>{{ $wallet->address }}</td>
		            <td>{{ $wallet->type }}</td>
		            <td>{{ $wallet->mantainer }}</td>
		            <td>{{ $wallet->created_at->format('d.m.Y h:ia') }}</td>
		            <td>{{ $wallet->created_at->format('d.m.Y h:ia') }}</td>
		            <td class="text-center">
			            {!! Form::open(['method' => 'DELETE', 'route' => ['wallets.destroy', $wallet->id] ]) !!}
			            <div class="btn-group btn-group-sm" role="group" aria-label="">
				            @can('Change wallet state')
							  @if($wallet->active == 1)
							  	<a role="button" href="{{ route('wallets.changestate', [$wallet->id, 0, $user->id]) }}"class="btn btn-info">{{ __('messages.button_deactivate')}}</a>	
							  @else
							  	<a role="button" href="{{ route('wallets.changestate', [$wallet->id, 1, $user->id]) }}" class="btn btn-info">{{ __('messages.button_activate')}}</a>
							  @endif
						    @endcan
						    @can('Delete wallet')
						    {{ Form::hidden('user', $user->id) }}
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
	@else
		<p>{{ __('messages.nowallet') }}</p>
	@endif
	    	
</div>
</div>
</div>
</div>
@endsection