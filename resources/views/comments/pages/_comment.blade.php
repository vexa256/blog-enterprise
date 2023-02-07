@php($currentUser=get_current_comment_user())
<div class="comment" id="comment{{ $comment->id }}">
    <img class="avatar" src="{{ $comment->userdata->icon }}" alt="{{ $comment->userdata->username }}" />
    <div class="comment-content {{ $comment->spoiler ? 'spoiler-content' : '' }}">
        <div class="comment-top">
            <span class="report">
                @if($currentUser->authenticated)
                    @if($currentUser->isAdmin || $currentUser->id === $comment->user_id)
                    @if(get_buzzy_config('COMMENTS_USER_CAN_DELETE', true))
                    <a href="javascript:void(0);" class="delete_comment" data-id="{{$comment->id}}" title="{{__('Delete Comment')}}"
                        data-confirm="{{__('Do you realy want this?')}}">
                        <span class="material-icons">delete_outline</span>
                    </a>
                    @endif
                    @if(get_buzzy_config('COMMENTS_USER_CAN_EDIT', true))
                    <a href="javascript:void(0);" class="edit_comment" data-id="{{$comment->id}}" title="{{__('Edit Comment')}}">
                        <span class="material-icons">edit</span>
                    </a>
                    @endif
                    @elseif(get_buzzy_config('COMMENTS_USER_CAN_REPORT', true))
                    <a href="javascript:void(0);" class="report_comment" data-id="{{$comment->id}}" title="{{__('Report Comment')}}">
                        <span class="material-icons">flag</span>
                    </a>
                    @endif
                @endif
            </span>
            @if($comment->userdata->link && $comment->userdata->type === 'auth')
            <a href="{{ $comment->userdata->link}}" target="_blank" data-id="{{ $comment->userdata->id }}" class="comment_user_info">
                @else
                <a href="javascript:void(0);" class="user-guest">
                    @endif
                    {{ $comment->userdata->username }}
                </a>
                @if(get_buzzy_config('COMMENTS_SHOW_USER_BADGE', true))
                    @if($comment->userdata->usertype)
                    <span class="tag {{strtolower($comment->userdata->usertype)}}">
                    @if($comment->userdata->usertype === 'Admin')
                    {{ trans('updates.usertypeadmin') }}
                    @elseif($comment->userdata->usertype === 'moderator')
                    {{ trans('updates.usertypestaff')}}
                    @elseif($comment->userdata->usertype === 'banned')
                    {{ trans('updates.usertypebanned')}}
                    @elseif($comment->userdata->usertype === 'guest')
                    {{__('Guest')}}
                    @endif
                    </span>
                    @endif
                @endif
            <a href="{{generate_comment_url($comment)}}" class="date"><span>•</span> {{ $comment->created_at->diffForHumans() }}</a>
            @if(!$comment->approve)
            <span class="date"><span>•</span> {{ trans('admin.AwaitingApproval') }}</span>
            @endif
        </div>
        <div class="comment-spoiler-text">
            {{ __('This comment contains spoilers.')}}
            <span>{{ __('Click here if you want to read.')}}</span>
        </div>
        <div class="comment-text-p">
            <p>{!! parse_comment_text($comment->comment) !!}</p>
        </div>
        <div class="comment-actions">
            <a href="javascript:void(0);" class="comment_open_reply_form" data-id="{{ $comment->isRepliesAllowed() ? $comment->id : $comment->parent_id }}" data-to="{{$comment->userdata->username}}">
                {{ __('Reply')}}
            </a>
            <span class="dot">•</span>
            <a href="javascript:void(0);" class="like comment_vote" data-id="{{ $comment->id }}" data-type="1">
                <abbr id="like_{{ $comment->id }}">{{ $comment->likes_count ?? "0" }}</abbr>
                <span class="material-icons">thumb_up_alt</span>
            </a>
            <span class="dot">|</span>
            <a href="javascript:void(0);" class="dislike comment_vote" data-id="{{ $comment->id }}" data-type="0">
                <abbr id="dislike_{{ $comment->id }}">{{ $comment->dislikes_count ?? "0" }}</abbr>
                <span class="material-icons">thumb_down_alt</span>
            </a>
        </div>

        @if($comment->isRepliesAllowed())
        @include('comments.pages._sub_comments', ['comment' => $comment])
        @endif
    </div>
</div>
