@if(get_buzzy_theme_config('PostPageAutoload', 'autoload') === 'autoload')
<div class="content-header hide-mobile">
    <div class="content-header__container container">
        <div class="content-header__container__left">
            <div class="content-header__container__left__home">
                <a href="{{route('home')}}"><i class="material-icons">&#xE88A;</i></a>
            </div>
            <div class="content-header__container__left__title">{{ $post->title }}</div>
        </div>
        <div class="content-header__container__right">
        </div>
    </div>
    <div class="content-header__progress--container">
        <div class="content-header__progress--container__progress"></div>
    </div>
</div>
@endif
