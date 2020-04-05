{{-- \resources\views\users\show.blade.php --}}

@extends('layouts.app-desk')

@section('content')
<div class="card">
<div class="row justify-content-center">

<div class="col-md-11">

    <h4 class="card-title"><i class="fa fa-user"></i> {{ __('messages.show_user', ['name' => $user->name])}}</h4>
    <div class="card-body">
    <p class="text-right">
	    @if($cofinancing_count > 0)
	    <a role="button" href="{{ route('users.cofinancepayments', [$user->id]) }}" class="btn btn-info btn-sm">{{ __('messages.button_cofpayment_transactions')}}</a>
	    @endif
	    @if($contracts_count > 0)
	    <a role="button" href="{{ route('users.payments', [$user->id]) }}" class="btn btn-info btn-sm">{{ __('messages.button_payment_transactions')}}</a>
	    @endif
	    <a role="button" href="{{ route('users.index') }}" class="btn btn-info btn-sm">{{ __('messages.users')}}</a>
    </p>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}

    <div class="form-group">
        {{ Form::label('name', __('messages.field_name') ) }}
        {{ Form::text('name', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
    </div>

    <div class="form-group">
        {{ Form::label('email', __('messages.field_email')) }}
        {{ Form::email('email', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
    </div>

    

    <div class='form-group'>
	    <h5>{{__('messages.role')}}</h5>
	    
        	@foreach ($roles as $role)
	        	<div class="custom-controls-stacked custom-control custom-checkbox">
				   {{ Form::checkbox('roles[]',  $role->id, $user->roles, ['class' => 'custom-control-input', 'disabled' => 'disabled'] ) }}
				   <label class="custom-control-label">{{ ucfirst($role->name) }}</label>
				</div>
	        @endforeach
    </div>
    
    <h3>{{__('messages.addresses')}}</h3>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
		        {{ Form::label('address', __('messages.field_address_invoice') ) }}
		        {{ Form::text('address', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
		<div class="col-md-4">    
		    <div class="form-group">
		        {{ Form::label('vat', __('messages.field_vat') ) }}
		        {{ Form::text('vat', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
		        {{ Form::label('ntp', __('messages.field_ntp') ) }}
		        {{ Form::text('ntp', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
		        {{ Form::label('city', __('messages.field_city') ) }}
		        {{ Form::text('city', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
		        {{ Form::label('region', __('messages.field_region') ) }}
		        {{ Form::text('region', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
	</div>
	
	<h5>{{__('messages.bankdatas')}}</h5>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
		        {{ Form::label('iban', __('messages.field_iban') ) }}
		        {{ Form::text('iban', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
		        {{ Form::label('bic', __('messages.field_bic') ) }}
		        {{ Form::text('bic', null, array('class' => 'form-control form-control-sm', 'readonly' => 'readonly')) }}
		    </div>
		</div>
	</div>


    {{ Form::close() }}
    
    <hr />
	<h3>{{__('messages.wallets')}}</h3>
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
	            </tr>
	            @endforeach
	        </tbody>
        </table>    
	</div>
	@else
		<p>{{ __('messages.nowallet') }}</p>
	@endif
	
	@hasanyrole('Admin|Team')
		<hr />
		<h3>{{__('messages.integrations')}}</h3>
		@php
			$mc_mining_msg = ($mc_mining == true) ? __('messages.button_yes') : __('messages.button_no');
			$mc_signalers_msg = ($mc_signalers == true) ? __('messages.button_yes') : __('messages.button_no');
			$mc_financing_msg = ($mc_financing == true) ? __('messages.button_yes') : __('messages.button_no');
			$mc_deeplearning_msg = ($mc_deeplearning == true) ? __('messages.button_yes') : __('messages.button_no');
		@endphp
		<div class="table-responsive-md">
        	<table class="table table-sm table-bordered">
	        	<tr>
		        	<td><i class="fa fa-user"></i> Mailing list clienti mining</td>
		        	<td>{{ $mc_mining_msg }} ({{ $mc_mining_status }})</td>
		        	<td class="text-center" width="300">
			        	@if($mc_mining_status == 'not found' || $mc_mining_status == 'unsubscribed')
							<a class="btn btn-info btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_mining_list'), 'state' => 'add'])}}">Iscrivi alla mailing list</a>
						@else
							<a class="btn btn-warning btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_mining_list'), 'state' => 'remove'])}}">Rimuovi dalla mailing list</a>
						@endif
		        	</td>	
		        <tr>
			    <tr>
		        	<td><i class="fa fa-user"></i> Mailing list clienti co-financing</td>
		        	<td>{{ $mc_financing_msg }} ({{ $mc_financing_status }})</td>
		        	<td class="text-center" width="300">
			        	@if($mc_financing_status == 'not found' || $mc_financing_status == 'unsubscribed')
							<a class="btn btn-info btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_financing_list'), 'state' => 'add'])}}">Iscrivi alla mailing list</a>
						@else
							<a class="btn btn-warning btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_financing_list'), 'state' => 'remove'])}}">Rimuovi dalla mailing list</a>
						@endif
		        	</td>	
		        <tr>
			    <tr>
		        	<td><i class="fa fa-user"></i> Mailing list clienti deep learning</td>
		        	<td>{{ $mc_deeplearning_msg }} ({{ $mc_deeplearning_status }})</td>
		        	<td class="text-center" width="300">
			        	@if($mc_deeplearning_status == 'not found' || $mc_deeplearning_status == 'unsubscribed')
							<a class="btn btn-info btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_deeplearning_list'), 'state' => 'add'])}}">Iscrivi alla mailing list</a>
						@else
							<a class="btn btn-warning btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_deeplearning_list'), 'state' => 'remove'])}}">Rimuovi dalla mailing list</a>
						@endif
		        	</td>	
		        <tr>    
			    <tr>
		        	<td><i class="fa fa-user-secret"></i> Mailing list segnalatori</td>
		        	<td>{{ $mc_signalers_msg }} ({{ $mc_signalers_status }})</td>
		        	<td class="text-center" width="300">
			        	@if($mc_signalers_status == 'not found' || $mc_signalers_status == 'unsubscribed')
							<a class="btn btn-info btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_signalers_list'), 'state' => 'add'])}}">Iscrivi alla mailing list</a>
						@else
							<a class="btn btn-warning btn-sm" href="{{ route('users.changemcstate', ['id' => $user->id, 'list' => config('miningcentral.mc_signalers_list'), 'state' => 'remove'])}}">Rimuovi dalla mailing list</a>
						@endif
		        	</td>	
		        <tr>		
        	</table>
		</div>	
	@endhasanyrole
	
	@hasanyrole('Admin|Team|Signaling')
		@if($packages->count() > 0)
			<hr />
			<h3>{{__('messages.print_proposal_packages')}}</h3>
			<p>{!! __('messages.print_proposal_packages_alert') !!}</p>
			<div class="table-responsive-md">
		        <table class="table table-sm table-bordered">
			        <tbody>
				        @foreach ($packages as $package)
				        	<tr>
					        	<td>{{ $package->name }}</td>
					        	<td style="width: 200px"><a href="{{ route('document.generateproposal', ['user' => $user->id, 'package' => $package->id]) }}" class="btn btn-info btn-sm">{{ __('messages.button_generate_download')}}</a></td>
				        	</tr>
						@endforeach
			        </tbody>
		        </table>         
			@else
			<p>{{ __('messages.nopackages_active_forproposal') }}</p>
			@endif
	@endhasanyrole
    </div>
</div>
</div>
</div></div>
@endsection