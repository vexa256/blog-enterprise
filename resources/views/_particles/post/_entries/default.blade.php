
<section class="entry fr-view" id="section_{{ $entry->order }}" entry="{{ $entry->id }}">
    @include('_particles.post._entries._entry_title')

    @include('_particles.post._entries._entry_image')

    @include('_particles.post._entries._entry_video')

    {!! $entry->body !!}

    @if( $entry->type=='text')
        <small>{!! $entry->source !!}</small>
    @endif

    <div class="clear"></div>
</section>
