@extends("_admin.adminapp")
@section('header')
<link rel="stylesheet" href="{{ asset('assets/admin/css/menu.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/selectize/selectize.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/selectize/selectize.default.css') }}">
@endsection
@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ trans('v4half.feeds') }}
        @if(get_multilanguage_enabled())
        &nbsp;>&nbsp; {!! get_language_list(get_buzzy_locale()) !!}
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> {{ trans('admin.dashboard') }}</a></li>
        <li><a href="#">{{ trans('v4half.feeds') }}</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-4">
            @include('_admin.pages.feeds.particles.feed-form', ['feed' => $feed])
        </div><!-- /.col -->

        <div class="col-md-8">
            <div class="dd feed">
                @include('_admin.pages.feeds.particles.feed-list', ['lists' => $feeds])
            </div>
        </div>
    </div>
</section>
@endsection
@section("footer")
<script src="{{ asset('assets/js/selectize/selectize.min.js') }}"></script>
 @php($to_user = isset($feed) ? \App\User::find($feed->post_user_id) : false)
<script>
var BuzzyRSSFeeds = {
    url: '{{action("SearchController@searchUsers")}}',
    to_user: @if($to_user) { id: {{$to_user->id}}, username: '{{$to_user->username}}' } @else 0 @endif
}
</script>
<script src="{{ asset('assets/admin/js/feeds.js') }}"></script>
@endsection
