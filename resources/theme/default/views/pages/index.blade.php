@extends("app")
@section('header')
@if(get_buzzy_config('p_amp') === 'on')
<link rel="amphtml" href="{{ url('amp') }}">
@endif
@endsection
@section("content")
@unless(count($lastFeaturestop)==0)
<div class="content shay">
    <div class="container shay">
        <div class="row homefeatures clearfix">
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
@endunless
<div class="content">
    <div class="container">
        <div class="row homecolums">
            <div class="column1 ">
                <div class="colheader sea">
                    <h3 class="header-title">{{ $HomeColSec1Tit1 > "" ? $HomeColSec1Tit1 :  trans('index.latest', ['type' => trans('index.lists') ]) }}
                    </h3>
                </div>
                <div class="jscroll" data-auto="true">
                    @include('pages.indexpostloadpage')
                </div>
            </div>

            <div class="column2">
                <div class="colheader formula">
                    <h3 class="header-title">{{ $HomeColSec2Tit1 > "" ? $HomeColSec2Tit1 : trans('index.latest', ['type' => trans('index.news') ]) }}
                    </h3>
                </div>

                @include('pages.indexrightpostloadpage')

            </div>
            <div class="column3">
                @if(get_buzzy_config('HomeCol3Trends')!=='false')
                <div class="coltrend">
                    <div class="colheader trend">
                        <h3 class="header-title">{{  trans('index.trendings') }}</h3>
                    </div>
                    @if(isset($lastTrending))
                    <ul class="items_lists">
                        @foreach($lastTrending as $item)

                        @include('._particles._lists.items_list', ['listtype' => 'captionlist list-count tits', 'descof'
                        => 'off','metaof' => 'off', 'linkcolor' => 'white'])
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endif
                <div class="coltrend">
                    <div class="colheader darken">
                        <h3 class="header-title">{{ $HomeColSec3Tit1 > "" ? $HomeColSec3Tit1 : trans('index.latest', ['type' => trans('index.videos') ]) }}
                        </h3>
                    </div>
                    @if(isset($lastTrendingVideos))
                    <ul class="items_lists">
                        @foreach($lastTrendingVideos as $item)
                        @include('._particles._lists.items_list', ['listtype' => 'big_image small-h bolb tits', 'video'
                        => 'on', 'descof' => 'off', 'metaof' => 'off', 'linkcolor' =>
                        'default'])
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="colheader rosy">
                    <h3 class="header-title">{{ trans('index.connect') }}</h3>
                </div>
                @include("_widgets/facebooklike")
            </div>

        </div>
    </div>
</div>
@endsection
