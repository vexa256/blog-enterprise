@component('mail::message')
{!!__('There is a new comment for :post_title.', ['post_title' => '<b>'.$comment->post->title .'</b>'])!!}

@component('mail::button', ['url' => generate_comment_url($comment, true)])
{{__('View comment')}}
@endcomponent

@component('mail::panel')
{!! parse_comment_text($comment->comment) !!}
@endcomponent

{{__('Regards')}},<br>
{{ config('app.name') }}
@endcomponent
