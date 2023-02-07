@extends("_admin.adminapp")
@section('header')
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/morris/morris.css') }}">
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ trans('admin.dashboard') }}
        <small>{{ trans('admin.controlpanel') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $postunapprove }}</h3>
                    <p>{{ trans('admin.waitingapprove') }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <a href="{{route('admin.posts', ['only' => 'unapprove'])}}" class="small-box-footer">{{ trans('admin.moreinfo') }} <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $todaypost }}</h3>
                    <p>{{ trans('admin.todaysposts') }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
                <a href="{{route('admin.posts')}}" class="small-box-footer">{{ trans('admin.moreinfo') }} <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $todayusers }}</h3>
                    <p>{{ trans('admin.todaysuserregistrations') }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus"></i>
                </div>
                <a href="{{route('admin.users')}}" class="small-box-footer">{{ trans('admin.moreinfo') }} <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $todaylogins }}</h3>
                    <p>{{ trans('admin.todaysuserlogins') }}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-eye"></i>
                </div>
                <a href="{{route('admin.users')}}" class="small-box-footer">{{ trans('admin.moreinfo') }} <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
    </div>
    <div class="row">
        <section class="col-lg-7 connectedSortable">
            @include('_admin._particles.dashboard.latest-posts')
            @include('_admin._particles.dashboard.latest-users')
        </section>

        <section class="col-lg-5 connectedSortable">
            @include('_admin._particles.dashboard.unapproved-posts')
            @if(get_buzzy_config('p_buzzycomment') == 'on')
            @include('_admin._particles.dashboard.unapproved-comments')
            @endif
            @include('_admin._particles.dashboard.mountly-posts')
            @include('_admin._particles.dashboard.mountly-types')
            @include('_admin._particles.dashboard.mountly-users')
        </section>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('admin.NumberofNews') }}</span>
                    <span class="info-box-number">{{ $newscount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('admin.NumberofLists') }}</span>
                    <span class="info-box-number">{{ $listcount }}</span>
                </div>
            </div>
        </div>

        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-check-square-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('admin.NumberofPolls') }}</span>
                    <span class="info-box-number">{{ $pollcount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-youtube-play"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('admin.NumberofVideos') }}</span>
                    <span class="info-box-number">{{ $videocount }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<!-- Morris.js charts -->
<script src="{{asset('assets/plugins/adminlte/plugins/rapheal/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/adminlte/plugins/morris/morris.min.js') }}"></script>

<!-- Buzzy Admin Admin Dashboard -->
<script src="{{ asset('assets/admin/js/dashboard.js') }}"></script>
@endsection
