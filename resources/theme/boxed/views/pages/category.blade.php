@extends("app")
@section('head_title', $category->name .' | '.get_buzzy_config('sitename') )
@section('head_description', $category->description )
@section('body_class', "category-page")
@section("content")
@include('_particles.category.header')

<div class="clearfix">
    {{ show_headline_posts($lastFeaturestop, true) }}

    @include('_particles.widget.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])

    <div class="content">
        <div class="category-timeline">
            @include('_particles.category.title')

            @if($posts->total() > 0)
            <div class="content-timeline__list clearfix">
                @foreach($posts as $k => $item)
                @include('pages.catpostloadpage')
                @endforeach
            </div>
            <div class="clear"></div>
            <div class="center-elements">
                {!! $posts->render() !!}
            </div>
            @else
            @include('errors.emptycontent')
            @endif
        </div>
    </div>
    <div class="sidebar hide-mobile">
        <div class="sidebar--fixed">
            @include('_particles.widget.ads', ['position' => 'CatSide', 'width' => 'auto', 'height' => 'auto'])

            @include('_particles.widget.trending', ['name'=> $category->name])

            @include('_particles.widget.follow')
        </div>
    </div>
</div>
@endsection
