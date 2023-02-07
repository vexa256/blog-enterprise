@if(get_buzzy_config('DisableLanguagePicker') != "yes")
@php($languages = get_active_languages())
@if(count($languages) > 1)
<div class="language-links hor">
    <a class="button button-white" href="javascript:">
        <i class="material-icons">&#xE8E2;</i>
        <b>{{ get_language_list(get_buzzy_locale()) }}</b>
    </a>
    <ul class="sub-nav ">
        @foreach($languages as $key => $lang)
        <li>
            <a href="{{ get_language_route($key) }}" class="sub-item">{{ trans($lang) }} ({{$key}})</a>
        </li>
        @endforeach
    </ul>
</div>
@endif
@endif
