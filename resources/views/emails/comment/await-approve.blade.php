@component('mail::message')
{!!__('A new comment for :post_title is waiting for your approval.', ['post_title' => '<b>'.$comment->post->title .'</b>'])!!}

@component('mail::button', ['url' => generate_comment_url($comment, true)])
{{__('View comment')}}
@endcomponent

@component('mail::panel')
{!! parse_comment_text($comment->comment) !!}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
