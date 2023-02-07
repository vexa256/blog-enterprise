<header class="header">
    <div class="header__searchbar">
        <div class="header__searchbar__container">
            <form action="{{ route('search') }}" method="get">
                <input class="header__searchbar__container__input" id="search" type="search" required="" name="q"
                    placeholder="{{ trans('index.search') }}" autocomplete="off">
                <label class="header__searchbar__container__close material-button material-button--icon ripple"
                    for="search"><i class="material-icons">&#xE5CD;</i></label>
            </form>
        </div>
    </div>
    <div class="header__appbar">
        <div class="container">
            <div class="header__appbar--left">
                <div class="header__appbar--left__nav visible-mobile">
                    <i class="material-icons">menu</i>
                </div>
                <div class="header__appbar--left__logo">
                    @include('_particles.header.logo')
                </div>
                <div class="header__appbar--left__menu hide-mobile">
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
