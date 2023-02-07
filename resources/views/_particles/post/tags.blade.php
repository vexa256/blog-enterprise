@if($tags && get_buzzy_config('ShowTags') !== 'no')
<div class="content-tags hide-mobiles">
    @foreach($tags as $tag)
    @if(!empty($tag->slug))
    <span class="tagy"><a href="{{ route('tag.show', ['tag' => $tag->slug]) }}">{{$tag->name}}</a></span>
    @endif
    @endforeach
</div>
@endif
