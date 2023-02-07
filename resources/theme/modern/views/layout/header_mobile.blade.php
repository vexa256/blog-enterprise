<div class="drawer">
    <div class="drawer__header clearfix">
        <div class="drawer__header__logo">
            @include('_particles.header.logo')
        </div>
        <span class="drawer__header__close"><i class="material-icons">&#xE408;</i></span>
    </div>

    <ul class="drawer__menu clearfix">
        <li class="drawer__menu__item drawer__menu__item--active">
            <a class="drawer__menu__item__link" href="{{route('home')}}">
                <span class="drawer__menu__item__icon"><i class="material-icons">&#xE88A;</i></span>
                <span class="drawer__menu__item__title">{{ trans('updates.home') }}</span>
            </a>
        </li>

        {{ menu('mobile-menu', array(
            'ul' => false,
            'li_class' => 'drawer__menu__item clearfix',
            'a_class' => 'drawer__menu__item__link',
            'icon_class' => 'drawer__menu__item__icon',
            'title_class' => 'drawer__menu__item__title'
        )) }}

        <li class=" drawer__menu__item--border">
           @include('_particles.header.reaction_icons')
        </li>
    </ul>

    <div class="footer-left">
        <div class="footer-menu clearfix">
            @php(menu('footer-menu', array(
            'ul_class' => '',
            'li_class' => 'footer-menu__item'
            )))
        </div>
        <div class="footer-copyright clearfix">
            {!! trans("updates.copyright", ['year' => now()->format('Y'), 'sitename'=>
            get_buzzy_config('sitename')]) !!}
        </div>
    </div>
</div>
