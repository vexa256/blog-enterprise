@extends("_admin.adminapp")
@section('header')
<!-- colorpicker -->
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('admin.Settings') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li class="active"> {{ trans('admin.Settings') }}</li>
    </ol>
</section>
<section class="content">
    {!! Form::open(array('action' => 'Admin\ConfigController@setconfig', 'method' => 'POST', 'enctype' =>
    'multipart/form-data')) !!}
    @if(Request::query('q') == 'others')
    @include('_admin._particles.config_forms.other')
    @elseif(Request::query('q') == 'permissions')
    @include('_admin._particles.config_forms.permissions')
    @elseif(Request::query('q') == 'mail')
    @include('_admin._particles.config_forms.mail')
    @elseif(Request::query('q') == 'storage')
    @include('_admin._particles.config_forms.storage')
    @elseif(Request::query('q') == 'comment')
    @include('_admin._particles.config_forms.comment')
    @elseif(Request::query('q') == 'social')
    @include('_admin._particles.config_forms.social')
    @elseif(Request::query('q') == 'share')
    @include('_admin._particles.config_forms.share')
    @elseif(Request::query('q') == 'login')
    @include('_admin._particles.config_forms.login')
    @elseif(Request::query('q') == 'recaptcha')
    @include('_admin._particles.config_forms.recaptcha')
    @elseif(Request::query('q') == 'advanced')
    @include('_admin._particles.config_forms.advanced')
    @else
    @include('_admin._particles.config_forms.main')
    @endif
    <div class="row">
        <div class="col-sm-12  col-md-8 col-lg-6">
            <input type="submit" value="{{ trans('admin.SaveSettings') }}" class="btn btn-block btn-info btn-lg">
        </div><!-- /.col -->
    </div><!-- /.row -->
    {!! Form::close() !!}
</section>
@endsection
@section("footer")
<!-- sweetalert -->
<script src="{{ asset('assets/plugins/adminlte//plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/adminlte//plugins/iCheck/icheck.min.js') }}"></script>
@endsection
