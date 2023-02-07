<div class="badges">
    @include('_particles.post.categories')

    @if(get_buzzy_config('ShowBadges') !== 'no')
    @if( $post->type=='quiz')
    <div class="badge quiz">
        <div class="badge-img"></div>
    </div>
    @elseif($post->featured_at !== null)
    <div class="badge featured">
        <div class="badge-img"></div>
    </div>
    @endif
    {{ get_reaction_icon($post) }}
    @endif
</div>
