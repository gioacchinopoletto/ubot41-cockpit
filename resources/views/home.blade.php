@extends('layouts.app')

@section('content')

    <div class="row m-5">
        <div class="col-md-12">
			@if (session('message'))
				<div class="alert alert-{{ session('message.type')}} alert-dismissible fade show" role="alert">
					{!! session('message.text')!!}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif
                   
        </div>
    </div>

@endsection
