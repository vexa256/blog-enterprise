@if(count($lastFeaturestop)>0)
<section class="headline headline-style-4 hide-phone">
    <div class="global-container container">
        @foreach($lastFeaturestop->slice(0,4) as $key => $item)
        <article class="headline__blocks  headline__blocks--tall">
            <div class="headline__blocks__image" style="background-image: url({{ makepreview($item->thumb, 'b', 'posts') }})"></div>
            <a class="headline__blocks__link" href="{{ $item->post_link }}" title="{{ $item->title }}" ></a>
            <header class="headline__blocks__header">
                <h2 class="headline__blocks__header__title  headline__blocks__header__title--tall">{{ $item->title }}</h2>
                <ul class="headline__blocks__header__other">
                    <li class="headline__blocks__header__other__author">{{ $item->user ? $item->user->username : '' }}</li>
                    <li class="headline__blocks__header__other__date"><i class="material-icons"></i> <time datetime="{{ $item->created_at->toW3cString() }}">{{ $item->created_at->diffForHumans() }}</time></li>
                </ul>
            </header>
        </article>
        @endforeach
         <div class="clear"></div>
   </div>
</section>
@include('_particles.grid.mobile')
@endif
