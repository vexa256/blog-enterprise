@if(get_buzzy_theme_config('PostPageAutoload') == 'related')
<?php
$related_type = get_buzzy_theme_config('PostRelatedType');

if($related_type == 'category'){
    $postCats = collect($categories)->take(5)->pluck('category_id')->toArray();
    $related = \App\Post::whereHas('categories', function ($q) use ($postCats) {
        return $q->whereIn('category_id', $postCats, 'or');
    });
}else{
    $postTags = collect($tags)->take(5)->pluck('id')->toArray();

    $related = \App\Post::whereHas('tags', function ($q) use ($postTags) {
        return $q->whereIn('id', $postTags, 'or');
    });
}
    $related = $related->where('posts.id', '!=', $post->id)
        ->byPublished()
        ->byLanguage()
        ->byApproved()
        ->limit(6)
        ->inRandomOrder()
        ->getCached('cpost_related_'.$post->id, now()->addMinutes(5));
?>
@if(count($related) > 0)
<br>
<div class="colheader sea">
    <h3 class="header-title">{{ trans('index.maylike') }}</h3>
</div>
<div class="sidebar-block  clearfix">
    <ol class="sidebar-mosts sidebar-mosts--readed column_list tree_column">
        @foreach($related as $itema)
            <li class="sidebar-mosts__item">
                <a class="sidebar-mosts__item__link" href="{{ $itema->post_link }}" title="{{ $itema->title }}">
                    <figure class="sidebar-mosts__item__body">
                        <div class="sidebar-mosts__item__image">
                            <img class="sidebar-mosts__item__image__item  lazyload" data-src="{{ makepreview($itema->thumb, 's', 'posts') }}" alt="{{ $itema->title }}">
                        </div>
                        <figcaption class="sidebar-mosts__item__caption">
                            <h3 class="sidebar-mosts__item__title">{{ $itema->title }}</h3>
                        </figcaption>
                        <div class="content-timeline__detail--bottom">
                            <div class="content-timeline__detail__date share_counts hide-phone">
                                <span class="facebook"><i class="buzz-icon buzz-facebook"></i>{{ isset($item->shared->facebook) ? $item->shared->facebook : '0'}}</span>
                                <span class="twitter"><i class="buzz-icon buzz-twitter"></i>{{ isset($item->shared->twitter) ? $item->shared->twitter : '0'}}</span>
                                <span class="whatsapp"><i class="buzz-icon buzz-whatsapp"></i>{{ isset($item->shared->whatsapp) ? $item->shared->whatsapp : '0'}}</span>
                            </div>
                        </div>
                    </figure>
                </a>
            </li>
        @endforeach
    </ol>
</div>
@endif
@endif
