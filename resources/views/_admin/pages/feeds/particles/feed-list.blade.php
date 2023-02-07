<ol class="dd-list">
    @foreach ($lists as $list)
    <li class='dd-item'>
        <div class='dd-handle'>
            <div class="status">
                @if($list->active)
                <i class="fa fa-circle-o-notch fa-spin fa-fw" data-toggle="tooltip"
                    data-original-title="{{trans('admin.Active')}}"></i>
                @else
                <i class="fa fa-lock text-red" data-toggle="tooltip"
                    data-original-title="{{trans('admin.Disabled')}}"></i>
                @endif
            </div>
            <div class="info">
                <span class="item-title">{{$list->title}}</span>
                <span class="item-url">{{$list->url}}</span>
                <div class="item-url">
                    {{trans('v4half.feed_last_checked')}}
                    <b> {{isset($list->checked_at) ? $list->checked_at->diffForHumans() : '-'}}</b>
                    | {{trans('v4half.feed_next_check')}}
                    @if(isset($list->checked_at))
                    <b>
                        @if($list->interval == 'hourly')
                        {{ $list->checked_at->addHour()->diffForHumans()}}
                        @endif
                        @if($list->interval == 'dailly')
                        {{ $list->checked_at->addDay()->diffForHumans()}}
                        @endif
                        @if($list->interval == 'weekly')
                        {{ $list->checked_at->addWeek()->diffForHumans()}}
                        @endif
                        @if($list->interval == 'monthly')
                        {{ $list->checked_at->addMonth()->diffForHumans()}}
                        @endif
                    </b>
                    @endif
                </div>
            </div>
        </div>
        <div class='action-area'>
            <a href="{{route('admin.feeds', ['edit' => $list->id])}}" class="btn btn-sm btn-info edit-info"
                data-id=""><i class="fa fa-pencil"></i></a>
            <a class="btn btn-sm btn-danger permanently"
                href="{{ action('Admin\FeedController@destroy', [$list->id]) }}" role="button" data-toggle="tooltip"
                data-original-title="{{ trans('admin.delete') }}"><i class="fa fa-times"></i></a>
        </div>
    </li>
    @endforeach
</ol>
