 @if(!empty($entry->image))
    <div class="media">
    <img class="lazyload img-responsive" data-src="{{ makepreview($entry->image, null, 'entries') }}"
        alt="{{ $entry->title }}">
        @if($entry->source)
        <small>{!! $entry->source !!}</small>
        @endif
    </div>
@endif
