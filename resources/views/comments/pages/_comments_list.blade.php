@if(count($comments) > 0)
    @foreach($comments as $comment)
        @include('comments.pages._comment', ['comment' => $comment])
    @endforeach

   @if(!isset($hideLinks))
   <div class="comment-pagination">
        {!! $comments->links() !!}
    </div>
   @endif
@endif
