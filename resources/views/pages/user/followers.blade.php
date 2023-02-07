@extends("pages.user.userapp")
@section("usercontent")
<h2> {{ trans('updates.followers') }} ({{ $user->followers()->count() }})</h2>
<div class="setting-form">
    <br><br>
    @if($follows->count() > 0)
        <div class="profile-section follow-images ">
            @foreach($follows as $follow)
                @if($follow->follower)
                <a class="follow-image big" href="{{ $follow->follower->profile_link }}" title="{{ $follow->follower->username }}">
                    <img src="{{ makepreview($follow->follower->icon, 's', 'members/avatar') }}" width="90" height="90" alt="{{ $follow->follower->username }}">
                    <span>{{ $follow->follower->username }}</span>
                </a>
                @endif
            @endforeach
        </div>
        <div class="clear"></div>
        <div class="center-elements clearfix">
            {!! $follows->render() !!}
        </div>
        @else
        @include('errors.emptycontent')
    @endif

</div>
@endsection
