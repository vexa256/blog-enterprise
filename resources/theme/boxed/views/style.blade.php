<style>
body {font-family: {!!  get_buzzy_theme_config('sitefontfamily', get_buzzy_config('sitefontfamily')) !!};}
@if(get_buzzy_theme_config('BodyBC'))
  body { background: {{ get_buzzy_theme_config('BodyBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarBC'))
  .header { background: {{ get_buzzy_theme_config('NavbarBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarMenuBC'))
  .header__appbar_menu { background: {{ get_buzzy_theme_config('NavbarMenuBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarTBLC'))
    .header__appbar_top_color { border-top: 3px solid {{ get_buzzy_theme_config('NavbarTBLC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLC'))
    .header__appbar--left__menu__list__item > a{ color: {{ get_buzzy_theme_config('NavbarLC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLC'))
    .header__appbar--left__menu__list__item > a > i{ color: {{ get_buzzy_theme_config('NavbarLC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLHC'))
    .header__appbar--left__menu__list__item > a:hover{color: {{ get_buzzy_theme_config('NavbarLHC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLHC'))
    .header__appbar--left__menu__list__item > a:hover > i{color: {{ get_buzzy_theme_config('NavbarLHC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBBC'))
    .button.button-create {
        background: {{ get_buzzy_theme_config('NavbarCBBC') }}!important;
        color: {{ get_buzzy_theme_config('NavbarCBFC') }}!important;
        border-color: {{ get_buzzy_theme_config('NavbarCBBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBFC'))
    .button.button-create i {color: {{ get_buzzy_theme_config('NavbarCBFC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBHBC'))
    .button.button-create:hover {background: {{ get_buzzy_theme_config('NavbarCBHBC') }}!important;color: {{ get_buzzy_theme_config('NavbarCBHFC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBHFC'))
    .button.button-create:hover i {color: {{ get_buzzy_theme_config('NavbarCBHFC') }}!important;}
@endif
@if(get_buzzy_theme_config('LogoWidth'))
.header__appbar--left__logo,
.header__appbar--left__logo a,
.header__appbar--left__logo img{
 width: {{ get_buzzy_theme_config('LogoWidth') }}px;
 max-width: {{ get_buzzy_theme_config('LogoWidth') }}px;
}
@endif
@if(get_buzzy_theme_config('FooterLogoWidth'))
.footer-bottom .footer-site-logo{
 width: {{ get_buzzy_theme_config('LogoWidth') }}px;
 max-width: {{ get_buzzy_theme_config('LogoWidth') }}px;
}
@endif
</style>
