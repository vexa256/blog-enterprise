@extends("pages.user.userapp")
@section('usercontent')
<div class="user_messages_header">
    <h2><a href="{{ action('UserMessageController@index', ['user' => $user->username_slug]) }}">{{ trans('v4.messages') }}</a>
        > {{ $thread->subject }}</h2>
    <div class="user_messages_header_participants">
        @include('_particles.user.messages._participants', ['thread' => $thread])
    </div>
</div>
<div class="user_messages">
    @each('_particles.user.messages.messages', $messages, 'message')
    <div class="message-pagination">
        {!! $messages->links() !!}
    </div>
    <div class="message-reply-form clearfix">
        @include('_particles.user.messages.reply-message-form')
    </div>
</div>
@endsection
