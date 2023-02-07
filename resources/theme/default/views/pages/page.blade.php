@extends("app")
@section('head_title', $page->title .' | '.get_buzzy_config('sitename') )
@section('body_class', "single-page")
@section("content")
<div class="container page-container">
    <div class="content">
        <div class="mainside">
            <h1>{{ $page->title }}</h1>
            {!! $page->text  !!}
        </div>
        <div class="sidebar">
            @include("_widgets.facebooklike")
        </div>
    </div>
</div>
@endsection
