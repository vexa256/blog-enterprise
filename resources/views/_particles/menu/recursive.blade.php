<li data-id="{{$menu->id}}" class="menu_item {{$args["li_class"] ?? ''}} {{$menu->custom_class}}">
    @if (count($menu->children) > 0)
    <a href="javascript:void(0)" class="menu-link {{$args["a_class"]}} ripple has-dropdown"
        data-target="menu-dropdown{{$menu->id}}" data-align="left-bottom">
        @else
        <a href="{{ generate_menu_url($menu->url) }}" class="menu-link {{$args["a_class"] ?? ''}} ripple" target="{{ $menu->target }}">
            @endif
            <span class="menu-icon {{$args["icon_class"] ?? ''}}">{!! menu_icon($menu->icon) !!}</span>
            <span class="menu-title {{$args["title_class"] ?? ''}}">{{ $menu->title }}</span>
        </a>
        @if (count($menu->children) > 0)
        <div class="menu-dropdown{{$menu->id}} hide dropdown-container">
            <ul class="level_{{ ++$i }}">
                @foreach($menu->children as $menu)
                @include( '_particles.menu.recursive', [
                    'menu'=>$menu,
                    'args' => [
                        'li_class' => 'dropdown-container__item ripple'
                    ],
                    'i' => $i
                ])
                @endforeach
            </ul>
        </div>
        @endif
</li>
