@if(get_buzzy_config('facebookapp') || get_buzzy_config('googleapp') || get_buzzy_config('twitterapp') || env('VKONTAKTE_KEY'))
<div class="login-container steps">
    <div class="connect-forms ">
        <div class="hdr">{{ trans('index.connect') }}</div>
        <div class="social_links">
            @if(get_buzzy_config('facebookapp') && get_buzzy_config('facebookappsecret'))
            <a class="social-facebook do-signup" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'facebook']) }}"><div class="buzz-icon buzz-facebook-big"></div>{{ trans('index.connectfacebok') }}</a>
            @endif
            @if(get_buzzy_config('googleapp') && get_buzzy_config('googleappsecret'))
            <a class="social-google do-signup " href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'google']) }}"><div class="buzz-icon buzz-google-big"></div>{{ trans('index.connectgoogle') }}</a>
            @endif
            @if(get_buzzy_config('twitterapp') && get_buzzy_config('twitterappsecret'))
            <a class="social-twitter do-signup " href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'twitter']) }}"><div class="buzz-icon buzz-twitter-big"></div>{{ trans('index.connecttwitter') }}</a>
            @endif
            @if(env('VKONTAKTE_KEY'))
            <a class="social-vk do-signup" href="{{ action('Auth\SocialAuthController@socialConnect', ['type' => 'vkontakte']) }}"><div class="buzz-icon buzz-vkontakte-big"></div>{{ trans('updates.connectvkontakte') }}</a>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="clearfix"></div>
@endif
