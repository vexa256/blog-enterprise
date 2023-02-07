<div class="modal-wrapper login-form">

    @include("_particles.auth._connect_buttons")

    <div class="login-container steps">

        <div class="signin-form email-form">
            <div class="hdr">{{ trans('index.loginwithemail') }}</div>
            {!! Form::open(array('action' => array('Auth\LoginController@login', 'redirectTo' =>
            Request::query('redirectTo') ), 'method' => 'POST', 'onsubmit' => 'return false')) !!}
            <div class="emailbox">
                <input name="user_email" class="cd-input" placeholder="{{ trans('index.email') }}" type="email"
                    value="{{ env('APP_DEMO') ? 'demo@admin.com' : '' }}">
            </div>
            <div class="passwordbox">
                <input name="user_password" class="cd-input" placeholder="{{ trans('index.password') }}"
                    type="password" value="{{ env('APP_DEMO') ? 'demoadmin' : '' }}">
            </div>
            <div class="under-email-signin clearfix">
                <div class="rememberme cd-form ">
                    <input class="left" name="remember" type="checkbox" value="true" checked>
                    <label class="show left" for="remember">{{ trans('index.remember') }}</label>
                </div>
                <div class="forgot-pass">
                    <a href="{{ route('password.request') }}"
                        rel="get:Passwordform">{{ trans('passwords.forgotpassword') }}</a>
                </div>
            </div>
            @if(get_buzzy_config('BuzzyLoginCaptcha')=="on" && get_buzzy_config('reCaptchaKey') !== '')
            <div class="under-email-signin clearfix">
                <label>{{ trans('buzzycontact.areyouhuman') }}</label>
                <script src='https://www.google.com/recaptcha/api.js' async defer></script>
                <div class="g-recaptcha clearfix" data-sitekey="{{  get_buzzy_config('reCaptchaKey') }}"></div>
            </div>
            @endif
            <button type="submit" class="button button-orange button-full"
                id="PostUserLogin">{{ trans('index.login') }}</button>
            {!! Form::close() !!}

        </div>
        <div class="signup-terms">
            @if(get_buzzy_config('DisableRegister') !== 'yes')
            <div class="show-connect-forms">
                {{ trans('index.youdonthaveanaccount') }} <a href="{{ route('register') }}" @if(!isset($link))
                    rel="get:Signupform" @endif>{{ trans('index.register') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
