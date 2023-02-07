@section('head_title', str_replace('"', '', $post->title). ' | '.get_buzzy_config('sitename'))
@section('og_type', 'article')
@section('head_description', str_limit(str_replace('"', '', $post->body), 150))
@section('head_keywords', collect($tags)->implode('name', ','))
@section('head_image', url(makepreview($post->thumb, 'b', 'posts')))
@section('head_url', url($post->post_link))
@section('header')
@if(get_buzzy_config('p_amp') === 'on')
@if($post->type == 'news' || $post->type == 'list' || $post->type == 'video' )
<link rel="amphtml" href="{{ url('amp/'.$post->type.'/'.$post->id) }}">
@endif
@endif
<meta property="og:image:width" content="780" />
<meta property="og:image:height" content="440" />
@if( get_buzzy_config('site_default_text_editor', 'tinymce') == 'froala')
<link rel="stylesheet" href="{{ asset('assets/plugins/froala_editor/css/froala_style.min.css')}}">
@endif
@if($has_video_player)
<link href="{{ asset('assets/plugins/video/video-js.min.css') }}" rel="stylesheet">
@endif
@endsection
