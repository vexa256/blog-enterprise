@extends("_admin.adminapp")
@section('header')
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/datatables/responsive.bootstrap.min.css') }}">
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {!! trans("admin.Users") !!}
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans("admin.dashboard") !!}</a></li>
        <li class="active">{!! trans("admin.Users") !!}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>{!! trans("admin.Tcon") !!}</th>
                                <th>{!! trans("admin.User") !!}</th>
                                <th>{!! trans("admin.Email") !!}</th>
                                <th>{!! trans("admin.Status") !!}</th>
                                <th>{!! trans("admin.JoinedAt") !!}</th>
                                <th>{!! trans("admin.LastSeen") !!}</th>
                                <th>{!! trans("admin.Actions") !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
@endsection
@section('footer')
@include('_admin._particles._datatable.footer_scripts', [
            'data_url' => action("Admin\\UserController@getTableData", ['only' => $type]),
            'order_count' => 4,
            'columns' => [
                [
                    'sType' =>'html',
                    'data' => 'icon',
                    'name' =>'icon',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"2%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'username',
                    'name' =>'username',
                    'orderable' =>false,
                    'searchable' =>true,
                    "width" =>"38%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'email',
                    'name' =>'email',
                    'orderable' =>false,
                    'searchable' =>true,
                    "width" =>"20%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'status',
                    'name' =>'status',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"10%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'created_at',
                    'name' =>'created_at',
                    'orderable' =>true,
                    'searchable' =>false,
                    "width" =>"10%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'updated_at',
                    'name' =>'updated_at',
                    'orderable' =>true,
                    'searchable' =>false,
                    "width" =>"10%"
                ],
                  [
                    'sType' =>'html',
                    'data' => 'action',
                    'name' =>'action',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"10%"
                ],
            ],
        ]
);
@endsection
