@extends("app")

@section('head_title', $reaction->name .' | '.get_buzzy_config('sitename') )
@section('head_description', $reaction->name )

@section("content")
<div class="content">
    @include('_particles.other.reaction-emojis')

    <div class="content-body clearfix">
        <div class="content-body__detail">
            @if($posts->total() > 0)
            <div class="content-timeline__list">
                @foreach($posts as $k => $item)
                @include('pages.catpostloadpage')
                @endforeach
            </div>
            @else
            @include('errors.emptycontent')

            @endif

            <div class="center-elements">
                {!! $posts->render() !!}
            </div>
        </div>
    </div>
</div>

<div class="sidebar info-sidebar hide-mobile">
    <div class="ads">
        @include('_particles.widget.ads', ['position' => 'CatSide', 'width' => 'auto', 'height' => 'auto'])
    </div>

    @include('_particles.widget.follow')
</div>
@endsection
