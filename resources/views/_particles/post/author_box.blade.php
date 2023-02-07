@if(get_buzzy_config('ShowAuthorBox', 'yes') == 'yes')
@php($use_splash = ! empty( $user->splash ) && isset($use_splash) )
	<div class="buzz-author-box center-items {{ $use_splash ? 'author-has-cover' : ''}} clearfix">
        <?php
        if ( $use_splash ) {
            $splash = makepreview($user->splash, 'b', 'members/splash');
            printf(
                '<div class="buzz-author-cover"><div class="buzz-author-splash"><div class="profile-splash-cov"></div><a class="" href="%s" title="%s"><img src="%s" data-big="" alt="admin" class="profile-splash-img"></a></div></div>',
                $user->profile_link,
                $user->username,
                $splash,
            );
        }
        ?>
        <div class="buzz-author-image">
            <a href="{{ $user->profile_link }}">
                <img src="{{ makepreview($user->icon , 'b', 'members/avatar') }}" class="avatar" width="90" height="90"
            alt="{{ $user->username }}">
            </a>
        </div>

        <div class="buzz-author-info">
            <div class="buzz-author-box-name">
                <h3 class="buzz-author-name fn">
                    <a href="{{ $post->user->profile_link }}">
                        {{ $user->username }}
                    </a>
                </h3>
                <div class="buzz-author-actions">
                    <div class="following_area{{$user->id}}">
                        @include('_particles.user.follow_button', ['user' => $user ])
                    </div>
                </div>
            </div>
            <div class="buzz-author-description">
                {{ $user->about }}
            </div>
            <div class="buzz-author-social">
                @include('_particles.user.social_profiles', ['social_profiles' => $user->social_profiles])
            </div>
        </div>
    </div>
@endif
