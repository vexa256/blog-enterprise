<div id="comments-wrapper">
     <div class="colheader sea">
        <h3 class="header-title">{{get_buzzy_config('COMMENTS_TITLE',__('Comments'))}}</h3>
    </div>

    <!-- add comment -->
    @include('comments.pages._add_comment')

    <!-- comments -->
    @include('comments.pages._comments')
</div>
