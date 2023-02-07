@if($args['ul'])<ul class="level_root {{$args['ul_class']}}">@endif
    @foreach ($menuItems as $menu)
        @include(
        	'_particles.menu.recursive',
        	[
        		'menu'=>$menu,
        		'args'=>$args,
        		'i' => 0
        	])
    @endforeach
@if($args['ul'])</ul>@endif
