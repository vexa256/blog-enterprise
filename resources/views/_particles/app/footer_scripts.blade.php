<script>
    var buzzy_base_url ="{{ route('home') }}";
    var buzzy_language ="{{ get_buzzy_config('sitelanguage', 'en_US') }}";
    var buzzy_facebook_app ="{{ get_buzzy_config('facebookapp') }}";
</script>
<script src="{{ asset('assets/js/manifest.js?v='.config('buzzy.version')) }}"></script>
<script src="{{ asset('assets/js/vendor.js?v='.config('buzzy.version')) }}"></script>
<script src="{{ asset('assets/js/app.min.js?v='.config('buzzy.version')) }}"></script>

@include('errors.swalerror')

<div id="auth-modal" class="modal auth-modal"></div>

<div id="fb-root"></div>

<div class="hide">
    <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
</div>
