
@if(get_buzzy_config('ShowShareIcons') !== 'no')
<div class="content-share">
    <a class="content-share__item facebook buzz-share-button" data-share-type="facebook" data-type="news" data-id="{{ $post->id }}" data-post-url="{{ route('post.share') }}" data-title="{{ $post->title }}" data-sef="{{  $post->post_link }}">
        <div class="content-share__icon facebook-white"></div>
        @if(isset($post->shared->facebook))
            <div class="content-share__badge buzz-share-badge-facebook {{ $post->shared->facebook > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->facebook }}</div>
        @endif
    </a>
    <a class="content-share__item twitter buzz-share-button" data-share-type="twitter" data-type="news" data-id="{{ $post->id }}" data-post-url="{{ route('post.share') }}" data-title="{{ $post->title }}" data-sef="{{  $post->post_link  }}">
        <div class="content-share__icon twitter-white"></div>
        @if(isset($post->shared->twitter))
            <div class="content-share__badge buzz-share-badge-twitter {{ $post->shared->twitter > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->twitter }}</div>
        @endif
    </a>
    <a class="content-share__item pinterest buzz-share-button" data-share-type="pinterest" data-type="news" data-id="{{ $post->id }}" data-post-url="{{ route('post.share') }}" data-title="{{ $post->title }}" data-sef="{{ $post->post_link }}">
        <div class="content-share__icon pinterest-white"></div>
        @if(isset($post->shared->pinterest))
            <div class="content-share__badge buzz-share-badge-pinterest {{ $post->shared->pinterest > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->pinterest }}</div>
        @endif
    </a>
    <a class="content-share__item whatsapp buzz-share-button visible-phone" data-type="news" data-id="{{ $post->id }}" data-share-type="whatsapp" data-post-url="{{ route('post.share') }}" data-title="{{ $post->title }}" data-sef="{{  $post->post_link }}">
        <div class="content-share__icon whatsapp-white"></div>
        @if(isset($post->shared->whatsapp))
            <div class="content-share__badge buzz-share-badge-whatsapp {{ $post->shared->whatsapp > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->whatsapp }}</div>
        @endif
    </a>
    <a class="content-share__item mail buzz-share-button" data-type="news" data-id="{{ $post->id }}" data-share-type="mail" data-post-url="{{ route('post.share') }}" data-title="{{ $post->title }}" data-sef="{{   $post->post_link }}">
        <div class="content-share__icon mail-white"></div>
        @if(isset($post->shared->mail))
            <div class="content-share__badge buzz-share-badge-mail {{ $post->shared->mail > 0 ? 'is-visible': ''}} hide-phone">{{ $post->shared->mail }}</div>
        @endif
    </a>
    @if(get_buzzy_config('ShowFontSizer') !== 'no')
    <div class="content-font hide-phone">
        <div class="content-font__item has-dropdown" data-target="font-dropdown-{{ $post->id }}" data-align="left-bottom">
            <span class="content-font__icon"></span>
        </div>
        <div class="font-dropdown font-dropdown-{{ $post->id }} dropdown-container">
            <ul>
                <li class="font-dropdown__item dropdown-container__item ripple has-ripple" data-action="minus">
                    <span class="font-dropdown__item__icon font-dropdown__item__icon--minus"></span>
                </li>
                <li class="font-dropdown__item dropdown-container__item ripple has-ripple" data-action="plus">
                    <span class="font-dropdown__item__icon font-dropdown__item__icon--plus"></span>
                </li>
            </ul>
        </div>
    </div>
    @endif
    @if(isset($show_views) && get_buzzy_config('ShowViewCount') !== 'no')
     <div class="content-share__view hide-phone">
        <b>{{ $post->all_time_stats ? number_format($post->all_time_stats) : "0" }}</b><br> {{ trans('updates.views') }}
    </div>
    @endif
</div>
@endif
