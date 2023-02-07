<div id="comments">
    @if(count($popularComments) > 0)
    <div class="comment-heading">
        <h3 class="header-title"><span>{{__('Popular Comments')}}</span></h3>
    </div>
    <div class="popular-comments">
        @foreach($popularComments as $comment)
        @include('comments.pages._comment', ['comment' => $comment])
        @endforeach
    </div>
    @endif
    <div class="comment-heading allcomments">
        <h3 class="header-title">
        @php($commentsTotal = $comments ? $comments->total() : 0)
            <span>{{trans_choice('{0} :count comment|[2,*] :count comments', $commentsTotal, ['count' => $commentsTotal])}}</span>
        </h3>
        <div class="comment-short comment_sort">
            <a href="javascript:void(0);" @if(get_buzzy_config('COMMENTS_DEFAULT_SORT')==='best' )class="active" @endif
                data-sort="best">{{__('Best')}}</a>
            <a href="javascript:void(0);" @if(get_buzzy_config('COMMENTS_DEFAULT_SORT')==='old' )class="active" @endif
                data-sort="old">{{__('Oldest')}}</a>
            <a href="javascript:void(0);" @if(get_buzzy_config('COMMENTS_DEFAULT_SORT', 'new' )==='new' )class="active" @endif
                data-sort="new">{{__('Newest')}}</a>
        </div>
    </div>
    <div class="comments">
        <div class="form-loader"></div>
        <div id="comments_list">
            @if(count($comments) > 0)
            @include('comments.pages._comments_list', ['comments' => $comments])
            @else
            <div class="no-comment">{{__('Write the first comment for this!')}}</div>
            @endif
        </div>
    </div>
</div>
