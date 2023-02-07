<div class="clearfix" itemprop="author" itemscope itemtype="https://schema.org/Person">
    @if(isset($post->user->username_slug))
    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <meta itemprop="url" content="{{ makepreview($post->user->icon , 'b', 'members/avatar') }}">
        <meta itemprop="width" content="200">
        <meta itemprop="height" content="200">
    </div>
    <meta itemprop="name" content="{{ $post->user->username }}">
    @if(isset($post->user->facebook))
    <meta itemprop="sameAs" content="{{ $post->user->facebook }}">@endif
    @if(isset($post->user->twitter))
    <meta itemprop="sameAs" content="{{ $post->user->twitter }}">@endif
    @if(get_buzzy_config('ShowAuthor') !== 'no')
    <div class="user-info {{ $post->user->genre }} answerer">
        <div class="avatar left">
            <img src="{{ makepreview($post->user->icon , 's', 'members/avatar') }}" width="45" height="45"
                alt="{{ $post->user->username }}">
        </div>
        <div class="info">
            <a itemprop="name" class="content-info__author"
                href="{{ $post->user->profile_link }}"
                target="_self">{{ $post->user->username}}</a>
            @if(get_buzzy_config('ShowAuthorBadge') !== 'no')
            @if($post->user->usertype == 'Admin')
            <div class="label label-admin ml5">{{ trans('updates.usertypeadmin') }}</div>
            @elseif($post->user->usertype == 'Staff')
            <div class="label label-staff ml5">{{ trans('updates.usertypestaff') }}</div>
            @elseif($post->user->usertype == 'banned')
            <div class="label label-banned ml5">{{ trans('updates.usertypebanned') }}</div>
            @endif
            @endif
            <div class="detail">
                @if(get_buzzy_config('ShowPublishDate') !== 'no')
                {!! trans('index.postedon', ['time' => '<time  class="content-info__date">'.$post->published_at->diffForHumans() .'</time>' ]) !!}
                @endif
                @if(get_buzzy_config('ShowUpdateDate') !== 'no' && $post->updated_at->getTimestamp() > $post->published_at->getTimestamp())
                <em class="content-info__line">—</em> {!! trans('index.updatedon', ['time' => '<time class="content-info__date">'.$post->updated_at->diffForHumans() .'</time>' ]) !!}
                @endif
            </div>
        </div>
    </div>
    @if(isset($show_views) && get_buzzy_config('ShowViewCount') !== 'no')
    <div class="content-share__view">
        <b>{{ $post->all_time_stats ? number_format($post->all_time_stats) : "0" }}</b><br>
        {{ trans('updates.views') }}
    </div>
    @endif
    @endif
    @endif
</div>
