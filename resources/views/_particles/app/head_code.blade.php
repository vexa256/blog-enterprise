@if($headcode = get_buzzy_config('headcode'))
{!! rawurldecode($headcode) !!}
@endif
@if($theme_headcode = get_buzzy_theme_config('headcode'))
{!! rawurldecode($theme_headcode) !!}
@endif
