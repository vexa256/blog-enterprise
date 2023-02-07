<div class="mailbox-controls clearfix">
    <div class="pull-right paginate">
        {!! $lastmails->render() !!}
    </div>
    <div class="clear"></div>
    <!-- Check all button -->
    <div class="cho">
        <input type="checkbox" class="checkbox-toggle">
    </div>

    <div class="btn-group">
        <button type="button" class="btn btn-danger dropdown-toggle doaction" data-type="move" data-action="trash"
            data-toggle="dropdown" aria-expanded="true"><span class="fa fa-trash"></span>
            {{ trans("buzzycontact.Trash") }} </button>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
            aria-expanded="true">{{ trans("buzzycontact.Actions") }} <span class="fa fa-caret-down ml-5"></span></button>
        <ul class="dropdown-menu pull-left">
            <li><a href="javascript:" class="doaction" data-type="do" data-action="read"><i
                        class="fa fa-check text-green"></i> {{ trans("buzzycontact.Read") }}</a></li>
            <li><a href="javascript:" class="doaction" data-type="do" data-action="unread"><i class="fa fa-check"></i>
                    {{ trans("buzzycontact.Unread") }}</a></li>
            <li><a href="javascript:" class="doaction" data-type="do" data-action="stared"><i
                        class="fa fa-star text-yellow"></i> {{ trans("buzzycontact.Stared") }}</a></li>
            <li><a href="javascript:" class="doaction" data-type="do" data-action="unstared"><i class="fa fa-star"></i>
                    {{ trans("buzzycontact.Unstared") }}</a></li>
            <li><a href="javascript:" class="doaction" data-type="do" data-action="important"><i
                        class="fa fa-flag text-red"></i> {{ trans("buzzycontact.Important") }}</a></li>
            <li><a href="javascript:" class="doaction" data-type="do" data-action="unimportant"><i
                        class="fa fa-flag"></i> {{ trans("buzzycontact.Unimportant") }}</a></li>
            <li class="divider"></li>
            <li><a href="javascript:" class="doaction" data-type="deleteperma" data-action="deleteperma"><i
                        class="fa fa-remove"></i> {{ trans("buzzycontact.Deletepermanently") }}</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
            aria-expanded="true">{{ trans("buzzycontact.Move") }} <span class="fa fa-caret-down ml-5"></span></button>
        <ul class="dropdown-menu pull-left" >
            @foreach($mailcat as $i => $category)
            <li class="{{ Request::segment(3)==$category->slug ? 'hide' : ""}}">
                <a href="javascript:" class="doaction" data-type="move" data-action="{{ $category->slug  }}"><i
                        class="fa fa-{{ $category->icon }}"></i> {{ trans("buzzycontact.towhere") }}
                    {{ $category->name }}</a></li>
            @endforeach
            @foreach($mailprivatecat as $i => $category)
            <li class="{{ Request::segment(3)==$category->slug ? 'hide' : ""}}">
                <a href="javascript:" class="doaction" data-type="move" data-action="{{ $category->slug  }}">
                <i class="fa fa-folder" style="color: {{ $category->color }} !important;"></i>
                    {{ trans("buzzycontact.towhere") }} {{ $category->name }}</a></li>
            @endforeach

        </ul>
    </div>
    <!-- /.pull-right -->
</div>
