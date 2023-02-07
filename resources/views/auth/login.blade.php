@extends("app")
@section('content')
<div class="wt-container">
	<div class="global-container container">
		<div class="content auth-content">
			@include("_particles.auth.login", ['link' => 'static'])
		</div>
	</div>
</div>
@endsection
@section('footer')
	<script>
        Buzzy.Auth._runLoginModalActions();
	</script>
@endsection
