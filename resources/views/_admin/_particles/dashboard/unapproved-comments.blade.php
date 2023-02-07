@php($comments = \App\Comment::approved(false)->take(5)->latest()->get())
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.Unapproved', ['type' => __('Comments') ]) }}</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        @if($comments)
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th width="70%">{{ __('Comment') }}</th>
                        <th width="15%">{{ trans('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $item)
                    <tr>
                        <td>
                            <div class="product-info">
                            <p>{{ strip_tags(\Str::limit($item->comment, 150)) }}</p>
                            <span class="product-description text-gray">
                            <i class="fa fa-user mr-5"></i>
                            @if($item->userdata->type =='guest')
                             {{ $item->userdata->username }} ({{ __('Guest') }})
                            @else
                            <a href="{{ $item->userdata->link }}" target="_blank">
                            {{ $item->userdata->username }}
                            </a>
                            @endif
                            <i class="fa fa-clock-o ml-10 mr-5" ></i> {{ $item->created_at->diffForHumans() }}
                            @if($item->post)
                            <a href="{{ generate_comment_url($item) }}" target="_blank" class="ml-10">
                            <i class="fa fa-file-text mr-5"></i>
                            {{ Str::limit($item->post->title, 25) }}
                            </a>
                            @endif
                            </span>
                            </div>
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
                                        <a href="{{ action('Admin\CommentController@bulkAction',  ['ids' => $item->id, 'action' => 'approve']) }}">
                                            {{ trans('admin.Approve') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a target=_blank href="{{ generate_comment_url($item) }}">
                                            {{ __('Edit Comment') }}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a class="sendtrash" href="{{ action('Admin\CommentController@bulkAction', ['ids' => $item->id, 'action' => 'delete']) }}">
                                            {{ trans('admin.sendtrash') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="permanently" href="{{ action('Admin\CommentController@bulkAction', ['ids' => $item->id, 'action' => 'forceDelete']) }}">
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
        <a href="{{route('admin.comments',  ['only' => 'unapprove'])}}" class="uppercase">{{ trans('admin.viewall') }}</a>
    </div><!-- /.box-footer -->
</div>
