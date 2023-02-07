<!doctype html>
<html @include("_particles.app.html_attr")>
<head>
    @include("_particles.app.head_meta_tags")

    @include("_particles.app.head_scripts")

    @include("style")

    @yield("header")

    @include("_particles.app.head_code")
</head>
<body class="@yield('body_class')">
@include("layout.header")

@yield("content")

@include("layout.footer")

@include("_particles.app.footer_scripts")

@yield("footer")

@include("_particles.app.footer_code")
</body>
</html>


