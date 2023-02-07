@extends("app")
@include("_particles.post.head")
@section('body_class', "single-post")
@section("content")
@include('_particles.post.sticky_header')
<div class="buzz-container">
    @include('_particles.widget.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])

    <div class="global-container container">
        <div class="post-content content">
            <div class="news content-detail-page">
                @include('pages._article')
            </div>
            <div class="content-spinner">
                <svg class="spinner-container" width="45px" height="45px" viewBox="0 0 52 52">
                    <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle>
                </svg>
            </div>
        </div>

        <div class="sidebar hide-mobile">
            <div class="sidebar--fixed">
                @include('_particles.widget.ads', ['position' => 'PostPageSidebar', 'width' => '300', 'height' => 'auto'])

                @include('_particles.widget.trending', ['name'=> trans('index.posts')])

                @include('_particles.widget.follow')

                @include('_particles.widget.ads', ['position' => 'Footer', 'width' => '300', 'height' => 'auto'])
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include("_particles.post.footer")
@endsection
