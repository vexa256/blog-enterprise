@if($post->type=='quiz')
    @include('_particles.post._entries.quiz')
@else
    @foreach($entries as $key => $entry)
        @if($entry->type=='poll')
            @include('_particles.post._entries.poll')
        @else
            @include('_particles.post._entries.default')
        @endif

        @if($key==1 and count($entries) > 3)
            @include('_particles.widget.ads', ['position' => 'Post2nd3rdentry', 'width' => '788', 'height' => 'auto'])
        @endif
    @endforeach

    @include('_particles.post.pagination')
@endif
