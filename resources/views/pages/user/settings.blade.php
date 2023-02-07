@extends("pages.user.userapp")
@section("usercontent")
<h2>{{ trans('index.settings') }}</h2>
@include('errors.adminlook', ['relatedid' => $user->id, 'relatedtext' => trans('index.adminnote')])
<div class="setting-form">

    {!! Form::open(array('action' => array('UserController@updatesettings', $user->username_slug), 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}

        <div class="diviner">
            <i class="fa fa-cogs"></i> {{ trans('index.account') }}
        </div>
        @if(get_buzzy_config('UserEditUsername')=='yes' or Auth::user()->usertype=='Admin')
            <div class="form-group">
                {!! Form::label('username', trans('index.username')) !!}
                {!! Form::text('username', $user->username, ['class' => 'cd-input','id' => 'username']) !!}
            </div>
        @endif
        @if(get_buzzy_config('UserEditEmail')=='yes' or Auth::user()->usertype=='Admin')
            <div class="form-group">
                {!! Form::label('email', trans('index.email')) !!}
                {!! Form::text('email', Auth::user()->isDemoAdmin() ? 'HIDDEN ON DEMO' : $user->email, ['class' => 'cd-input','id' => 'email']) !!}
               @if(get_buzzy_config('UserVerifyEmail')=='yes')
                <div class="profile-verified">
                @if ($user->hasVerifiedEmail())
                <span class="verified"><i class="material-icons">verified</i> {{__('This email is verified')}}</span>
                @else
                 <span class="not_verified"><i class="material-icons">remove_circle_outline</i> {{__('Not verified')}}</span> <a href="{{route('verification.notice')}}">{{__('Click here to verify your email address.')}}</a>
                @endif
                </div>
                @endif
            </div>
        @endif
        <div class="form-group">
            {!! Form::label('password', trans('index.password')) !!}
            {!! Form::text('password', null, ['class' => 'cd-input','id' => 'password', 'placeholder' => trans('index.onlycgange')]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('splash', trans('updates.usersplash')) !!}
            <div class="clear"></div>
            <br>
            <input type="file" accept="image/*" id="splash" name="splash">
            <br>
        </div>

        <div class="form-group">
            {!! Form::label('icon', trans('updates.useravatar')) !!}
            <div class="clear"></div>
            <img src="{{ makepreview($user->icon, 'b', 'members/avatar') }}" width="200" height="200" class="profile-image">
            <img src="{{ makepreview($user->icon, 's', 'members/avatar') }}" width="90" height="90" class="profile-image">
            <div class="clear"></div>
            <br>
            <input type="file" accept="image/*" id="icon" name="icon">
        </div>
        <div class="diviner">
            <i class="fa fa-user"></i> {{ trans('index.details') }}
        </div>
        <div class="form-group">
            {!! Form::label('name', trans('index.fullname')) !!}
            {!! Form::text('name', $user->name, ['class' => 'cd-input','id' => 'name']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('town', trans('index.location')) !!}
            {!! Form::text('town', $user->town, ['class' => 'cd-input','id' => 'town', 'placeholder' => trans('updates.live-in')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('gender', trans('index.gender')) !!}
            {!! Form::select('gender', [trans('updates.male') =>trans('updates.male'), trans('updates.female') => trans('updates.female'),  trans('updates.other')=> trans('updates.other')], isset($user->genre) ? $user->genre : null, ['id' => 'gender']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('aboutyou', trans('index.about')) !!}
            {!! Form::textarea('about', $user->about, ['id' => 'aboutyou', 'placeholder' => trans('updates.abouttext')]) !!}
        </div>

        @if(get_buzzy_config('UserAddSocial')=='yes' || Auth::user()->usertype=='Admin')
            <div class="diviner">
                <i class="fa fa-link"></i>  {{ trans('index.links') }}
            </div>
            @php($social_links = collect(config('buzzy.social_links'))->filter(function($item, $provider){
                return !in_array($provider, ['rss'], true );
                }))
            @foreach ($social_links as $provider => $social)
                <div class="form-group">
                    {!! Form::label($provider, $social['name']) !!}
                    {!! Form::text('social_profiles['.$provider.']', $user->social_profiles[$provider] ?? null, ['class' => 'cd-input','id' => $provider]) !!}
                </div>
            @endforeach
        @endif

        <div class="clear"></div>

        <div>
            <input class="button button-orange button-full" type="submit" value="{{ trans('index.savesettings') }}" >
        </div>
        <br><br>
    {!! Form::close() !!}

</div>

@endsection
