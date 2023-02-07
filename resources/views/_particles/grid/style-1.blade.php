@if(count($lastFeaturestop)>0)
<section class="headline headline-style-1 hide-phone">
    <div class="global-container container">
        @foreach($lastFeaturestop->slice(0,4) as $key => $item)
        <article class="headline__blocks @if( $key == 0 ) headline__blocks--large  @elseif( $key == 1 ) headline__blocks--tall @else headline__blocks--small @endif">
            <div class="headline__blocks__image" style="background-image: url({{ makepreview($item->thumb, 'b', 'posts') }})"></div>
            <a class="headline__blocks__link" href="{{ $item->post_link }}" title="{{ $item->title }}"></a>
            <header class="headline__blocks__header">
                <h2 class="headline__blocks__header__title @if( $key == 0 ) headline__blocks__header__title--large  @elseif($key == 1) headline__blocks__header__title--tall @else headline__blocks__header__title--small @endif">{{ $item->title }}</h2>
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
