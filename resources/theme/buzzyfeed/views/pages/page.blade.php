@extends("app")
@section('head_title', $page->title .' | '.get_buzzy_config('sitename') )
@section('body_class', "single-page")
@section("content")
<div class="buzz-container page-container">
    <div class="global-container container">
        <div class="content">
            <div class="content-title"><h1>{{ $page->title }}</h1></div>
            <div class="content-body clearfix">
                <div class="content-body__detail">
                    {!! $page->text  !!}
                </div>
            </div>
        </div>
        <div class="sidebar hide-mobile">
            @include('_particles.widget.ads', ['position' => 'PostPageSidebar', 'width' => '300', 'height' => 'auto'])

            @include('_particles.widget.follow')
        </div>
    </div>
</div>
@endsection
