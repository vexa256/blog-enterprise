@extends("app")
@section('content')
<div class="buzz-container">
    <div class="global-container container">
        <div class="content not-found-content">
            <img src="{{ asset('assets/images/404.png') }}">
            <div class="clear"></div>
            <a href="{{route('home')}}" class="button button-big button-orange">{{ __('Go Back Home')}}</a>
        </div>
    </div>
</div>
@endsection
