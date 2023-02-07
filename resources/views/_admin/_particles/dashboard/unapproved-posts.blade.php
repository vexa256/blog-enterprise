<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.latestunapprovedposts') }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if(count($lastunappruves) !== 0)
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th width="5%">{{ trans('admin.thumb') }}</th>
                        <th width="65%">{{ trans('admin.posts') }}</th>
                        <th width="15%">{{ trans('admin.type') }}</th>
                        <th width="15%">{{ trans('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lastunappruves as $item)
                    <tr>
                        <td>
                            <div class="product-img">
                                <img src="{{ makepreview($item->thumb, 's', 'posts') }}" width="50">
                            </div>
                        </td>
                        <td><a target="_blank" href="{{ $item->post_link }}">{{ $item->title }}</a>
                        </td>
                        <td>
                            @if($item->type == 'news')
                            <span class="label  bg-aqua"><i class="fa fa-file-text"></i>&nbsp;{{ trans('admin.news') }}</span>
                            @elseif($item->type == 'list')
                            <span class="label bg-green"><i class="fa fa-th-list"></i>&nbsp;{{ trans('admin.lists') }}</span>
                            @elseif($item->type == 'quiz')
                            <span class="label bg-purple"><i class="fa fa-th-list"></i>&nbsp;{{ trans('admin.quizzes') }}</span>
                            @elseif($item->type == 'poll')
                            <span class="label  bg-yellow"><i class="fa fa-check-square-o"></i>&nbsp;{{ trans('admin.polls') }}</span>
                            @elseif($item->type == 'video')
                            <span class="label  bg-red"><i class="fa fa-youtube-play"></i>&nbsp;{{ trans('admin.videos') }}</span>
                            @else
                            @endif
                        </td>
                        <td>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false">
                                    {{ trans('admin.actions') }}
                                        <span class="fa fa-caret-down"></span>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="{{ action('Admin\PostsController@bulkAction',  ['ids' => $item->id, 'action' => 'approve']) }}">
                                            {{ trans('admin.approvePost') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a target=_blank href="{{  action('PostEditorController@showPostEdit', $item->id) }}">
                                            {{ trans('admin.editpost') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a class="sendtrash" href="{{ action('Admin\PostsController@bulkAction', ['ids' => $item->id, 'action' => 'delete']) }}">
                                            {{ trans('admin.sendtrash') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="permanently" href="{{ action('Admin\PostsController@bulkAction', ['ids' => $item->id, 'action' => 'forceDelete']) }}">
                                            {{ trans('admin.deletepermanently') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.table-responsive -->
        @else
        {{ trans('admin.nothingtoseehere') }}
        @endif
    </div><!-- /.box-body -->
    <div class="box-footer text-center">
        <a href="{{route('admin.posts',  ['only' => 'unapprove'])}}" class="uppercase">{{ trans('admin.viewall') }}</a>
    </div><!-- /.box-footer -->
</div>
