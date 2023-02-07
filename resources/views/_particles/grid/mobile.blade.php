<section class="headline visible-phone">
    <div class="slider" id="headline-slider" data-pagination="true" data-navigation="false">
        <div class="slider__list">
            @foreach($lastFeaturestop->slice(0,4) as $key => $item)
            <article class="slider__item headline__blocks headline__blocks--phone">
                <div class="headline__blocks__image" style="background-image: url({{ makepreview($item->thumb, 'b', 'posts') }})"></div>
                <a class="headline__blocks__link" href="{{ $item->post_link }}" title="{{ $item->title }}"></a>
                <header class="headline__blocks__header">
                    <h2 class="headline__blocks__header__title headline__blocks__header__title--phone">{{ $item->title }}</h2>
                    <ul class="headline__blocks__header__other">
                        <li class="headline__blocks__header__other__author">{{ $item->user ? $item->user->username : '' }}</li>
                        <li class="headline__blocks__header__other__date"><i class="material-icons">&#xE192;</i> <time datetime="{{ $item->created_at->toAtomString() }}">{{ $item->created_at->diffForHumans() }}</time></li>
                    </ul>
                </header>
            </article>
            @endforeach
        </div>
    </div>
</section>
