<div class="message">
    @if($message->user)
    <a class="message-user-icon" href="{{ $message->user->profile_link }}">
        <img src="{{ makepreview($message->user->icon, 's', 'members/avatar') }}" alt="{{ $message->user->username }}"
            class="img-circle">
    </a>
    @endif
    <div class="message-body">
        <div class="message-meta">
            <div class="message-heading">{{ $message->user->username ?? '[deleted]' }}</div>
            <small>—</small>
            <div class="message-date">{{ $message->created_at->diffForHumans() }}</div>
            @if($message->user->id == Auth::id() && !$message->trashed() || Auth::user()->isAdmin())
            <div class="message-action">
                <a href="javacript:void(0);" class="thread-actions-button has-dropdown ripple"
                    data-target="thread-dropdown{{ $message->id }}" data-align="right-bottom">
                    <i class="material-icons">more_vert</i>
                </a>
                <div class="thread-dropdown{{ $message->id }} dropdown-container">
                    <ul>
                        @if(!$message->trashed())
                        <li class="dropdown-container__item ripple">
                            <a href="{{ action('UserMessageController@action', ['user' => $message->user->username_slug, 'id' => $message->thread->id, 'action' => 'deleteMessage', 'messageId' => $message->id]) }}"><span class="text-red">{{ trans('v4.delete_message') }}</span></a>
                        </li>
                        @endif
                        @if(Auth::user()->isAdmin())
                        @if($message->trashed())
                        <li class="dropdown-container__item ripple">
                            <a href="{{ action('UserMessageController@action', ['user' => $message->user->username_slug, 'id' => $message->thread->id, 'action' => 'retrieveMessage', 'messageId' => $message->id]) }}"><span>{{ trans('v4.retrieve_message') }}</span></a>
                        </li>
                        @endif
                        <li class="dropdown-container__item ripple">
                            <a href="{{ action('UserMessageController@action', ['user' => $message->user->username_slug, 'id' => $message->thread->id, 'action' => 'forceDeleteMessage', 'messageId' => $message->id]) }}"><span class="text-red">{{ trans('v4.force_delete_message') }}</span></a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @if($message->trashed())
            <p class="message-deleted">{{ trans('v4.message_is_deleted') }}</p>
        @else
            <p>{!! nl2br($message->body) !!}</p>
        @endif
    </div>
</div>
