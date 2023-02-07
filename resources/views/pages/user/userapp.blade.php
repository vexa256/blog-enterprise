@extends("app")
@section('head_title', $user->username . ' | ' . get_buzzy_config('sitename'))
@section('body_class', 'mode-add user-profile')
@section('content')

<div class="wt-container">

    <div class="global-container container add-container">

        <div class="profile-splash">
            <div class="profile-splash-cov"></div>
            <img src="{{ makepreview($user->splash, 'b', 'members/splash') }}" width="100%" data-big=""
                alt="{{ $user->username }}" class="profile-splash-img">
            <div class="profile-section">
                <a href="{{ $user->profile_link }}"><img
                        src="{{ makepreview($user->icon, 'b', 'members/avatar') }}" width="180" height="180"
                        data-big="" alt="{{ $user->username }}" class="profile-image"></a>
            </div>

            <div class="profile-display-name">
                <a href="{{ $user->profile_link }}">{{ $user->username }}</a>
                @if ($user->usertype == 'Admin')
                <div class="label label-admin"> {{ trans('updates.usertypeadmin') }}</div>
                @elseif($user->usertype == 'Staff')
                <div class="label label-staff"> {{ trans('updates.usertypestaff') }}</div>
                @elseif($user->usertype == 'banned')
                <div class="label label-banned"> {{ trans('updates.usertypebanned') }}</div>
                @endif
            </div>

            <div class="following_area{{$user->id}} profile-follow">
                @include('._particles.user.follow_button', ['user' => $user])
                @include('_particles.user.messages._usermessagebutton')
            </div>
        </div>

        <div class="profile-wrap">

            <div class="profile-content clearfix">

                <div class="profile-sidebar">

                    <div class="profile-section">

                        <div class="profile-details">
                            @if ($user->name)
                            <div class="profile-detail">
                                <strong>{{ trans('index.usern') }}</strong>
                                {{ $user->name }}
                            </div>
                            @endif
                            @if ($user->genre)
                            <div class="profile-detail">
                                <strong>{{ trans('index.gender') }}</strong>
                                {{ $user->genre }}
                            </div>
                            @endif
                            @if ($user->town)
                            <div class="profile-detail">
                                <strong>{{ trans('index.location') }}</strong>
                                {{ $user->town }}
                            </div>
                            @endif
                        </div>

                        @can('update', $user)
                        <a class="button button-blue button-full set-button"
                            href="{{ route('user.settings', ['user' => $user->username_slug]) }}">{{ trans('index.settings') }}</a>
                        <a class="button button-white button-full set-button"
                            href="{{ route('user.messages', ['user' => $user->username_slug]) }}">{{ trans('v4.messages') }}</a>
                        @endcan

                    </div>
                    <div class="profile-section">
                        @if (get_buzzy_config('p_buzzynews') == 'on')
                        @php($newscount = $user->posts()->byType('news')->byLanguage()->byApproved()->count())
                        <div class="profile-stat">
                            <div class="profile-stat-label"> <i class="fa fa-file-text"></i> <span
                                    class="stat-text">{{ trans('index.total', ['type' => trans('index.news')]) }}</span>
                            </div> <span class="profile-stat-count">{{ $newscount }} </span>
                        </div>
                        @endif
                        @if (get_buzzy_config('p_buzzylists') == 'on')
                        @php($listscount = $user->posts()->byType('list')->byLanguage()->byApproved()->count())
                        <div class="profile-stat">
                            <div class="profile-stat-label"> <i class="fa fa-th-list"></i> <span
                                    class="stat-text">{{ trans('index.total', ['type' => trans('index.lists')]) }}</span>
                            </div> <span class="profile-stat-count">{{ $listscount }} </span>
                        </div>
                        @endif
                        @if (get_buzzy_config('p_buzzyquizzes') == 'on')
                        @php($quizzescount = $user->posts()->byType('quiz')->byLanguage()->byApproved()->count())
                        <div class="profile-stat">
                            <div class="profile-stat-label"> <i class="fa fa-question-circle"></i> <span
                                    class="stat-text">{{ trans('index.total', ['type' => trans('buzzyquiz.quizzes')]) }}</span>
                            </div> <span class="profile-stat-count">{{ $quizzescount }} </span>
                        </div>
                        @endif
                        @if (get_buzzy_config('p_buzzypolls') == 'on')
                        @php($pollscount = $user->posts()->byType('poll')->byLanguage()->byApproved()->count())
                        <div class="profile-stat">
                            <div class="profile-stat-label"> <i class="fa fa-check-circle-o"></i> <span
                                    class="stat-text">{{ trans('index.total', ['type' => trans('index.polls')]) }}</span>
                            </div> <span class="profile-stat-count">{{ $pollscount }} </span>
                        </div>
                        @endif
                        @if (get_buzzy_config('p_buzzyvideos') == 'on')
                        @php($videoscount = $user->posts()->byType('video')->byLanguage()->byApproved()->count())
                        <div class="profile-stat">
                            <div class="profile-stat-label"> <i class="fa fa-youtube-play"></i> <span
                                    class="stat-text">{{ trans('index.total', ['type' => trans('index.videos')]) }}</span>
                            </div> <span class="profile-stat-count">{{ $videoscount }} </span>
                        </div>
                        @endif
                    </div>

                    @if ($user->about)
                    <div class="profile-section">
                        <div class="profile-sidebar-label">
                            {{ trans('index.about') }}
                        </div>
                        <p>{{ $user->about }}</p>
                    </div>
                    @endif
                    @if ($user->following()->count() > 0)
                    <div class="profile-section follow-images">
                        <div class="profile-sidebar-label">
                            {{ trans('updates.following') }}

                            <a class="more_follow"
                                href="{{ route('user.following', ['user' => $user->username_slug]) }}">{{ trans('updates.allfollow', ['count' => $user->following()->count()]) }}</a>
                        </div>
                        @foreach ($user
                        ->following()
                        ->take(12)
                        ->get()
                        as $following)

                        <a class="follow-image" href="{{ $following->followed->profile_link }}"
                            title="{{ $following->followed->username }}"><img
                                src="{{ makepreview($following->followed->icon, 's', 'members/avatar') }}" width="52"
                                height="52" alt="{{ $following->followed->username }}"></a>

                        @endforeach
                    </div>
                    @endif
                    @if ($user->followers()->count() > 0)
                    <div class="profile-section follow-images">
                        <div class="profile-sidebar-label">
                            {{ trans('updates.followers') }}
                            <a class="more_follow" href="{{route('user.followers', ['user' => $user->username_slug])}}">
                                {{ trans('updates.allfollow', ['count' => $user->followers()->count()]) }}</a>
                        </div>
                        @foreach ($user
                        ->followers()
                        ->take(12)
                        ->get()
                        as $follower)

                        <a class="follow-image" href="{{ $follower->follower->profile_link }}"
                            title="{{ $follower->follower->username }}"><img
                                src="{{ makepreview($follower->follower->icon, 's', 'members/avatar') }}" width="52"
                                height="52" alt="{{ $follower->follower->username }}"></a>

                        @endforeach
                    </div>
                    @endif

                    <div class="profile-section">
                        @if ($user->social_profiles)
                            @include('_particles.user.social_profiles', ['social_profiles' => $user->social_profiles])
                            <br>
                        @endif
                        {!! trans('index.joinedat', ['time' => $user->created_at->diffForHumans()]) !!}
                    </div>

                </div>

                <div class="profile-main">
                    @yield("usercontent")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
