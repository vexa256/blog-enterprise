 @php($social_links = collect(config('buzzy.social_links'))->filter(function($item, $provider) use ($social_profiles){
    return !empty($social_profiles[$provider]) ;
}))
<div class="social_links only_icons">
    @foreach ($social_links as $provider => $item)
    <a href="{{$social_profiles[$provider]}}" class="social-{{$provider}}" target="_blank" rel="nofollow">
        <img width="26px" src="{{ $item['icon'] }}" />
    </a>
    @endforeach
</div>
