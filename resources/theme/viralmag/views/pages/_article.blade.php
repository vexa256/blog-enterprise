<article role="main" itemscope itemtype="https://schema.org/NewsArticle" class="news__item"
    data-type="{{ $post->type }}" data-id="{{ $post->id }}" data-url="{{ $post->post_link }}"
    data-title="{{ $post->title }}" data-description="{{ $post->body }}" data-keywords="" data-share="0">
    @include("_particles.post.schema_tags")
    <div class="content-body">
        <div class="content-body--left">
            <div class="content-sticky">
                @include("_particles.post.share_icons")
            </div>
        </div>
        <div class="content-body--right">
            @if($post->approve == 'draft')
            <div class="label label-staff">{{ trans('updates.thisdraftpost') }}</div>
            @endif

            <div class="content-title">
                @include("_particles.post.badges")
                @include("_particles.post.title")
            </div>

            @include("_particles.post.action_buttons")

            <div class="content-info">
                @include("_particles.post.author", ['show_views' => true])
            </div>

            @include("_particles.post.featured_image")

            @include('_particles.widget.ads', ['position' => 'PostShareBw', 'width' => '788', 'height' => 'auto'])

            @include("_particles.post.description")

            <div class="content-body__detail" itemprop="articleBody">
                @include("_particles.post.entries")
            </div>

            <!-- tags -->
            @include("_particles.post.tags")

            @include('_particles.widget.ads', ['position' => 'PostBelow', 'width' => '788', 'height' => 'auto'])

            @include("_particles.post.author_box", ['user' => $post->user])

            @include("_particles.post.reactions")

            @include("_particles.post.related_posts")

            @include("_particles.post.comments")
        </div>
    </div>
    <div class="clear"></div>
</article>
