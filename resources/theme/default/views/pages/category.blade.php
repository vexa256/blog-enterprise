@extends("app")

@section('head_title', $category->name .' | '.get_buzzy_config('sitename') )
@section('head_description', $category->description )
@section('body_class', "category-page")
@section("content")
@if(!empty($lastFeaturestop))
<div class="content shay">
    <div class="container shay">
        <div class="row homefeatures clearfix">
            <h1 class="category-head"><span>{{ $category->name }}</span> <small>|</small>
                @foreach($category->children as $cat)
                <a data-type="{{ $cat->name_slug }}" href="{{ route('category.show', ['catname' => $cat->name_slug]) }}"> {{ $cat->name }}</a>
                @endforeach
            </h1>
            <div class="pull-l">
                @foreach($lastFeaturestop->slice(0,1) as $item)
                <div class="tile tile-2">
                    @include('._particles._lists.features_list', ['descof' => 'on','metaon' => 'on'])
                </div>
                @endforeach
            </div>
            <div class="pull-l">
                @foreach($lastFeaturestop->slice(1,1) as $item)
                <div class="tile tile-1">
                    @include('._particles._lists.features_list', ['descof' => 'on','metaon' => 'on'])
                </div>
                @endforeach
            </div>
            <div class="pull-l tway">
                @foreach($lastFeaturestop->slice(2,2) as $item)
                <div class="tile tile-3">
                    @include('._particles._lists.features_list', ['metaon' => 'on'])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="content">
    <div class="container">
        <div class="mainside cat">
            @include('_particles.category.title')

            @if(count($posts) > 0)
            <div class="jscroll" data-auto="yes">
                @include('pages.catpostloadpage')
            </div>
            @else
            @include('errors.emptycontent')
            @endif
        </div>
        <div class="sidebar">
            @include('_particles.widget.ads', ['position' => 'CatSide', 'width' => 'auto', 'height' => 'auto'])

            @if($lastTrending)
            <div class="colheader">
                <h3 class="header-title">{{ trans('index.weekly') }} {!! trans('index.top', ['type' => '<span>'.$category->name.'</span>' ]) !!}</h3>
            </div>
            @include("_widgets.trendlist_sidebar")
            @endif
            @include("_widgets/facebooklike")
        </div>
    </div>
</div>
@endsection
