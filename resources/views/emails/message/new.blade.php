@component('mail::message')
<p>
    {!! trans('v4.new_message_received_for') !!} <a href="{{$link}}" target="_blank">{{$subject}}</a>
</p>

@component('mail::button', ['url' => $link])
{{__('View message')}}
@endcomponent

<b>{{ trans('v4.message_from')}} {{$from}}</b><br/>

@component('mail::panel')
{!! nl2br($body) !!}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
