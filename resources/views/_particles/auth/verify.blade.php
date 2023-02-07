<div class="modal-wrapper login-form">
    <div class="login-container steps">
        <div class="signin-form email-form">
            <div class="hdr">{{ __('Verify Your Email Address') }}</div>

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p>{{ __('If you did not receive the email you can request another.') }}</p>
            <form role="form" method="POST" action="{{ route('verification.resend') }}">
                {{ csrf_field() }}
                <br>
                <button type="submit" class="button button-orange button-full">{{ __('Request another') }}</button>
            </form>
        </div>
    </div>
</div>
