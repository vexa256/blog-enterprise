@extends("_admin.adminapp")
@section('header')
@include('_admin._particles._datatable.head_scripts')
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(request()->query('only')=='unapprove')
        {!! trans('admin.Unapproved', ['type' => __('Comments') ]) !!}
        @elseif(request()->query('only')=='deleted')
        {!! trans("admin.Trash", ['type' => __('Comments')]) !!}
        @elseif(request()->query('only')=='reported')
        {!! __('Reported :type', ['type' => __('Comments') ]) !!}
        @else
        {{ __('Comments') }}
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans("admin.dashboard") !!}</a></li>
        <li class="active">{{ __('Comments') }}</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="overlay hide">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="box-body">
                    <div class="table-actions-menu">
                        <div class="btn-group">
                            @if(request()->query('only')=='deleted')
                            <button type="button" class="btn btn-success dropdown-toggle doaction"
                                data-url="{{ action('Admin\CommentController@bulkAction', ['action'=> 'restore']) }}"
                                data-type="move"
                                data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-recycle"></i>
                                {{ trans("admin.RetrievefromTrash") }}
                            </button>
                            @else
                            <button type="button" class="btn btn-danger dropdown-toggle doaction"
                                data-url="{{ action("Admin\CommentController@bulkAction", ['action'=> 'delete']) }}"
                                data-type="move" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-trash"></i>
                                    {{ trans("admin.SendtoTrash") }}
                            </button>
                            @endif
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="true">{{ trans("buzzycontact.Actions") }} <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu pull-left">
                                @if(request()->query('only')!='deleted')
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\CommentController@bulkAction", ['action'=> 'approve']) }}"
                                        data-type="do" data-action="Approve"><i class="fa fa-check text-green"></i>
                                        {{ trans("admin.Approve") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\CommentController@bulkAction", ['action'=> 'unapprove']) }}"
                                        data-type="do" data-action="UndoApprove">
                                        <i class="fa fa-check"></i>
                                        {{ trans("admin.UndoApprove") }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                @endif
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\CommentController@bulkAction", ['action'=> 'forceDelete']) }}"
                                        data-type="deleteperma" data-action="deleteperma">
                                        <i class="fa fa-remove"></i>
                                        {{ trans("admin.Deletepermanently") }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div class="cho">
                                        <input type="checkbox" class="checkbox-toggle">
                                    </div>
                                </th>
                                <th>{!! __('Comment') !!}</th>
                                <th>{!! __('Post') !!}</th>
                                <th>{!! trans("admin.User") !!}</th>
                                <th>{!! trans("admin.Status") !!}</th>
                                <th>{!! trans("admin.Dates") !!}</th>
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

<div id="reports_modal_content"></div>

@endsection
@section('footer')
@include('_admin._particles._datatable.footer_scripts', [
            'order_count' => 5,
            'columns' => [
                [
                    'sType'=>'html',
                    'data'=>'selection',
                    'name'=>'selection',
                    'orderable'=>false,
                    'searchable'=>false,
                    'width'=>'2%'
                ],
                [
                    'sType'=>'html',
                    'data'=>'comment',
                    'name'=>'comment',
                    'orderable'=>false,
                    'searchable'=>false,
                    'width'=>'25%'
                ],
                [
                    'sType'=>'html',
                    'data'=>'post',
                    'name'=>'post',
                    'orderable'=>false,
                    'searchable'=>true,
                    'width'=>'25%'
                ],
                [
                    'data'=>'user',
                    'name'=>'user',
                    'orderable'=>false,
                    'searchable'=>false,
                    'width'=>'15%'
                ],
                [
                    'data'=>'approve',
                    'name'=>'approve',
                    'orderable'=>false,
                    'searchable'=>false,
                      'width'=>'13%'
                ],
                [
                    'data'=>'created_at',
                    'name'=>'created_at',
                    'orderable'=>true,
                    'searchable'=>false,
                     'width'=>'10%'
                ],
                [
                    'data'=>'action',
                    'name'=>'action',
                    'orderable'=>false,
                    'searchable'=>false,
                    'width'=>'10%'
                ]
            ],
        ]);
@endsection
