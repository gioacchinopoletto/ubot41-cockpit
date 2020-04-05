{{-- \resources\views\e\create.blade.php --}}
@extends('layouts.app-desk')

@section('content')

<div class="card">
	<div class="row justify-content-center">
		
		<div class="col-md-11">

			<h4 class="card-title"><i class="fa fa-user-plus"></i> {{ __('messages.add_user')}}</h4>
    
			<div class="card-body">
			    <p class="text-right">
				    @role('Admin')
				    <a role="button" href="{{ route('users.index') }}" class="btn btn-info btn-sm">{{ __('messages.users')}}</a>
				    @endrole
				    @role('Signaling')
				    <a role="button" href="{{ route('dashboard') }}" class="btn btn-info btn-sm">{{ __('messages.button_back')}}</a>
				    @endrole
			    </p>
    

			    {{ Form::open(array('url' => 'users', 'class' => 'form-type-material')) }}
				
				<div class="row">
					<div class="col-md-10">
					    <div class="form-group">
					        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"  name="name" value="{{ old('name') }}">
					        {{ Form::label('name', __('messages.field_name') ) }}
					        @if ($errors->has('name'))
		                        <div class="invalid-feedback">
		                            {{ $errors->first('name') }}
		                        </div>
		                    @endif
					    </div>
					</div>
					<div class="col-md-2">
					    <div class="form-group">
						    @php
							    $class = $errors->has('locale') ? ' is-invalid' : '' ;
							@endphp
							{{ Form::select('locale', ['it' => 'Italiano', 'en' => 'English'], 'it', ['class' => 'form-control'. $class]) }}
					        {{ Form::label('locale', __('messages.field_locale')) }}
					        @if ($errors->has('locale'))
			                        <div class="invalid-feedback">
			                            {{ $errors->first('locale') }}
			                        </div>
			                @endif
					    </div>
					</div>
				</div>     
			
			    <div class="form-group">
			        <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"  name="email" value="{{ old('email') }}">
			        {{ Form::label('email', __('messages.field_email')) }}
			        @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
			    </div>
			    
			    <div class="form-group">
					{{ Form::label('signaling_id', __('messages.field_signaler_contract') ) }}
					{{ Form::select('signaling_id', $signalers, null, ['class' => 'form-control']) }}
				</div>
				
				  
				<div class='form-group'>
			        <h5> {{__('messages.add_role') }}</h5>
			        
			        
			        @hasanyrole('Admin|Team')
				        @foreach ($roles as $role)
				        	<div class="custom-controls-stacked custom-control custom-checkbox">
				        		{{ Form::checkbox('roles[]',  $role->id, false, ['class' => 'custom-control-input'] ) }}
				        		<label class="custom-control-label">{{ ucfirst($role->name) }}</label>
				        	</div>
				        @endforeach
			        @else
			        	@foreach ($roles as $role)
			        		@if($role->id == 3 || $role->id == 4)
			        		<div class="custom-controls-stacked custom-control custom-checkbox">
			        			{{ Form::checkbox('roles[]',  $role->id, false, ['class' => 'custom-control-input'] ) }}
			        			<label class="custom-control-label">{{ ucfirst($role->name) }}</label>
			        		</div>
							@endif
				        @endforeach
				    @endhasanyrole  
			        
			    </div>
			    
			    <div class="form-group">
			        <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  name="password" value="{{ old('password') }}">
			        {{ Form::label('password', __('messages.field_password')) }}
					@if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
			    </div>
			
			    <div class="form-group">
				    <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"  name="password_confirmation" value="{{ old('password_confirmation') }}">
			        {{ Form::label('password_confirmation', __('messages.field_password_confirm')) }}
			        @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                    @endif
			    </div>
			
				<h5>{{__('messages.addresses')}}</h5>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
					        <input id="address" type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"  name="address" value="{{ old('address') }}">
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

			</div>
		</div>
	</div>
</div>
@endsection