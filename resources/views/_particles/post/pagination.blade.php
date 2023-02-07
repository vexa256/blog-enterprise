@if(isset($post->pagination) and $post->pagination!=null)
<ul class="post-pagination clearfix">
    @if($entries->currentPage()!=1)
        <a href="{{ $post->post_link.'?page='.($entries->currentPage()-1)  }}" class="button button-big button-blue pull-l left">
        {!! trans('pagination.previous') !!}
        </a>
    @endif
    @if($entries->currentPage()!=$entries->lastPage())
        <a href="{{ $post->post_link.'?page='.($entries->currentPage()+1) }}" class="button button-big button-blue pull-r right">
        {!! trans('pagination.next') !!}
        </a>
    @endif
</ul>
@endif
