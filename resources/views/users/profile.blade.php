{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.app-desk')

@section('content')

<div class="card">
<div class="row justify-content-center">

<div class="col-md-11">
	@php
		$hashUser = md5( strtolower(trim(Auth::user()->email)));
	@endphp
    <h4 class="card-title"><img class="avatar" src="https://www.gravatar.com/avatar/{{$hashUser}}?r=g&d=wavatar"> {{ $user->name }}</h3>
    <div class="card-body">
    <p class="text-right">
	    @if($cofinancing_count > 0)
	    <a role="button" href="{{ route('users.cofinancepayments') }}" class="btn btn-info btn-sm">{{ __('messages.button_cofpayment_transactions')}}</a>
	    @endif
	    @if($contracts_count > 0)
	    <a role="button" href="{{ route('users.payments') }}" class="btn btn-info btn-sm">{{ __('messages.button_payment_transactions')}}</a>
	    @endif
    </p>
	
    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT', 'class' => 'form-type-material')) }}
	
	<div class="row">
		<div class="col-md-5">
		    <div class="form-group">
		        @php
				    $class = $errors->has('name') ? ' is-invalid' : '' ;
				@endphp
		        {!! Form::text('name', null, ['class' => 'form-control'. $class] ) !!}
		        {{ Form::label('name', __('messages.field_name')) }}
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
		    <div class="form-group">
		        <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  name="password" value="{{ old('password') }}">
		        {{ Form::label('password', __('messages.field_password')) }}
		        @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                @endif
				<small class="text-primary">{{ __('messages.add_password_only_edit')}}</small>
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
		        <small class="text-primary">{{ __('messages.add_password_confirm_only_edit')}}</small>
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
	
	<h5>{{__('messages.wallets')}}</h5>
	
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
			            </div>
			            {!! Form::close() !!}    
		            </td>
	            </tr>
	            @endforeach
	        </tbody>
        </table>    
	</div>
	@endif    	
    </div>
</div>
</div>
</div>

@endsection