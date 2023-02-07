@if($footercode = get_buzzy_config('footercode'))
{!! rawurldecode($footercode) !!}
@endif
@if($theme_footercode = get_buzzy_theme_config('footercode'))
{!! rawurldecode($theme_footercode) !!}
@endif
@if(env('APP_DEMO'))
    @include('_particles.app.demo_selector')
@endif
