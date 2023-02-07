<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ get_buzzy_config('sitename') }} | {{ trans('admin.adminpanel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/dist/css/skins/_all-skins.min.css') }}">

    <!-- sweetalert -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">

    @yield('header')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/plugins/vendor/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vendor/respond.min.js') }}"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('_admin.layout.header')

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            @include('_admin._particles.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            @include('_admin._particles.update-alert')
            @include('errors.error')
            @yield("content")

        </div><!-- /.content-wrapper -->

        @include('_admin.layout.footer')

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('assets/plugins/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

    <!-- sweetalert -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('assets/plugins/adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        var buzzy_item_id ="{{ config('buzzy.item_id') }}";
        var buzzy_base_url ="{{ route('home') }}";
        var buzzy_current_url ="{{ url()->current() }}";
        var buzzy_registered = {{ $updates !== false ? '1' : '0' }};
    </script>

    @yield('footer_js')

    <script src="{{ asset('assets/admin/js/app.js?v='.config('buzzy.version')) }}"></script>

    @yield('footer')

    <div class="hide">
        <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
    </div>

    @include('.errors.swalerror')

</body>

</html>
