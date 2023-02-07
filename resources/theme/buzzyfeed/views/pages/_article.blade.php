<article role="main" itemscope itemtype="https://schema.org/NewsArticle" class="news__item"
    data-type="{{ $post->type }}" data-id="{{ $post->id }}" data-url="{{ $post->post_link }}"
    data-title="{{ $post->title }}" data-description="{{ $post->body }}" data-keywords="" data-share="0">
    @include("_particles.post.schema_tags")
    <div class="content-body">
        <div class="content-body--right">
            @if($post->approve == 'draft')
            <div class="label label-staff">{{ trans('updates.thisdraftpost') }}</div>
            @endif

            @include('_particles.post.categories')

            <div class="content-title">
                @include("_particles.post.title")
            </div>

            @include("_particles.post.action_buttons")

            @include("_particles.post.description")

            @include("_particles.post.featured_image")

            <div class="content-info">
                @include("_particles.post.author", ["show_categories" => true])
            </div>

            <div class="content-share-container">
                @include("_particles.post.share_icons", ["show_views" => true])
            </div>

            @include('_particles.widget.ads', ['position' => 'PostShareBw', 'width' => '788', 'height' => 'auto'])

            <div class="content-body__detail" itemprop="articleBody">
                @include("_particles.post.entries")
            </div>

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
