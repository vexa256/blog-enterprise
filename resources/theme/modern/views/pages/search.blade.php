@extends("app")
@section('head_title', $search .' | '.get_buzzy_config('sitename') )
@section('head_description', $search )
@section("content")
<div class="buzz-container">
    <div class="global-container container">
        <div class="content">
            <div class="content-title"><h3>{{ $search }}</h3></div>
            <div class="content-body clearfix">
                <div class="content-body__detail">
                    @if($posts->total() > 0)
                        <div class="content-timeline__list">
                            @foreach($posts as $k => $item)
                                @include('pages.catpostloadpage')

                            @endforeach
                        </div>
                        <br><br>
                        <div class="center-elements">
                            {!! $posts->appends(['q' => request()->get('q')])->render() !!}
                        </div>
                    @else
                        @include('errors.emptycontent')
                    @endif
                </div>
            </div>
        </div>

        <div class="sidebar info-sidebar hide-mobile">
            @include('_particles.widget.ads', ['position' => 'CatSide', 'width' => 'auto', 'height' => 'auto'])

            @include('_particles.widget.follow')
        </div>
    </div>
</div>
@endsection
