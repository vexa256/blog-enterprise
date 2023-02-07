 @if($entry->title)
<h2 class="sub-title">
    @if($post->ordertype != '')
    {{ $entry->order+1 }}.
    @endif

    {{ $entry->title }}
</h2>
@endif
