@php($currentUser= get_current_comment_user())
@php($commentable = $currentUser->authenticated || get_buzzy_config('COMMENTS_GUEST_COMMENT', true))
<form action="#" method="post" data-prepend="{{isset($parent_id) ? 'no' : 'yes'}}"
    onsubmit="return false;" onSubmit="return false;">
    @if(isset($parent_id))
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    @endif
    <div class="loader-ajax"></div>
    <div class="add-comment-container">
        <img src="{{ $currentUser->icon }}" alt="{{ $currentUser->icon}}" class="usericont" />
        <div class="add-comment-form">
            <div>
                <textarea @if($commentable) class="comment_text" @else data-href="{{ route('login') }}" rel="get:Loginform" @endif
                    name="comment_text" cols="30" rows="10"
                    placeholder="{{ $commentable ? isset($parent_id) ? __("Reply to this comment.") : __('Share your thoughts about this.') : __("You must have to login to post a comment.") }}"></textarea>

                <div class="add-comment-form-actions">
                    <button type="submit" class="add_new_comment">
                        <div class="add-comment-loading"><img src="{{asset('assets/images/ajax-loader.gif')}}"></div>
                        <span>{{ isset($parent_id) ? __('Reply') : __('Comment') }}</span>
                    </button>

                    <div class="add-comment-action-inputs">
                        @if(!$currentUser->authenticated && get_buzzy_config('COMMENTS_GUEST_COMMENT', true))
                          <div class="add-comment-action-guest-inputs">
                            <span class="add-comment-action-input"><input type="text" name="user_username" placeholder="{{__('Your Name')}}"></span>
                            <span class="add-comment-action-input"><input type="text" name="user_email" placeholder="{{__('Email')}}"></span>
                            @if(get_buzzy_config('BuzzyGuestCommentCaptcha')=="on" && get_buzzy_config('reCaptchaKey') !== '')
                            <span class="add-comment-action-input">
                                <script src='https://www.google.com/recaptcha/api.js' async defer></script>
                                <div class="g-recaptcha clearfix" data-sitekey="{{  get_buzzy_config('reCaptchaKey') }}"></div>
                            </span>
                            @endif
                            </div>
                        @endif
                        @if(get_buzzy_config('COMMENTS_USE_SPOILER_COMMENT', false))
                            @php($cid = uniqid())
                            <div class="add-comment-action-spoiler-input cd-form">
                                <input id="{{$cid}}" name="spoiler" type="checkbox">
                                <label for="{{$cid}}">{{__('This comment contains spoilers?')}}</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
