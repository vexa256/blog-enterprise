@extends('app')

@section('content')
<div class="wt-container">
	<div class="global-container container">
		<div class="content auth-content">
			@include("_particles.auth.forget-password")
		</div>
	</div>
</div>
@endsection
@section('footer')
	<script>
        Buzzy.Auth._runPasswordModalActions();
	</script>
@endsection
