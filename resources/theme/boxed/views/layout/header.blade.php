<header class="header">
    <div class="header__searchbar">
        <div class="container">
            <div class="header__searchbar__container">
                <form action="{{ route('search') }}" method="get">
                    <input class="header__searchbar__container__input" id="search" type="search" required="" name="q"
                        placeholder="{{ trans('index.search') }}" autocomplete="off">
                    <label class="header__searchbar__container__close material-button material-button--icon ripple"
                        for="search"><i class="material-icons">&#xE5CD;</i></label>
                </form>
            </div>
        </div>
    </div>
    <div class="header__appbar header__appbar_top_color">
        <div class="container">
            <div class="header__appbar--left">
                <div class="header__appbar--left__nav visible-mobile">
                    <i class="material-icons">menu</i>
                </div>
                <div class="header__appbar--left__logo">
                <a href="{{route('home')}}"><img class="site-logo" src="{{ asset(get_buzzy_config('sitelogo')) }}" alt=""></a>
                </div>
            </div>
            <div class="header__appbar--right hide-mobile">
                @include('_particles.header.reaction_icons')
            </div>
        </div>
    </div>
    <div class="header__appbar header__appbar_menu">
        <div class="container">
            <div class="header__appbar--left hide-mobile">
                <div class="header__appbar--left__menu ">
                    @include('_particles.header.menu')
                </div>
            </div>
            <div class="header__appbar--right">
                @include('_particles.header.search')
                <div class="header__appbar--right__notice">
                    @include('_particles.header.create_button')
                </div>
                @include('_particles.header.user')
            </div>
        </div>
    </div>

</header>

@include('layout.header_mobile')
