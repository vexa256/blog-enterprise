   <header class="main-header">
        <!-- Logo -->
        <a href="{{route('admin.dashboard')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ substr(get_buzzy_config('sitename'),0,1) }}</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ get_buzzy_config('sitename') }}</b>{{ trans('admin.panel') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <!-- Sidebar toggle button-->

                <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-success pull-left mt-10"><i class="fa fa-eye"></i>  {{ trans('admin.viewsite') }}</a>
                <ul class="nav navbar-nav">
                    @if(get_multilanguage_enabled())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        {{get_language_list(get_buzzy_locale())}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach(get_buzzy_language_list_options() as $key => $lang)
                            <li><a href="{{get_multilanguage_url($key)}}">{{$lang}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="label label-success">{{ $total_approve }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">{{ $total_approve }} {{ trans('admin.waitingapprove') }}</li>
                            <li>
                                <ul class="menu">
                                @foreach($waitapprove as $qas)
                                    <li><!-- start message -->
                                        <a href="{{ $qas->post_link }}" target="_blank">
                                            <div class="pull-left">
                                                <img src="{{ makepreview($qas->thumb, 's', 'posts') }}" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                {{ $qas->title }}
                                            </h4>
                                            <p><i class="fa fa-clock-o"></i> {{ $qas->created_at->diffForHumans() }}</p>
                                        </a>
                                    </li><!-- end message -->
                                 @endforeach
                                </ul>
                            </li>
                            <li class="footer"><a href="{{route('admin.posts', ['only' => 'unapprove'])}}">{{ trans('admin.viewall') }}</a></li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ makepreview(auth()->user()->icon, 's', 'members/avatar') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{  auth()->user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ makepreview(auth()->user()->icon, 's', 'members/avatar') }}" class="img-circle" alt="User Image">
                                <p>
                                    {{  auth()->user()->username }} - Admin
                                    <small>{{ trans('admin.Membersince') }} {{  auth()->user()->created_at }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ auth()->user()->profile_link }}" class="btn btn-default btn-flat">{{ trans('admin.Profile') }}</a>
                                </div>
                                <div class="pull-right">
                                     <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ trans('admin.Signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
