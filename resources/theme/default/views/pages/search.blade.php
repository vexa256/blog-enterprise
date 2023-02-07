@extends("app")
@section('head_title', $search .' | '.get_buzzy_config('sitename') )
@section('head_description', $search )
@section("content")
<div class="content">
    <div class="container">
        <div class="mainside ">
            <div class="colheader none">
                {{ $search }}
            </div>
            @if(count($posts) > 0)
                <div class="jscroll" data-auto="true">
                @include('pages.catpostloadpage')
                </div>
                @else
                @include('errors.emptycontent')
            @endif
        </div>
        <div class="sidebar">
            @foreach(\App\Widgets::where('type', 'CatSide')->where('display', 'on')->get() as $widget)
                {!! $widget->text !!}
            @endforeach

            @include("_widgets/facebooklike")
        </div>
    </div>
</div>
@endsection
