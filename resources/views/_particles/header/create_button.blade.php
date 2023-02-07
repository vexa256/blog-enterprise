@if(get_buzzy_config('DisableCreateButton') != "yes")
 @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isStaff()) || get_buzzy_config('UserCanPost') != "no")
    <div class="create-links hor">
        <a class="header__appbar--right__settings__button  has-dropdown button button-create hide-mobile" href="{{ route('post.create') }}" >{{ trans('index.create') }}</a>
        <a class="header__appbar--right__settings__button material-button material-button--icon ripple visible-mobile" href="{{ route('post.create') }}" ><i class="material-icons">&#xE148;</i></a>
    </div>
@endif
@endif
