<tr>
<td class="header">
<a href="{{ $url }}">
@php($logo_type = get_buzzy_config('MailTemplateLogoType'))
@if ($logo_type === 'image')
<img class="logo" src="{{ asset(get_buzzy_config('maillogo', get_buzzy_config('sitelogo'))) }}" alt="{{get_buzzy_config('sitename')}}">
@elseif ($logo_type === 'custom')
{{ get_buzzy_config('MailTemplateCustomTitle', get_buzzy_config('sitename')) }}
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
