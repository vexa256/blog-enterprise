<!doctype html>
<html @include("_particles.app.html_attr")>
<head>
    @include("_particles.app.head_meta_tags")
    <link href="https://fonts.googleapis.com/css?family={{  get_buzzy_theme_config('googlefont', get_buzzy_config('googlefont', 'Roboto')) }}" rel='stylesheet' type='text/css'>
    <link href="{{ asset(get_buzzy_config('favicon')) }}" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css?v='.config('buzzy.version')) }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/default/css/style'. get_buzzy_rtl_prefix() .'.css?v='.config('buzzy.version')) }}">
    @include("style")

    @yield("header")

    @include("_particles.app.head_code")
</head>

<body class="{{ str_replace('-', '', get_buzzy_rtl_prefix()) }} {{ get_buzzy_config('LayoutType') }} {{ get_buzzy_config('NavbarType') }} @yield("body_class") @yield("modeboxed") ">
    @include(" layout.header")

    <div class="content-wrapper" id="container-wrapper">
        @yield("content")
    </div>

    @include("layout.footer")

    <script>
        var buzzy_base_url ="{{ route('home') }}";
        var buzzy_language ="{{ get_buzzy_config('sitelanguage', 'en_US') }}";
        var buzzy_facebook_app ="{{ get_buzzy_config('facebookapp') }}";
    </script>
    <script src="{{ asset('assets/js/manifest.js?v='.config('buzzy.version')) }}"></script>
    <script src="{{ asset('assets/js/vendor.js?v='.config('buzzy.version')) }}"></script>
    <script src="{{ asset('assets/theme/default/js/app.min.js?v='.config('buzzy.version')) }}"></script>

    @yield("footer")
    @include('.errors.swalerror')

    <div id="auth-modal" class="modal auth-modal"></div>

    <div id="fb-root"></div>

    <div class="hide">
        <input name="_requesttoken" id="requesttoken" type="hidden" value="{{ csrf_token() }}" />
    </div>

    @include("_particles.app.footer_code")
</body>
</html>
