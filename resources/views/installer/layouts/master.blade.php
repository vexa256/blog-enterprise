<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{trans('installer.title')}}</title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/bootstrap/css/bootstrap.min.css') }}">

    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/installer.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/plugins/vendor/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vendor/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body>

	<div class="container">
		<div class="login-body">
            <h1 class="title">Buzzy <span>Initialization Wizard</span></h1>
            <h5 class="thanks">Thank you for buying and using Buzzy.</h5>
            <div class="clear"></div>
			<article class="container-login center-block">
				<section>
					@yield('container')
				</section>
			</article>
		</div>
	</div>

	 <!-- jQuery 2.1.4 -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('assets/plugins/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
    @yield('js')
</body>
</html>
