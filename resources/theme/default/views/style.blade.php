<style>
body {font-family: {!! get_buzzy_theme_config('sitefontfamily', get_buzzy_config('sitefontfamily')) !!};}
@if(get_buzzy_theme_config('BodyBC'))
  body { background: {{ get_buzzy_theme_config('BodyBC') }}!important;}
@endif
@if(get_buzzy_theme_config('BodyBCBM'))
  body.mode-boxed { background: {{ get_buzzy_theme_config('BodyBCBM') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarBC'))
  .header { background: {{ get_buzzy_theme_config('NavbarBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarTBLC'))
   .header { border-top: 3px solid {{ get_buzzy_theme_config('NavbarTBLC') }}!important;}
   .list-count:before { background: {{ get_buzzy_theme_config('NavbarTBLC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLC'))
    .header  a, .header a > i{ color: {{ get_buzzy_theme_config('NavbarLC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarLHC'))
   .header a:hover, .header a:hover > i{color: {{ get_buzzy_theme_config('NavbarLHC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBBC'))
    .header .create-links > a {
        background: {{ get_buzzy_theme_config('NavbarCBBC') }}!important;
        color: {{ get_buzzy_theme_config('NavbarCBFC') }}!important;
        border-color: {{ get_buzzy_theme_config('NavbarCBBC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBFC'))
    .header .create-links > a i  {color: {{ get_buzzy_theme_config('NavbarCBFC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBHBC'))
    .header .create-links > a:hover {background: {{ get_buzzy_theme_config('NavbarCBHBC') }}!important;color: {{ get_buzzy_theme_config('NavbarCBHFC') }}!important;}
@endif
@if(get_buzzy_theme_config('NavbarCBHFC'))
    .header .create-links > a:hover i {color: {{ get_buzzy_theme_config('NavbarCBHFC') }}!important;}
@endif
</style>
