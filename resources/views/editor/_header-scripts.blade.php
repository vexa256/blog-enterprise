<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
@if( get_buzzy_config('site_default_text_editor', 'tinymce') == 'simditor')
<link rel="stylesheet" href="{{ asset('assets/plugins/editor/simditor.css')}}">
@elseif( get_buzzy_config('site_default_text_editor') == 'froala')
<link rel="stylesheet" href="{{ asset('assets/plugins/froala_editor/css/froala_editor.pkgd.min.css')}}">
@endif
<link href="{{ asset('assets/plugins/video/video-js.min.css') }}" rel="stylesheet">
