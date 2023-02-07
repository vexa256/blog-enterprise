@extends("app")
@section('header')
@if(get_buzzy_config('p_amp') === 'on')
<link rel="amphtml" href="{{ url('amp') }}">
@endif
@endsection
@section("content")
<div class="buzz-container">
    {{ show_headline_posts($lastFeaturestop) }}
    @include('_particles.widget.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])

    <div class="global-container container">
        <div class="content">
            <div class="content-timeline">
                <div class="colheader sea">
                    <h3 class="header-title">{{ $HomeColSec1Tit1 > "" ? $HomeColSec1Tit1 :  trans('index.latest', ['type' => trans('index.lists') ]) }}
                    </h3>
                </div>

                @if($lastFeatures)
                <div class="content-timeline__list">
                    @include('pages.indexpostloadpage')
                </div>
                @endif
                <div class="content-timeline__more">
                    <i class="content-timeline__more__icon material-icons">&#xE5D5;</i>
                    <span class="content-timeline__more__text">{{ trans('updates.loadmore') }}</span>
                </div>
                <div class="content-spinner">
                    <svg class="spinner-container" width="45px" height="45px" viewBox="0 0 52 52">
                        <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle>
                    </svg>
                </div>
            </div>
            <div class="content-timeline_right auto_load">
                <div class="colheader formula">
                    <h3 class="header-title">{{ $HomeColSec2Tit1 > "" ? $HomeColSec2Tit1 : trans('index.latest', ['type' => trans('index.news') ]) }}
                    </h3>
                </div>
                @if(isset($lastNews))
                <div class="sidebar-block clearfix">
                    <ol class="sidebar-mosts sidebar-mosts--readed content-timeline_right__list timeline_right">
                        @include('pages.indexrightpostloadpage')
                    </ol>
                </div>
                @endif
                <div class="clear"></div>
                <div class="content-timeline_right__more">
                    <i class="content-timeline__more__icon material-icons">&#xE5D5;</i>
                    <span class="content-timeline__more__text">{{ trans('updates.loadmore') }}</span>
                </div>
                <div class="content-spinner_right clearfix">
                    <svg class="spinner-container" width="45px" height="45px" viewBox="0 0 52 52">
                        <circle class="path" cx="26px" cy="26px" r="20px" fill="none" stroke-width="4px"></circle>
                    </svg>
                </div>
            </div>
        </div>

        <div class="sidebar hide-mobile">
            <div class="sidebar--fixed">
                @include('_particles.widget.videos')

                @if(get_buzzy_config('HomeCol3Trends') != '0')
                @include('_particles.widget.trending', ['name'=> trans('index.posts')])
                @endif

                @include('_particles.widget.follow')

                @include('_particles.widget.ads', ['position' => 'Footer', 'width' => '300', 'height' => 'auto'])
            </div>
        </div>
    </div>
</div>
@endsection
