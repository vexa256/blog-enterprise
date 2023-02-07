<div class="comment-replies" id="comment_content_{{$comment->id}}">
    <div class="form-loader"></div>
    <div id="comments_list{{$comment->id}}">
        @if($comment->replies_count > 0)
            @foreach($comment->replies as $reply)
                @include('comments.pages._comment', ['comment' => $reply])
            @endforeach
        @endif
    </div>
    @if($comment->replies_count > env('COMMENTS_SHOW_REPLY_COUNT', 3))
        <a class="load-more-comment load_more_replies" data-id="{{ $comment->id }}" href="javascript:void(0);">{{__('Load More Replies')}} <span class="fa fa-angle-down"></span></a>
    @endif
</div>
<div class="add-comment add-subcomment" id="open_add_subcomment_{{$comment->id}}">
    @include('comments.pages._add_comment_form', ['parent_id' => $comment->id])
</div>
