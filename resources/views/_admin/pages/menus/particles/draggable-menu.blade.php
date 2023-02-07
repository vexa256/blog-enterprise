<ol class="dd-list">
    @foreach ($lists as $list)
    <li class='dd-item' data-order="{{$list->order}}" data-id="{{$list->id}}">
        <div class='dd-handle'>
            <span class="item-icon">{!!menu_icon($list->icon)!!} </span>
            <span class="item-title">{{$list->title}}</span>
            <span class="item-url">{{$list->url}}</span>
        </div>
        <div class='action-area'>
            <a href="{{route('admin.menu.show', ['menu' => $menu->id, 'edit' => $list->id])}}"
                class="btn btn-sm btn-info edit-info" data-id=""><i class="fa fa-pencil"></i></a>
            <a class="btn btn-sm btn-danger permanently"
                href="{{ action('Admin\MenuItemController@destroy', [$list->id]) }}" role="button" data-toggle="tooltip"
                data-original-title="{{ trans('admin.delete') }}"><i class="fa fa-times"></i></a>
        </div>
        @if(count($list->childrens) > 0)
        @include('_admin.pages.menus.particles.draggable-menu', ['lists' => $list->childrens])
        @endif
    </li>
    @endforeach
</ol>
