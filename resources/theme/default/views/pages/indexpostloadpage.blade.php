@if($lastFeatures)
    <ul class="items_lists res-lists">
        @foreach($lastFeatures as $key => $item)
            @include('._particles._lists.items_list', ['listtype' => 'bolb titb','descof' => 'on', 'featuredon' => 'on', 'linkcolor' => 'default'])

            @if($key==0)
                @foreach(\App\Widgets::where('type', 'Homencolfirst')->where('display', 'on')->get() as $widget)
                    {!! $widget->text !!}
                @endforeach
            @endif

            @if($key ==4 and  get_buzzy_config('p_buzzyvideos') == 'on')
    </ul>
    <div class="col-video">
        <div class="colheader rosy">
            <h3 class="header-title">{{ trans('index.mostrecent', ['type' => trans('index.videos') ]) }}</h3>
        </div>
        <div class="featured-videos">
            <ul class="items_lists square">
                @foreach($lastVideos->slice(0, 3) as $item)
                    @include('._particles._lists.items_list', ['listtype' => 'big_image tits','descof' => 'off', 'featuredon' => 'on', 'metaof' => 'off','video' => 'on', 'linkcolor' => 'default'])
                @endforeach
            </ul>
        </div>
    </div>
    <ul class="items_lists res-lists">
        @endif
        @if($key ==9  and  get_buzzy_config('p_buzzypolls') == 'on')
    </ul>
    <div class="col-poll">
        <div class="colheader trend">
            <h3 class="header-title">{{  trans('index.trend', ['type' => trans('index.polls') ]) }}</h3>
        </div>
        <ul class="items_lists square s-two">

            @foreach($lastPolls->slice(0, 2) as $item)
                @include('._particles._lists.items_list', ['listtype' => 'big_image bolb titb','featuredon' => 'on', 'metaof' => 'off', 'descof' => 'off', 'linkcolor' => 'default'])
            @endforeach
        </ul>

    </div>
    <ul class="items_lists res-lists">
        @endif
        @endforeach
    </ul>
    @if($lastFeatures->nextPageUrl())
        <a href="{{ $lastFeatures->nextPageUrl() }}" class="page-next btn-more"> {{ trans('updates.loadmore') }} </a>
    @endif
@endif
