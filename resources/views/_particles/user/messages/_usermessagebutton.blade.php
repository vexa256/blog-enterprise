@if(Auth::check() && Auth::user()->id !== $user->id)
<a class="button button-white button-small"
    href="{{ action('UserMessageController@create', [Auth::user()->username_slug]) }}?to={{$user->username_slug}}"
    rel="nofollow">
    {{ trans('v4.send_message') }}
</a>
@endif
