<section class="entry fr-view" id="section_{{ $entry->order }}" entry="{{ $entry->id }}">
    @include('_particles.post._entries._entry_title')

    @include('_particles.post._entries._entry_image')

    {!! $entry->body !!}

    <div class="clear"></div>
    <div class="answer" id="answerpoll{{ $entry->id  }}">
        @include('_particles.post._entries._poll_answers')
    </div>
    <div class="clear"></div>
</section>
