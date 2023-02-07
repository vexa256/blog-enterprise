<img src="{{makepreview($user->icon, 'm', 'members/avatar')}}" width="90" class="topicon">
<div class="topcontent">
    <h3>{{$user->username}}<h3>
    <div class="infos">
        <span>{{__('Name')}}: <strong>{{$user->name ?? '-'}}</strong></span>
        @if($user->gender)<span>{{__('Gender')}}: <strong>{{$user->gender}}</strong></span>@endif
        @if($user->age)<span>{{__('Age')}}: <strong>{{$user->age}}</strong></span>@endif
        @if($user->town)<span>{{__('Town')}}: <strong>{{$user->town}}</strong></span>@endif
        <span>{{__('Last Seen')}}: <strong>{{$user->last_seen ? $user->last_seen->diffForHumans() : '-'}}</strong></span>
        <span>{{__('Joined At')}}: <strong>{{$user->created_at->diffForHumans()}}</strong></span>
    </div>
</div>

