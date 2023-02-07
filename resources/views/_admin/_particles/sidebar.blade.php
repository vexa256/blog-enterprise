<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ Auth::user()->username }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('admin.Online') }}</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">{{ trans('admin.MAINNAVIGATION') }}</li>
        <li class="{{request()->route()->named('admin.dashboard') ? 'active' : ''}}">
            <a href="{{  action('Admin\DashboardController@index') }}">
                <i class="fa fa-dashboard"></i> <span>{{ trans('admin.dashboard') }}</span>
            </a>
        </li>
        @if(get_buzzy_config('p_buzzycontact') == 'on')
        <li class="{{request()->route()->named('admin.mailbox') ? 'active' : ''}}">
            <a href="{{ route('admin.mailbox') }}">
                <i class="fa fa-envelope"></i> <span>{{ trans('admin.Inbox') }}</span>
                @if($unapproveinbox >0)
                <span class="pull-right badge bg-green">{{ $unapproveinbox }}</span>
                @endif
            </a>
        </li>
        @endif
        <li @if(request()->route()->named('admin.themes')) class="active" @endif>
            <a href="{{ route('admin.themes') }}">
                <i class="fa fa-eye"></i> <span>{{ trans('themes.themes') }}</span>
            </a>
        </li>
        <li @if(request()->route()->named('admin.plugins')) class="active" @endif>
            <a href="{{ route('admin.plugins') }}">
                <i class="fa fa-puzzle-piece"></i> <span>{{ trans('admin.Plugins') }}</span>
            </a>
        </li>
        <li class="treeview  @if(request()->route()->named('admin.configs')) active @endif">
            <a href="{{ route('admin.configs') }}">
                <i class="fa fa-cog"></i> <span>{{ trans('admin.Settings') }}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach ([
                '' => trans('admin.GeneralSettings'),
                'mail' => trans('admin.MailSettings'),
                'login' => trans('v4.login_settings'),
                'comment' => __('Comments Settings'),
                'social' => trans('admin.SocialMediaSettings'),
                'storage' => trans('v3.file_storage_settings'),
                'recaptcha' => trans('v4.recaptcha_settings'),
                'permissions' => __('Permission Settings'),
                'others' => trans('admin.OtherSettings'),
                'advanced' => trans('admin.AdvancedConfiguration'),
                ] as $key => $item)
                <li class="{{ request()->query('q')==$key ? 'active' : ''}}">
                    <a href="{{ route('admin.configs', ['q' => $key]) }}">
                        <i class="fa fa-caret-right"></i>
                        {{ $item }}</a>
                </li>
                @endforeach
            </ul>
        </li>
        <li @if(request()->route()->named('admin.menus') || request()->route()->named('admin.menu.show')) class="active" @endif>
            <a href="{{ route('admin.menus') }}">
                <i class="fa fa-bars"></i> <span>{{ trans('v4.menus') }}</span>
            </a>
        </li>
        <li @if(request()->route()->named('admin.categories')) class="active" @endif>
            <a href="{{ route('admin.categories') }}">
                <i class="fa fa-folder"></i>
                <span>{{ trans('admin.Categories') }}</span>
            </a>
        </li>
        @if(get_buzzy_config('p_buzzycomment')=='on')
        <li class="treeview {{request()->route()->named('admin.comments') ? 'active' : ''}}">
            <a href="users">
                <i class="fa fa-comment"></i>
                <span>{{ __('Comments') }}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{ request()->query('only')=='' ? 'active' : ''}}">
                    <a href="{{route('admin.comments')}}">
                        <i class="fa fa-caret-right"></i>
                        {{ __('Comments') }}
                    </a>
                </li>
                <li class="{{ request()->query('only')=='unapprove' ? 'active' : ''}}">
                    <a href="{{route('admin.comments',  ['only' => 'unapprove'])}}">
                        <i class="fa fa-caret-right"></i>
                        {{ trans('admin.Unapproved', ['type' => __('Comments') ]) }}
                        <small class="label pull-right bg-aqua">{{ $total_comment_approve }}</small>
                    </a>
                </li>
                <li class="{{ request()->query('only')=='deleted' ? 'active' : ''}}">
                    <a href="{{route('admin.comments',  ['only' => 'deleted'])}}">
                        <i class="fa fa-caret-right"></i>
                        {{ trans('admin.Trash', ['type' => __('Comments') ]) }}
                    </a>
                </li>
                <li class="{{ request()->query('only')=='reported' ? 'active' : ''}}">
                    <a href="{{route('admin.comments',  ['only' => 'reported'])}}">
                        <i class="fa fa-caret-right"></i>
                        {{ __('Reported :type', ['type' => __('Comments') ]) }}
                    </a>
                </li>
            </ul>
        </li>
        @endif
        <li class="{{request()->route()->named('admin.posts') && empty(request()->query('type')) && request()->query('only')=='' ? 'active': ''}}">
            <a href="{{route('admin.posts')}}">
                <i class="fa fa-book"></i>
                <span>{{ trans('admin.LatestPosts') }}</span>
            </a>
        </li>
        <li class="{{request()->route()->named('admin.posts') && empty(request()->query('type')) && request()->query('only')=='featured' ? 'active': ''}}">
            <a href="{{route('admin.posts',  ['only' => 'featured'])}}">
                <i class="fa fa-star"></i>
                <span>{{ trans('admin.FeaturesPosts') }}</span>
            </a>
        </li>
        <li class="treeview {{request()->route()->named('admin.posts') && empty(request()->query('type')) && request()->query('only')=='deleted' ? 'active': ''}}">
            <a href="{{route('admin.posts',  ['only' => 'deleted'])}}">
                <i class="fa fa-trash"></i>
                <span>{{ trans('admin.Trash', ['type' => trans('admin.Posts') ]) }}</span>
            </a>
        </li>
        <li class="treeview {{request()->route()->named('admin.posts') && empty(request()->query('type')) && request()->query('only')=='unapprove' ? 'active': ''}}">
            <a href="{{route('admin.posts',  ['only' => 'unapprove'])}}">
                <i class="fa fa-check-circle"></i>
                <span>{{ trans('admin.UnapprovedPosts') }}</span>
                <small class="label pull-right bg-aqua">{{ $total_approve }}</small>
            </a>
        </li>
        @foreach(\App\Category::byMain()->byLanguage()->byActive()->orderBy('order')->get() as $cat)
        <li class="treeview  @if(request()->query('category_id')==$cat->id) active @endif">
            <a href="{{route('admin.posts', ['type' => 'category', 'category_id' => $cat->id])}}">
                {!! '<i class="fa fa-' . config('buzzy.post_types.' . $cat->type. '.icon') . '"></i>' !!}
                <span>{{ $cat->name }}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="@if(request()->query('category_id')==$cat->id && request()->query('only')=='') active @endif">
                    <a href="{{route('admin.posts',  ['type' => 'category', 'category_id' => $cat->id])}}"><i class="fa fa-eye"></i>
                        {{ trans('admin.view', ['type' => $cat->name ]) }}
                    </a>
                </li>
                <li class="@if(request()->query('only')=='unapprove') active @endif">
                    <a href="{{route('admin.posts',  ['type' => 'category', 'category_id' => $cat->id, 'only' => 'unapprove'])}}"><i class="fa fa-check-circle"></i>{{
                        trans('admin.Unapproved', ['type' => $cat->name ]) }}
                        <small class="label pull-right bg-aqua">{{ $napprovenews }}</small>
                    </a>
                </li>
                <li class="@if(request()->query('only')=='deleted') active @endif">
                    <a href="{{route('admin.posts',  ['type' => 'category', 'category_id' => $cat->id, 'only' => 'deleted'])}}"><i class="fa fa-trash-o"></i>
                        {{ trans('admin.Trash', ['type' => $cat->name ]) }}
                    </a>
                </li>
            </ul>
        </li>
        @endforeach

        <li class="treeview {{request()->route()->named('admin.users') ? 'active' : ''}}">
            <a href="users">
                <i class="fa fa-users"></i>
                <span>{{ trans('admin.Users') }}</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{route('admin.users')}}"><i class="fa fa-caret-right"></i> {{ trans('admin.Users') }}</a></li>
                <li><a href="{{route('admin.users', ['only' => 'banned'])}}"><i class="fa fa-caret-right"></i>
                        {{ trans('admin.BannedUsers') }} </a></li>
                <li><a href="{{route('admin.users', ['only' => 'admins'])}}"><i class="fa fa-caret-right"></i>
                        {{ trans('admin.Admins') }}</a></li>
                <li><a href="{{route('admin.users', ['only' => 'staff'])}}"><i class="fa fa-caret-right"></i> {{ trans('admin.Staff') }}</a>
                </li>
            </ul>
        </li>

        <li class="{{request()->route()->named('admin.pages') ? 'active' : ''}}">
            <a href="{{route('admin.pages')}}">
                <i class="fa fa-files-o"></i>
                <span>{{ trans('admin.Pages') }}</span>
            </a>
        </li>
        <li class="treeview {{ request()->route()->named('admin.reactions') ? 'active' : ''}}">
            <a href="{{route('admin.reactions')}}">
                <i class="fa fa-thumbs-o-up"></i>
                <span>Reactions</span>
            </a>
        </li>
        <li class="treeview {{ request()->route()->named('admin.widgets') ? 'active' : ''}}">
            <a href="{{route('admin.widgets')}}">
                <i class="fa fa-plus-square"></i>
                <span>{{ trans('admin.Widgets') }}</span>
            </a>
        </li>
        <li class="treeview {{ request()->route()->named('admin.translations') ? 'active' : ''}}">
            <a href="{{route('admin.translations')}}">
                <i class="fa fa-language"></i>
                <span>{{ __('Translations') }}</span>
            </a>
        </li>
        <li class="treeview {{request()->route()->named('admin.feeds') ? 'active' : ''}}">
            <a href="{{ route('admin.feeds') }}">
                <i class="fa fa-rss"></i>
                <span>{{ trans('v4half.feeds_fetcher') }}</span>
                <span class="pull-right badge bg-red hide">{{ trans('admin.NEW') }}</span>
            </a>
        </li>
        <li class="treeview {{ request()->route()->named('admin.tools') ? 'active' : ''}}">
            <a href="{{ route('admin.tools') }}">
                <i class="fa fa-database"></i>
                <span>{{ trans('v3.tools') }}</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{route('sitemap')}}" target="_blank">
                <i class="fa fa-rss"></i>
                <span>{{ trans('admin.Sitemap') }}</span>
            </a>
        </li>
        <li>
            <a target=_blank href="https://support.akbilisim.com/docs/buzzy/installation">
                <i class="fa fa-book"></i>
                <span> {{ trans('admin.documentation') }}</span>
            </a>
        </li>
        <li class="header">{{ trans('admin.UnapprovedPosts') }}</li>
        @if(get_buzzy_config('p_buzzynews') == 'on')
            <li><a href="javascript:"><i class="fa fa-circle-o text-aqua"></i>
                <span>{{ trans('index.news') }}</span><small class="label pull-right bg-aqua">{{ $napprovenews
                    }}</small></a>
                </li>
            @endif
        @if(get_buzzy_config('p_buzzylists') == 'on')
            <li><a href="javascript:"><i class="fa fa-circle-o text-green"></i>
                <span>{{ trans('index.list') }}</span><small class="label pull-right bg-green">{{ $napprovelists
                    }}</small></a></li>
            @endif
        @if(get_buzzy_config('p_buzzyquizzes') == 'on')
            <li><a href="javascript:"><i
                    class="fa fa-circle-o text-purple"></i> <span>{{ trans('index.quiz') }}</span><small
                    class="label pull-right bg-purple">{{ $unapprovequizzes }}</small></a></li>
        @endif
        @if(get_buzzy_config('p_buzzypolls') == 'on')
            <li><a href="javascript:"><i
                    class="fa fa-circle-o text-yellow"></i> <span>{{ trans('index.poll') }}</span><small
                    class="label pull-right bg-yellow">{{ $napprovepolls }}</small></a></li>
        @endif
        @if(get_buzzy_config('p_buzzyvideos') == 'on')
            <li><a href="javascript:"><i class="fa fa-circle-o text-red"></i>
                <span>{{ trans('index.video') }}</span><small class="label pull-right bg-red">{{ $napprovevideos
                    }}</small></a></li>
        @endif
    </ul>
</section>
