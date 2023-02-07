@extends('app')

@section('content')
<div class="wt-container">
	<div class="global-container container">
		<div class="content auth-content">
        	@include("_particles.auth.reset-password")
		</div>
	</div>
</div>
@endsection
