@php($message_count = $thread->userUnreadMessagesCount(Auth::id()))
@php($class = $message_count > 0 ? 'unreaded' : '')
<tr class="thread {{ $class }}">
    <td class="thread-body">
        <div class="thread-heading">
            <a href="{{ route('user.message.show',  ['user' => $user->username_slug, 'id' => $thread->id]) }}">
                {{ $thread->subject }}
            </a>
        </div>
        <p>{{ $thread->latestMessage ? strip_tags(Str::limit($thread->latestMessage->body, 120)) : '-' }}</p>
    </td>
    <td class="thread-message-count">
        @if ($message_count)
        <span>{{ $message_count }}</span>
        @endif
    </td>
    <td class="thread-date">{{ $thread->latestMessage ? $thread->latestMessage->created_at->diffForHumans() : '' }}</td>
    <td class="thread-participants">
        @include('_particles.user.messages._participants', ['thread' => $thread])
    </td>
    <td class="thread-actions">
        <a href="javacript:void(0);" class="thread-actions-button has-dropdown ripple"
            data-target="thread-dropdown{{ $thread->id }}" data-align="right-bottom">
            <i class="material-icons">more_vert</i>
        </a>
        <div class="thread-dropdown{{ $thread->id }} dropdown-container">
            <ul>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.message.show',  ['user' => $user->username_slug, 'id' => $thread->id]) }}">{{ trans('v4.view_messages') }}</a>
                </li>
                @if ($thread->isUnread(Auth::id()))
                <li class="dropdown-container__item ripple">
                    <a href="{{ action('UserMessageController@read', ['user' => $user->username_slug, 'id' => $thread->id]) }}">{{ trans('v4.mark_as_read') }}</a>
                </li>
                @else
                <li class="dropdown-container__item ripple">
                    <a href="{{ action('UserMessageController@unread', ['user' => $user->username_slug, 'id' => $thread->id]) }}">{{ trans('v4.mark_as_unread') }}</a>
                </li>
                @endif
                <li class="dropdown-container__item ripple">
                    <a href="{{ action('UserMessageController@action', ['user' => $user->username_slug, 'id' => $thread->id, 'action' => 'leave']) }}">{{ trans('v4.leave_convo') }}</a>
                </li>
                @if (Auth::user()->isAdmin())
                <li class="dropdown-container__item ripple">
                    <a href="{{ action('UserMessageController@action', ['user' => $user->username_slug, 'id' => $thread->id, 'action' => 'delete']) }}"><span class="text-red">{{ trans('v4.delete_convo') }}</span></a>
                </li>
                @endif
            </ul>
        </div>
    </td>
</tr>
