@extends("_admin.adminapp")
@section('header')
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/nestable/jquery.nestable.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/admin/css/menu.css') }}" />
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ trans('v4.menus') }}&nbsp;>&nbsp;
        {!! Form::select('current',
        \App\Menu::all()->pluck('name', 'id'), $menu->id , [ "id"=>"changeLocation", 'class' => 'ml-2', 'data-base' => route("admin.menus")])
        !!}
        @if(get_multilanguage_enabled())
        &nbsp;>&nbsp; {!! get_language_list(get_buzzy_locale()) !!}
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li><a href="#">{{ trans('v4.menus') }}</a></li>
        <li class="active">{{ $menu->name }}</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            @include('_admin.pages.menus.particles.menu-item-form', ['menu' => $menu])
        </div><!-- /.col -->

        <div class="col-md-8">
            <div class="dd" id="nestmenu" data-url="{{ action('Admin\MenuItemController@sort') }}" data-depth="{{ menu_settings($menu->id)['depth'] }}">
                @include('_admin.pages.menus.particles.draggable-menu', ['lists' =>
                $menu->items()->where('language', get_buzzy_locale())->whereNull('parent_id')->orderBy('order', 'asc')->get()])
            </div>
        </div>
    </div>
</section>
@endsection
@section("footer")
<script src="{{ asset('assets/plugins/adminlte/plugins/nestable/jquery.nestable.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/menus.js') }}"></script>
@endsection
