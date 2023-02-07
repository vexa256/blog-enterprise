@extends("_admin.adminapp")
@section('header')
@include('_admin._particles._datatable.head_scripts')
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if(request()->query('only')=='unapprove')
        {!! trans('admin.Unapproved', ['type' => $title ]) !!}
        @elseif(request()->query('only')=='featured')
         {!! trans("admin.FeaturesPosts", ['type' => $title]) !!}
        @elseif(request()->query('only')=='deleted')
        {!! trans("admin.Trash", ['type' => $title]) !!}
        @else
        {{ $title }}
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans("admin.dashboard") !!}</a></li>
        <li class="active">{{ $title }}</li>
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
                            @if(Request::query('only')=='deleted')
                            <button type="button" class="btn btn-success dropdown-toggle doaction"
                                data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'restore']) }}"
                                data-type="move" data-toggle="dropdown" aria-expanded="true"><span class="fa fa-recycle"></span> {{ trans("admin.RetrievefromTrash") }} </button>
                            @else
                            <button type="button" class="btn btn-danger dropdown-toggle doaction"
                                data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'delete']) }}"
                                data-type="move" data-toggle="dropdown" aria-expanded="true"><span class="fa fa-trash"></span> {{ trans("admin.SendtoTrash") }} </button>
                            @endif
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                    aria-expanded="true">{{ trans("buzzycontact.Actions") }}
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu pull-left">
                                @if(Request::query('only')!='deleted')
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'approve']) }}"
                                        data-type="do" data-action="Approve">
                                        <i class="fa fa-check text-green"></i>
                                        {{ trans("admin.Approve") }}
                                        </a>
                                    </li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                    data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'unApprove']) }}"
                                    data-type="do" data-action="UndoApprove">
                                        <i class="fa fa-check"></i>
                                        {{ trans("admin.UndoApprove") }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'setFeatured']) }}"
                                        data-type="do" data-action="PickforFeatured">
                                        <i class="fa fa-star text-yellow"></i>
                                        {{ trans("admin.PickforFeatured") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'unsetFeatured']) }}"
                                        data-type="do" data-action="UndoFeatured">
                                        <i class="fa fa-star"></i>
                                        {{ trans("admin.UndoFeatured") }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                    data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'setForHomepage']) }}"
                                        data-type="do" data-action="PickforHomepage"><i
                                            class="fa fa-dashboard text-red"></i>
                                        {{ trans("admin.PickforHomepage") }}
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="doaction"
                                        data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'unsetForHomepage']) }}"
                                        data-type="do" data-action="UndofromHomepage"><i class="fa fa-dashboard"></i>
                                        {{ trans("admin.UndofromHomepage") }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                @endif
                                <li>
                                    <a href="javascript:;" class="doaction"
                                    data-url="{{ action("Admin\PostsController@bulkAction", ['action'=> 'forceDelete']) }}"
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
                                <th>{!! trans("admin.Preview") !!}</th>
                                <th>{!! trans("admin.Title") !!}</th>
                                <th>{!! trans("admin.User") !!}</th>
                                <th>{!! trans("admin.Status") !!}</th>
                                @if(get_multilanguage_enabled())
                                <th>{!! trans("v4.post_language") !!}</th>
                                @endif
                                @if($type=='features')
                                <th>{!! trans("admin.FeaturedDate") !!}</th>
                                @else
                                <th>{!! trans("admin.Dates") !!}</th>
                                @endif
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
            'order_count' => get_multilanguage_enabled() ? 6 : 5,
            'columns' => [
                [
                    'sType' =>'html',
                    'data' => 'selection',
                    'name' =>'selection',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"2%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'thumb',
                    'name' =>'thumb',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"2%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'title',
                    'name' =>'title',
                    'orderable' =>false,
                    'searchable' =>true,
                    "width" =>"33%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'user',
                    'name' =>'user',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"15%"
                ],
                [
                    'sType' =>'html',
                    'data' => 'approve',
                    'name' =>'approve',
                    'orderable' =>false,
                    'searchable' =>false,
                    "width" =>"13%"
                ],
                get_multilanguage_enabled() ? [
                    'sType' =>'html',
                    'data' => 'language',
                    'name' =>'language',
                    'orderable' =>true,
                    'searchable' =>false,
                    "width" =>"10%"
                ] : null,
                $type == 'features' ? [
                    'sType' =>'html',
                    'data' => 'featured_at',
                    'name' =>'featured_at',
                    'orderable' =>true,
                    'searchable' =>false,
                    "width" =>"10%"
                ] : [
                    'sType' =>'html',
                    'data' => 'published_at',
                    'name' =>'published_at',
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
)
@endsection
