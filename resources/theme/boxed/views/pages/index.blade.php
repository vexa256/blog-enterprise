@extends("app")
@section('header')
@if(get_buzzy_config('p_amp') === 'on')
<link rel="amphtml" href="{{ url('amp') }}">
@endif
@endsection
@section("content")
<div class="clearfix">
    {{ show_headline_posts($lastFeaturestop) }}

    @include('_particles.widget.ads', ['position' => 'HeaderBelow', 'width' => '728', 'height' => 'auto'])

    <div class="colheader sea">
        <h3 class="header-title">{{ $HomeColSec1Tit1 > "" ? $HomeColSec1Tit1 :  trans('index.latest', ['type' => trans('index.lists') ]) }}</h3>
    </div>

    @if($lastFeatures)
    <div class="content-timeline__list clearfix">
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

    @include('_particles.widget.ads', ['position' => 'Footer', 'width' => '728', 'height' => 'auto'])
</div>

@endsection
