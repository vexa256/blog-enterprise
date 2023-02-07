 @if(Auth::check())
 @php($message_count = auth()->user()->newThreadsCount())
    <div class="header__appbar--right__settings">

        <div class="header__appbar--right__settings__button has-dropdown" data-target="settings-dropdown" data-align="right-bottom">
            <div class=" material-button material-button--icon ripple ">
                <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" width="34" height="34"  alt="{{ Auth::user()->username }}">
            </div>
            @if($message_count)
                <span class="badge-count">{{$message_count}}</span>
            @endif
        </div>
        <div class="settings-dropdown dropdown-container">
            <ul>
                <li class="dropdown-container__item ripple">
                    <a href="{{ auth()->user()->profile_link }}">{{ trans('index.myprofile') }}</a>
                </li>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.messages', [ 'user' => Auth::user()->username_slug ]) }}">{{ trans('v4.messages') }}</a>
                    @if($message_count)
                        <span class="badge-count">{{$message_count}}</span>
                    @endif
                </li>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.settings', ['user' => Auth::user()->username_slug ]) }}">{{ trans('index.settings') }}</a>
                </li>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.feed', ['user' => Auth::user()->username_slug ]) }}">{{ trans('updates.feedposts') }}</a>
                </li>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.draftposts', ['user' => Auth::user()->username_slug ]) }}">{{ trans('index.draft') }}</a>
                </li>
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('user.trashpost', ['user' => Auth::user()->username_slug ]) }}">{{ trans('index.trash') }}</a>
                </li>
                @if(Auth::user()->usertype=='Admin')
                <li class="dropdown-container__item ripple">
                    <a href="{{route('admin.dashboard')}}" target="_blank">{{ trans('index.adminp') }}</a>
                </li>
                @endif
                <li class="dropdown-container__item ripple">
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ trans('index.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                </li>
            </ul>
        </div>
    </div>
@elseif(get_buzzy_config('DisableLoginIcon') !== 'yes')
    <div class="header__appbar--right__settings">
        <a class="header__appbar--right__settings__button material-button material-button--icon ripple"  href="{{ route('login') }}" rel="get:Loginform">
            <i class="material-icons">&#xE853;</i>
        </a>
    </div>
@endif
